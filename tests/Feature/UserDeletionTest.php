<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Support\Facades\Hash;


/**
 * @group global-tests
 */
class UserDeletionTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_user_can_delete_account_with_password_confirmation()
    {
        $password = 'password'; // Ensure this is the actual password
        // Create a user
        $user = User::factory()->create([
            'password' => Hash::make($password)
        ]);

        // Act as the logged-in user
        $this->actingAs($user);

        // Password for confirmation

        // Simulate the user deleting their account using Livewire
        $response = Livewire::test('profile.delete-user-form') // Use the actual Livewire component name here
            ->set('password', $password) // Set the password input
            ->call('deleteUser'); // Call the deleteUser method

        // Assert the user is deleted from the database
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_user_cannot_delete_account_with_incorrect_password()
    {
        // Create a user
        $user = User::factory()->create();

        // Act as the logged-in user
        $this->actingAs($user);

        // Incorrect password
        $incorrectPassword = 'wrongpassword';

        // Simulate the user trying to delete their account with the wrong password
        $response = Livewire::test('profile.delete-user-form') // Use the actual Livewire component name here
            ->set('password', $incorrectPassword) // Set the incorrect password
            ->call('deleteUser'); // Call the deleteUser method

        // Assert the user is still in the database (account wasn't deleted)
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
