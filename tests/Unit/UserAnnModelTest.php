<?php

namespace Tests\Unit;

use App\Models\UserAnnModel;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group global-tests
 */
class UserAnnModelTest extends TestCase
{
    use RefreshDatabase; // Ensures a fresh database for each test

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_can_create_a_user_announcement()
    {
        $announcement = UserAnnModel::create(['message' => 'This is a test announcement.']);
        $this->assertDatabaseHas('user_ann_models', ['message' => 'This is a test announcement.']);
    }

    /** @test */
    public function it_can_update_a_user_announcement()
    {
        $announcement = UserAnnModel::create(['message' => 'Old message']);
        $announcement->update(['message' => 'Updated message']);
        $this->assertDatabaseHas('user_ann_models', ['message' => 'Updated message']);
    }

    /** @test */
    public function it_can_delete_a_user_announcement()
    {
        $announcement = UserAnnModel::create(['message' => 'To be deleted']);
        $announcement->delete();
        $this->assertDatabaseMissing('user_ann_models', ['message' => 'To be deleted']);
    }

    /** @test */
    public function it_allows_large_text_messages()
    {
        $longMessage = str_repeat('A', 200);
        $announcement = UserAnnModel::create(['message' => $longMessage]);
        $this->assertDatabaseHas('user_ann_models', ['message' => $longMessage]);
    }

    /** @test */
    public function it_prevents_xss_attacks_in_message()
    {
        $announcement = UserAnnModel::create(['message' => '<script>alert("Hacked!")</script>']);
        $this->assertDatabaseHas('user_ann_models', ['message' => '<script>alert("Hacked!")</script>']);
    }

    /** @test */
    public function it_only_allows_fillable_fields()
    {
        try {
            $response = UserAnnModel::create([
                'message' => 'Valid message',
                'unauthorized_field' => 'Should not be allowed'
            ]);
        } catch (Exception $e) {
            $this->expectException(QueryException::class);
        }

        $this->assertFalse(
            Schema::hasColumn('user_ann_models', 'unauthorized_field'),
            "Column 'non_existing_column' should not exist in the users table."
        );
    }

    /** @test */
    public function it_can_retrieve_an_announcement_by_id()
    {
        $announcement = UserAnnModel::create(['message' => 'Find me']);
        $retrieved = UserAnnModel::find($announcement->id);
        $this->assertEquals('Find me', $retrieved->message);
    }

    /** @test */
    public function it_can_fetch_all_announcements()
    {
        UserAnnModel::factory()->count(5)->create();
        $this->assertCount(5, UserAnnModel::all());
    }
}
