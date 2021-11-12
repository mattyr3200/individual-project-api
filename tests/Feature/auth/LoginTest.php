<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_correct_details_mobile()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => "password",
            'device_name' => "iphone",
        ]);

        $response->assertOk();

        $this->assertNotNull($response->json()['token']);
    }

    /** @test */
    public function user_cannot_login_with_wrong_email_mobile()
    {
        $response = $this->postJson(route('login'), [
            'email' => "email@weirdEmailDude.com",
            'password' => "password",
            'device_name' => "iphone",
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('email');
    }

    /** @test */
    public function user_cannot_login_with_wrong_password_mobile()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => "ThisIsntAPassword123!",
            'device_name' => "iphone",
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('email');
    }
}
