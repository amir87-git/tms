<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    private const TEST_EMAIL = 'test@example.com';
    private const TEST_PASSWORD = 'password';

    /**
     * Test successful login.
     */
    public function testSuccessfulLogin()
    {
        // Create a user with a known email and password
        $user = User::factory()->create([
            'email' => self::TEST_EMAIL,
            'password' => bcrypt(self::TEST_PASSWORD),
        ]);

        // Simulate a POST request to the login route
        $response = $this->post(route('login.store'), [
            'email' => self::TEST_EMAIL,
            'password' => self::TEST_PASSWORD,
            '_token' => csrf_token(), // Include the CSRF token
        ]);

        // Assert redirection to the intended page
        $response->assertRedirect('/home');

        // Assert the user is authenticated
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test failed login due to incorrect credentials.
     */
    public function testFailedLogin()
    {
        // Simulate a POST request to the login route with invalid credentials
        $response = $this->post(route('login.store'), [
            'email' => self::TEST_EMAIL,
            'password' => 'wrongpassword',
            '_token' => csrf_token(), // Include the CSRF token
        ]);

        // Assert the response status is 302 (redirection back to the login page)
        $response->assertStatus(302);

        // Assert session has specific error
        $response->assertSessionHasErrors(['email']);

        // Assert the user remains unauthenticated
        $this->assertGuest();
    }

    /**
     * Test validation errors during login.
     */
    public function testValidationErrors()
    {
        // Simulate a POST request to the login route with empty fields
        $response = $this->post(route('login.store'), [
            'email' => '',
            'password' => '',
            '_token' => csrf_token(), // Include the CSRF token
        ]);

        // Assert session has validation errors for email and password
        $response->assertSessionHasErrors(['email', 'password']);
    }
}
