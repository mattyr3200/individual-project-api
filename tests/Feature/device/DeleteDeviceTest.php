<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Device;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_delete_device()
    {
        $this->withoutExceptionHandling();

        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $device = Device::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->deleteJson(route('device.destroy', $device->id))
            ->assertStatus(204);
    }

}
