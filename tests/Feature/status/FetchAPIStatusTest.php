<?php

use tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchAPIStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_api_status_test()
    {
        $response = $this->getJson(route("status"));

        $this->assertEquals(now()->toDateTimeString(), $response->json()["time"]);

        $this->assertEquals(false, $response->json()["signed_in"]);
    }

    /** @test */
    public function can_fetch_api_status_with_auth_test()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->getJson(route("status"));

        $this->assertEquals(now()->toDateTimeString(), $response->json()["time"]);

        $this->assertEquals(true, $response->json()["signed_in"]);
    }

}
