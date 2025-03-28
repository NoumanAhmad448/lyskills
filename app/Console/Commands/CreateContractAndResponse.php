<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateContractAndResponse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:contract-response {name : The name of the contract and response (e.g., Auth)}
                {--provider=HomeController1Provider : The name of the service provider to bind the contract and response}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Contract and Response class and bind them in a service provider.';

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $contractName = "{$name}Contract";
        $responseName = "{$name}Response";

        // Create Contract
        $this->createContract($contractName);

        // Create Response
        $this->createResponse($responseName, $contractName);

        // Bind Contract and Response in the service provider
        $this->bindContractAndResponse($contractName, $responseName);

        $this->info("Contract, Response, and binding created successfully!");
    }

    /**
     * Create the Contract class.
     *
     * @param string $contractName
     */
    protected function createContract($contractName)
    {
        $stub = $this->getStub('contract');
        $path = app_path("Http/Contracts/{$contractName}.php");

        $this->makeDirectory($path);

        $this->files->put(
            $path,
            str_replace('{{ContractName}}', $contractName, $stub)
        );

        $this->info("Contract created: {$contractName}");
    }

    /**
     * Create the Response class.
     *
     * @param string $responseName
     * @param string $contractName
     */
    protected function createResponse($responseName, $contractName)
    {
        $stub = $this->getStub('response');
        $path = app_path("Http/Responses/{$responseName}.php");

        $this->makeDirectory($path);

        $this->files->put(
            $path,
            str_replace(
                ['{{ResponseName}}', '{{ContractName}}'],
                [$responseName, $contractName],
                $stub
            )
        );

        $this->info("Response created: {$responseName}");
    }

    /**
     * Bind the Contract and Response in the service provider.
     *
     * @param string $contractName
     * @param string $responseName
     */
    protected function bindContractAndResponse($contractName, $responseName)
    {
        $providerName = $this->option('provider');
        $providerPath = app_path("Providers/{$providerName}.php");


        if (!$this->files->exists($providerPath)) {
            $this->error("Service provider not found: HomeController1Provider");
            return;
        }

        $providerContent = $this->files->get($providerPath);

        $bindingCode = "\$this->app->bind(\\App\\Http\\Contracts\\{$contractName}::class,function (\$app, \$data){
                return new \\App\\Http\\Responses\\{$responseName}(\$data['data']);
                });";


        if (Str::contains($providerContent, $bindingCode)) {
            $this->info("Binding already exists in the service provider.");
            return;
        }

        // Append the binding to the register method
        $providerContent = preg_replace_callback(
            '/public function register\(\)\s*\{([^\}]*)\}/',
            function ($matches) use ($bindingCode) {
                // Append the binding code inside the register method
                return "public function register()\n    {\n{$matches[1]}        {$bindingCode}\n    }";
            },
            $providerContent
        );



        $this->files->put($providerPath, $providerContent);

        $this->info("Binding added to the service provider {$providerPath}.");
    }

    /**
     * Get the stub file for the generator.
     *
     * @param string $type
     * @return string
     */
    protected function getStub($type)
    {
        return $this->files->get(__DIR__ . "/stubs/{$type}.stub");
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }
    }
}
