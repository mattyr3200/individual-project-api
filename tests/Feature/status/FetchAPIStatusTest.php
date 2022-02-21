<?php

use tests\TestCase;
use App\Models\User;
use App\Models\Device;
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

    /** @test */
    public function can_fetch_api_status_with_device_token_test()
    {
        $device = Device::factory()->create();

        $token = $device->createToken("TEST TOKEN", ['create-trigger-log']);

        $this->assertEquals($device->id, $device->tokens[0]->tokenable_id);

        $response = $this->getJson(route('device.status'), [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ]);

        $this->assertEquals(now()->toDateTimeString(), $response->json()["time"]);

        $this->assertTrue($response->json()["signed_in"]);
    }

}
