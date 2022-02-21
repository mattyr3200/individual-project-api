<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Device;
use App\Models\Trigger;
use App\Models\TriggerLog;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchTriggerLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function device_fetch_trigger_logs()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $trigger = Trigger::factory()->create([
            'device_id' => Device::factory()->create(['user_id' => $user->id])
        ]);

        TriggerLog::factory(3)->create([
            'trigger_id' => $trigger->id
        ]);

        $response = $this->getJson(route('trigger.log.index', $trigger->device->id));

        $response->assertJsonCount(3);

        $this->assertArrayHasKey("log_id",  $response->json()[0]);
        $this->assertArrayHasKey("name",  $response->json()[0]);
        $this->assertArrayHasKey("description",  $response->json()[0]);
        $this->assertArrayHasKey("wire",  $response->json()[0]);
        $this->assertArrayHasKey("trigger_voltage",  $response->json()[0]);
        $this->assertArrayHasKey("trigger_time",  $response->json()[0]);
    }
}
