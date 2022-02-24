<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Device;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_update_device()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $device = Device::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->putJson(route('device.update', ['device' => $device->id]), [
            'name' => "TEST NAME"
        ])->json();

        $this->assertCount(4, $response);
        $this->assertSame("TEST NAME", $response['name']);
        $this->assertSame("Home", $response['site']);
        $this->assertSame($device->id, $response['id']);
    }


    /** @test */
    public function test_guest_cannot_update_device()
    {
        $device = Device::factory()->create();

        $response = $this->putJson(route('device.update', ['device' => $device->id]), [
            'name' => "TEST NAME"
        ]);

        $response->assertUnauthorized();
    }

    /** @test */
    public function test_user_cannot_update_other_users_device()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $device = Device::factory()->create();

        $response = $this->putJson(route('device.update', ['device' => $device->id]), [
            'name' => "TEST NAME"
        ]);

        $response->assertForbidden();
    }
}
