<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Device;
use App\Models\Trigger;
use App\Models\TriggerLog;
use App\Notifications\TriggerLogCreatedNotification;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CreateTriggerLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function device_can_create_trigger_log()
    {
        $trigger = Trigger::factory()->create([
            'trigger_voltage' => true
        ]);

        $token = $trigger->device->createToken("TEST TOKEN", ['create-trigger-log']);

        $this->assertEquals($trigger->device->id, $trigger->device->tokens[0]->tokenable_id);

        $response = $this->postJson(route('trigger.log.store'), [
            "voltage" => true, //High Voltage
            "wire" => $trigger->wire
        ], [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ]);

        $response->assertCreated();
    }

    /** @test */
    public function device_cannot_create_trigger_log_when_tigger_doesnt_exist()
    {
        $device = Device::factory()->create();

        $token = $device->createToken("TEST TOKEN", ['create-trigger-log']);

        $response = $this->postJson(route('trigger.log.store'), [
            "voltage" => true, //High Voltage
            "wire" => 1
        ], [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ]);

        $this->assertCount(0, Trigger::all());
        $this->assertCount(0, TriggerLog::all());
        $this->assertCount(1, Device::all());
        $response->assertOk();
        $response->assertSeeText('No Trigger Set Up');
    }

    /** @test */
    public function device_cannot_create_trigger_log_when_no_device_has_no_token()
    {
        Device::factory()->create();

        $response = $this->postJson(route('trigger.log.store'), [
            "voltage" => true, //High Voltage
            "wire" => 1
        ]);

        $this->assertCount(0, Trigger::all());
        $this->assertCount(0, TriggerLog::all());
        $this->assertCount(1, Device::all());
        $response->assertUnauthorized();
    }

    /** @test */
    public function device_can_create_log_url()
    {
        $trigger = Trigger::factory()->create([
            'trigger_voltage' => true
        ]);

        $token = $trigger->device->createToken("TEST TOKEN", ['create-trigger-log']);

        $this->assertEquals($trigger->device->id, $trigger->device->tokens[0]->tokenable_id);

        $response = $this->postJson("/api/log", [
            "voltage" => true, //High Voltage
            "wire" => $trigger->wire
        ], [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ]);

        $response->assertCreated();
    }

    /** @test */
    public function notification_is_sent_on_trigger_log_creation_when_alarm_is_armed()
    {
        Notification::fake();

        $trigger = Trigger::factory()->create([
            'trigger_voltage' => true,
            'email_notify' => true
        ]);

        $trigger->device->update(["is_armed" => true]);

        $token = $trigger->device->createToken("TEST TOKEN", ['create-trigger-log']);

        $this->assertEquals($trigger->device->id, $trigger->device->tokens[0]->tokenable_id);

        Notification::assertNothingSent();

        $response = $this->postJson("/api/log", [
            "voltage" => true, //High Voltage
            "wire" => $trigger->wire
        ], [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ]);

        Notification::assertSentTo(
            [$trigger->device->user],
            function (TriggerLogCreatedNotification $notification, $channels) use ($trigger) {
                return $notification->triggerLog->trigger->id === $trigger->id;
            }
        );

        $response->assertCreated();
    }

    /** @test */
    public function notification_is_not_sent_on_trigger_log_creation_when_alarm_is_un_armed()
    {
        Notification::fake();

        $trigger = Trigger::factory()->create([
            'trigger_voltage' => true,
            'email_notify' => true
        ]);

        $token = $trigger->device->createToken("TEST TOKEN", ['create-trigger-log']);

        $this->assertEquals($trigger->device->id, $trigger->device->tokens[0]->tokenable_id);

        Notification::assertNothingSent();

        $response = $this->postJson("/api/log", [
            "voltage" => true, //High Voltage
            "wire" => $trigger->wire
        ], [
            'Authorization' => 'Bearer ' . $token->plainTextToken
        ]);

        Notification::assertNothingSent();

        $response->assertCreated();
    }
}
