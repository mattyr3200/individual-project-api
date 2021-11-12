<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_register()
    {
        $response = $this->postJson(route('register'), [
            'name' => "Mathew Reynolds",
            'email' => "test@test.com",
            'password' => "Password123!",
            'password_confirmation' => "Password123!",
            'device_name' => "iphone",
        ]);

        $response->assertOk();

        $this->assertNotNull($response->json()['token']);
    }

    /** @test */
    public function name_must_not_be_empty_string()
    {
        $response = $this->postJson(route('register'), [
            'name' => "",
            'email' => "test@test.com",
            'password' => "Password123!",
            'password_confirmation' => "Password123!",
            'device_name' => "iphone",
        ]);

        $response->assertInvalid('name');
    }

    /** @test */
    public function email_must_not_be_empty_string()
    {
        $response = $this->postJson(route('register'), [
            'name' => "Mathew Reynolds",
            'email' => "",
            'password' => "Password123!",
            'password_confirmation' => "Password123!",
            'device_name' => "iphone",
        ]);

        $response->assertInvalid('email');
    }

    /** @test */
    public function email_must_be_valid_email()
    {
        $response = $this->postJson(route('register'), [
            'name' => "Mathew Reynolds",
            'email' => "FakeWrongEmail",
            'password' => "Password123!",
            'password_confirmation' => "Password123!",
            'device_name' => "iphone",
        ]);

        $response->assertInvalid('email');
    }

    /** @test */
    public function password_must_meet_criteria_to_be_valid()
    {
        $response = $this->postJson(route('register'), [
            'name' => "Mathew Reynolds",
            'email' => "test@test.com",
            'password' => "password",
            'password_confirmation' => "password",
            'device_name' => "iphone",
        ]);

        $response->assertInvalid('password');
    }

    /** @test */
    public function password_must_be_confirmed_to_be_valid()
    {
        $response = $this->postJson(route('register'), [
            'name' => "Mathew Reynolds",
            'email' => "test@test.com",
            'password' => "Password123",
            'password_confirmation' => "Password123!",
            'device_name' => "iphone",
        ]);

        $response->assertInvalid('password');
    }
}
