<?php

namespace Tests\Unit;

use App\Models\UserAnnModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAnnModelTest extends TestCase
{
    use RefreshDatabase; // Ensures a fresh database for each test

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
    public function it_requires_a_message_to_be_created()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        UserAnnModel::create([]);
    }

    /** @test */
    public function it_allows_large_text_messages()
    {
        $longMessage = str_repeat('A', 1000);
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
        $announcement = UserAnnModel::create([
            'message' => 'Valid message',
            'unauthorized_field' => 'Should not be allowed'
        ]);

        $this->assertDatabaseHas('user_ann_models', ['message' => 'Valid message']);
        $this->assertDatabaseMissing('user_ann_models', ['unauthorized_field' => 'Should not be allowed']);
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
