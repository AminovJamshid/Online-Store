<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_list_can_be_fetched()
    {
        User::factory()->count(5)->create();

        $response = $this->get(route('users.index'));

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    public function test_user_can_be_created()
    {
        $userData = [
            'name' => 'Jamshid',
            'email' => 'jamshid@gmail.com',
            'password' => '1234',
        ];

        $response = $this->post(route('users.store'), $userData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'jamshid@gmail.com']);
    }

    public function test_user_can_be_updated()
    {
        $user = User::factory()->create();

        $response = $this->put(route('users.update', $user->id), [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['name' => 'Updated Name']);
    }

    public function test_user_can_be_deleted()
    {
        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user->id));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_user_login_fails_with_wrong_credentials()
    {
        User::factory()->create(['email' => 'jamshid@gmail.com', 'password' => Hash::make('1234')]);

        $response = $this->post(route('users.login'), [
            'email' => 'jamshid@gmail.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }
}
