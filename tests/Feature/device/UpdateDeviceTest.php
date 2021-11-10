<?php

use Tests\TestCase;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_update_device()
    {
        $device = Device::factory()->create();

        $response = $this->putJson(route('device.update', ['device' => $device->id]), [
            'name' => "TEST NAME"
        ])->json();

        $this->assertCount(3, $response);
        $this->assertSame("TEST NAME", $response['name']);
        $this->assertSame("Home", $response['site']);
        $this->assertSame($device->id, $response['id']);
    }
}
