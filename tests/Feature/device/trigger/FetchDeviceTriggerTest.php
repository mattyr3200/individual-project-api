<?php

use App\Models\Trigger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchDeviceTriggerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_fetch_device_triggers()
    {
        $trigger = Trigger::factory()->create();

        $response = $this->getJson(route('trigger.index'))->json();

        $this->assertCount(1, $response);
        $this->assertCount(6, $response[0]);

        $this->assertEquals($trigger->id, $response[0]['id']);
        $this->assertEquals($trigger->name, $response[0]['name']);
        $this->assertEquals($trigger->description, $response[0]['description']);
        $this->assertEquals($trigger->wire, $response[0]['wire']);
        $this->assertEquals($trigger->trigger_voltage, $response[0]['trigger_voltage']);
        $this->assertEquals($trigger->id, $response[0]['id']);
        $this->assertEquals($trigger->device->id, $response[0]['device']['id']);
    }

    /** @test */
    public function test_user_can_fetch_single_device_triggers()
    {
        $trigger = Trigger::factory()->create();

        $response = $this->getJson(route('trigger.show', $trigger->id))->json();

        $this->assertCount(6, $response);

        $this->assertEquals($trigger->id, $response['id']);
        $this->assertEquals($trigger->name, $response['name']);
        $this->assertEquals($trigger->description, $response['description']);
        $this->assertEquals($trigger->wire, $response['wire']);
        $this->assertEquals($trigger->trigger_voltage, $response['trigger_voltage']);
        $this->assertEquals($trigger->id, $response['id']);
        $this->assertEquals($trigger->device->id, $response['device']['id']);
    }
}
