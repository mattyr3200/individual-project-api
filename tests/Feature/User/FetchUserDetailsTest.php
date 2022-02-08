<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchUserDetailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_user_details()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->getJson(route("user"));

        $this->assertEquals($user->name, $response->json()["name"]);
        $this->assertEquals($user->id, $response->json()["id"]);
        $this->assertEquals($user->email, $response->json()["email"]);
    }
}
