<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_connection_success()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->get('/home')
            ->assertStatus(200);
    }

    public function test_connection_failed()
    {
        $this
            ->get('/home')
            ->assertStatus(302);
    }

    public function test_user_exists()
    {
        $user = factory(\App\User::class)->create();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }

}
