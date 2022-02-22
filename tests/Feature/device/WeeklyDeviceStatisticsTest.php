<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Device;
use App\Models\Trigger;
use App\Models\TriggerLog;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WeeklyDeviceStatisticsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_get_device_weekly_updates()
    {
        $this->withoutExceptionHandling();

        Sanctum::actingAs($user = User::factory()->create(), ['*']);
        $device = Device::factory()->create(['user_id' => $user->id]);

        $trigger = Trigger::factory(3)->create([
            'device_id' => $device->id
        ]);

        TriggerLog::factory(3)->create([
            'trigger_id' => $trigger[0]->id,
            'created_at' => now()->subDays(3)->toDateTimeString()
        ]);

        TriggerLog::factory(3)->create([
            'trigger_id' => $trigger[1]->id,
            'created_at' => now()->subDays(4)->toDateTimeString()
        ]);

        TriggerLog::factory(3)->create([
            'trigger_id' => $trigger[2]->id,
            'created_at' => now()->subDays(5)->toDateTimeString()
        ]);

        TriggerLog::factory(3)->create([
            'trigger_id' => $trigger[2]->id,
        ]);

        $response = $this->getJson(route('weekly.triggers', $device))->json();

        $this->assertCount(7, $response);

        for ($i = 0; $i < 6; $i++){
            $this->assertCount(2, $response[$i]);
        }
    }
}
