<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class PassportAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $clientRepository = new \Laravel\Passport\ClientRepository();
        $client = $clientRepository->createPersonalAccessGrantClient(
            'Test Personal Access Client',
            null
        );

        \Illuminate\Support\Facades\Config::set('passport.personal_access_client.id', $client->id);
        \Illuminate\Support\Facades\Config::set('passport.personal_access_client.secret', $client->secret);
    }

    /**
     * Test user registration and token receipt.
     */
    public function test_user_can_register_and_receive_token()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user',
                'access_token'
            ]);
    }

    /**
     * Test user login and token receipt.
     */
    public function test_user_can_login_and_receive_token()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        // Install passport clients for the test environment if needed
        // Assuming passport:install has been run or using a mock usually.
        // For standard passport tests, we might need to mock the client or ensure valid clients exist.
        // But let's try calling the real endpoint.

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'access_token'
            ]);
    }

    /**
     * Test accessing a protected route with token.
     */
    public function test_authenticated_user_can_access_protected_route()
    {
        // One issue with Passport testing is it requires the keys to be present.
        // Passport::actingAs($user) is often cleaner, but the user wants to test the full flow including token generation.
        // However, generating a real token requires valid passport clients.

        // Strategy: We will use Passport::actingAs for the protected route test 
        // to verify the middleware allows access when authenticated.
        // The previous tests verify that the ENDPOINTS generate a token.

        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->getJson('/api/user');

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'email' => $user->email,
            ]);
    }

    public function test_unauthenticated_user_cannot_access_protected_route()
    {
        $response = $this->getJson('/api/user');

        $response->assertStatus(401);
    }

    public function test_admin_access_to_orders_api()
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@haulhaus.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
        ]);

        Passport::actingAs($admin);

        $response = $this->getJson('/api/orders');

        // We want to see what happens. If it fails with 403, we found it.
        // If it returns 200, then the user's issue is something else.
        $response->assertStatus(200);
    }
}
