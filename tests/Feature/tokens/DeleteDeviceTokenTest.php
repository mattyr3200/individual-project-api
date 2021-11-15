<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class DeleteDeviceTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_delete_device_token()
    {
        Sanctum::actingAs(User::factory()->create(), ['delete-token']);

        $device = Device::factory()->create();

        $device->createToken("TEST TOKEN", ['create-trigger-log']);

        $response = $this->deleteJson(route("device.token.destroy", $device->id));

        $response->assertNoContent();
    }

    /** @test */
    public function guest_cannot_delete_device_token()
    {
        $device = Device::factory()->create();

        $device->createToken("TEST TOKEN", ['create-trigger-log']);

        $response = $this->deleteJson(route("device.token.destroy", $device->id));

        $response->assertUnauthorized();
    }
}
