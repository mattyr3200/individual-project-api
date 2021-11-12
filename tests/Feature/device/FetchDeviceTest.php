<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Device;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_fetch_devices()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $device = Device::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson(route('device.index'))->json();

        $this->assertCount(1, $response);
        $this->assertCount(3, $response[0]);

        $this->assertSame($device->name, $response[0]['name']);
        $this->assertSame($device->site, $response[0]['site']);
        $this->assertSame($device->id, $response[0]['id']);
    }

    /** @test */
    public function test_user_can_fetch_singular_device()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $device = Device::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->getJson(route('device.show', ['device' => $device]))->json();

        $this->assertCount(3, $response);

        $this->assertSame($device->name, $response['name']);
        $this->assertSame($device->site, $response['site']);
        $this->assertSame($device->id, $response['id']);
    }

    /** @test */
    public function test_guest_cannot_fetch_singular_device()
    {
        $device = Device::factory()->create();

        $response = $this->getJson(route('device.show', ['device' => $device]));

        $response->assertUnauthorized();
    }

    /** @test */
    public function test_guest_cannot_fetch_devices()
    {
        $device = Device::factory()->create();

        $response = $this->getJson(route('device.index'));

        $response->assertUnauthorized();
    }

    /** @test */
    public function user_cannot_fetch_another_users_devices()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $device = Device::factory(10)->create();

        $response = $this->getJson(route('device.index'))->json();

        $this->assertCount(0, $response);
    }

    /** @test */
    public function user_cannot_fetch_another_users_device()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $device = Device::factory()->create();

        $response = $this->getJson(route('device.show', ['device' => $device]));

        $response->assertForbidden();
    }
}
