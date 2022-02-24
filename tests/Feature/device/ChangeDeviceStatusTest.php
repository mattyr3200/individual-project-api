<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Device;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChangeDeviceStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_arm_alarm()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $device = Device::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertFalse($device->is_armed ? true : false);

        $response = $this->postJson(route('device.arm', $device), [
            'is_armed' => true,
        ])->json();

        $this->assertTrue($response['is_armed']);
    }
}
