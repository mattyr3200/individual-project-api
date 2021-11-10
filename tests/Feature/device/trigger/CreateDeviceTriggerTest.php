<?php

use Tests\TestCase;
use App\Models\Device;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDeviceTriggerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_create_trigger()
    {
        $trigger = $this->postJson(route('trigger.store'), [
            "name" => "TEST NAME",
            "description" => "TEST DESCRIPTION",
            "wire" => "1",
            "trigger_voltage" => true,
            "device_id" => $deviceId = Device::factory()->create()->id,
        ])->json();

        $this-> assertCount(6, $trigger);

        $this->assertSame("TEST NAME", $trigger['name']);
        $this->assertSame("TEST DESCRIPTION", $trigger['description']);
        $this->assertSame("1", $trigger['wire']);
        $this->assertTrue($trigger['trigger_voltage']);
        $this->assertsame($deviceId, $trigger['device']['id']);
    }
}
