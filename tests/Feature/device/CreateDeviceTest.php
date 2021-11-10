<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_create_device()
    {
        $device = $this->postJson(route('device.store'), [
            'name' => "TEST NAME",
            'site' => "Default",
        ])->json();

        $this->assertCount(3, $device);
        $this->assertSame("TEST NAME", $device['name']);
        $this->assertSame("Default", $device['site']);
        $this->assertNotNull($device['id']);
    }
}
