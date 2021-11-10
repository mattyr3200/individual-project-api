<?php

use Tests\TestCase;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_fetch_devices()
    {
        $device = Device::factory()->create();

        $response = $this->getJson(route('device.index'))->json();

        $this->assertCount(1, $response);
        $this->assertCount(3, $response[0]);

        $this->assertSame($device->name, $response[0]['name']);
        $this->assertSame($device->site, $response[0]['site']);
        $this->assertSame($device->id, $response[0]['id']);
    }

    /** @test */
    public function test_user_can_fetch_singular_device()
    {
        $device = Device::factory()->create();

        $response = $this->getJson(route('device.show', ['device' => $device]))->json();

        $this->assertCount(3, $response);

        $this->assertSame($device->name, $response['name']);
        $this->assertSame($device->site, $response['site']);
        $this->assertSame($device->id, $response['id']);
    }
}
