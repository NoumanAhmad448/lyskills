<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Collection;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\TestCase as BaseTestCase;
use Tests\Browser\Traits\UserAuthentication;
use Laravel\Dusk\Browser;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, UserAuthentication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     */
    protected $user;
    public function setUp(): void
    {
        parent::setUp();
        // Add any setup logic here (e.g., database seeding).
        Artisan::call('migrate:fresh');
        // Artisan::call('migrate:fresh --seed');

        $this->user = User::factory()->create([
            'email' => fake()->unique()->email(),
        ]);
    }

    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
            return $items->merge([
                '--disable-gpu',
                '--headless=new',
            ]);
        })->all());

        debug_logs($options);
        return RemoteWebDriver::create(
            'http://localhost:59425' ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     */
    protected function hasHeadlessDisabled(): bool
    {
        return isset($_SERVER['DUSK_HEADLESS_DISABLED']) ||
            isset($_ENV['DUSK_HEADLESS_DISABLED']);
    }

    /**
     * Determine if the browser window should start maximized.
     */
    protected function shouldStartMaximized(): bool
    {
        return isset($_SERVER['DUSK_START_MAXIMIZED']) ||
            isset($_ENV['DUSK_START_MAXIMIZED']);
    }

    /**
     * Tear down Dusk test execution.
     */
    public function tearDown(): void
    {
        // Add any teardown logic here (e.g., database cleanup).
        parent::tearDown();
        Artisan::call('migrate:reset');
    }

    /**
     * Capture failures for the given browser.
     */
    protected function captureFailuresFor($browser)
    {
        if ($browser instanceof Browser) {

            $browser->screenshot('failure-' . $this->getName()); // Save screenshot with test name
            parent::captureFailuresFor($browser);
        }
    }
}
