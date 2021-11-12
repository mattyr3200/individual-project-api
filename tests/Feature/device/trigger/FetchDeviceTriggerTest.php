<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Device;
use App\Models\Trigger;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchDeviceTriggerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_fetch_device_triggers()
    {
        $this->withoutExceptionHandling();

        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $trigger = Trigger::factory()->create([
            'device_id' => Device::factory()->create([
                'user_id' => $user->id,
            ])->id
        ]);

        $response = $this->getJson(route('trigger.index', ['device' => $trigger->device]))->json();

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
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $trigger = Trigger::factory()->create([
            'device_id' => Device::factory()->create([
                'user_id' => $user->id,
            ])->id
        ]);

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

    /** @test */
    public function test_guest_cannot_fetch_device_triggers()
    {
        $trigger = Trigger::factory()->create();

        $response = $this->getJson(route('trigger.index', ['device' => $trigger->device_id]));

        $response->assertUnauthorized();
    }


    public function test_guest_cannot_fetch_single_device_triggers()
    {
        $trigger = Trigger::factory()->create();

        $response = $this->getJson(route('trigger.show', $trigger->id));

        $response->assertUnauthorized();
    }

    /** @test */
    public function user_cannot_fetch_another_users_devices()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $trigger = Trigger::factory()->create();

        $response = $this->getJson(route('trigger.index', ['device' => $trigger->device_id]));

        $response->assertForbidden();
    }

    /** @test */
    public function user_cannot_fetch_another_users_device()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $trigger = Trigger::factory()->create();

        $response = $this->getJson(route('trigger.show', ['trigger' => $trigger]));

        $response->assertForbidden();
    }
}
