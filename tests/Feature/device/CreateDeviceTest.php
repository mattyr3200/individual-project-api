<?php

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateDeviceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_can_create_device()
    {
        Sanctum::actingAs($user = User::factory()->create(), ['*']);

        $device = $this->postJson(route('device.store'), [
            'name' => "TEST NAME",
            'site' => "Default",
        ])->json();

        $this->assertCount(3, $device);
        $this->assertSame("TEST NAME", $device['name']);
        $this->assertSame("Default", $device['site']);
        $this->assertNotNull($device['id']);
    }

    /** @test */
    public function test_guest_cannot_create_device()
    {
        $response = $this->postJson(route('device.store'), [
            'name' => "TEST NAME",
            'site' => "Default",
        ]);

        $response->assertUnauthorized();
    }
}
