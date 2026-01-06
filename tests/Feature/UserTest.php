<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_users(): void
    {
        User::factory()
            ->count(5)
            ->create();

        $response = $this->get('/api/users');

        $response->assertJsonCount(5);
        $response->assertStatus(200);
    }

    public function test_get_users_with_eq_filter(): void
    {
        User::factory()
            ->count(5)
            ->create();

        $user = User::factory()->create([
            'name' => 'testName',
        ]);

        $response = $this->get('/api/users?filter[name][_eq]=testName');

        $response->assertJsonCount(1);
        $response->assertExactJson([$user->toArray()]);
        $response->assertStatus(200);
    }

        public function test_get_users_with_neq_filter(): void
    {
        User::factory()
            ->count(5)
            ->create();

        User::factory()->create([
            'name' => 'testName',
        ]);

        $response = $this->get('/api/users?filter[name][_neq]=testName');

        $response->assertJsonCount(5);
        $response->assertStatus(200);
    }
}
