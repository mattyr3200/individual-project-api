<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Device;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDeviceTriggerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_create_trigger()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $trigger = $this->postJson(route('trigger.store'), [
            "name" => "TEST NAME",
            "description" => "TEST DESCRIPTION",
            "wire" => "1",
            "email_notify" => true,
            "trigger_voltage" => true,
            "device_id" => $deviceId = Device::factory()->create()->id,
        ])->json();

        $this->assertCount(7, $trigger);

        $this->assertSame("TEST NAME", $trigger['name']);
        $this->assertSame("TEST DESCRIPTION", $trigger['description']);
        $this->assertSame("1", $trigger['wire']);
        $this->assertTrue($trigger['trigger_voltage']);
        $this->assertTrue($trigger['email_notify']);
        $this->assertsame($deviceId, $trigger['device']['id']);
    }
}
