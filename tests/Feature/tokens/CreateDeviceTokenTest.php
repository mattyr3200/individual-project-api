<?php

use Tests\TestCase;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDeviceTokenTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function device_can_create_token()
    {
        $this->withoutExceptionHandling();

        $device = Device::factory()->create();

        $response = $this->getJson(route("device.token.create", $device->id))->json();

        $this->assertNotNull($response['token']);

        $device->refresh();

        foreach ($device->tokens as $token) {
            $this->assertEquals(['create-trigger-log'], $token->abilities);
        }
    }
}
