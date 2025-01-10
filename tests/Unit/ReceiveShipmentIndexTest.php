<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Shipment;

class ReceiveShipmentIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_renders_the_receive_shipments_view()
    {
        // Arrange: Create a user and authenticate as a driver
        $user = User::factory()->create(['role' => 'driver']);
        Auth::login($user);

        // Act: Visit the receive shipments index page
        $response = $this->get(route('receive-shipments.index'));

        // Assert: Check if the view is rendered
        $response->assertStatus(200);
        $response->assertViewIs('pages.DriDashbrd.ReceiveShipment.index');
    }

    /** @test */
    public function it_displays_received_shipments()
    {
        // Arrange: Create a user and authenticate as a driver
        $user = User::factory()->create(['role' => 'driver']);
        Auth::login($user);

        // Create some shipments associated with the driver
        $shipments = Shipment::factory()->count(3)->create([
            'driver_id' => $user->id,
        ]);

        // Act: Visit the receive shipments index page
        $response = $this->get(route('receive-shipments.index'));

        // Assert: Check if the shipments are displayed
        foreach ($shipments as $shipment) {
            $response->assertSee($shipment->client_name);
            $response->assertSee($shipment->phone);
            $response->assertSee($shipment->type);
        }
    }

    /** @test */
    public function it_displays_no_shipments_message()
    {
        // Arrange: Create a user and authenticate as a driver
        $user = User::factory()->create(['role' => 'driver']);
        Auth::login($user);

        // Act: Visit the receive shipments index page
        $response = $this->get(route('receive-shipments.index'));

        // Assert: Check if the no shipments message is displayed
        $response->assertSee('No received shipments found.');
    }

    /** @test */
    public function it_displays_user_profile_image_or_fallback()
    {
        // Arrange: Create a user with a profile image and authenticate as a driver
        $userWithImage = User::factory()->create(['profile_image' => 'path/to/image.jpg', 'role' => 'driver']);
        Auth::login($userWithImage);

        // Act: Visit the receive shipments index page
        $response = $this->get(route('receive-shipments.index'));

        // Assert: Check if the profile image is displayed
        $response->assertSee('path/to/image.jpg');

        // Arrange: Create a user without a profile image and authenticate as a driver
        $userWithoutImage = User::factory()->create(['profile_image' => null, 'role' => 'driver']);
        Auth::login($userWithoutImage);

        // Act: Visit the receive shipments index page
        $response = $this->get(route('receive-shipments.index'));

        // Assert: Check if the fallback icon is displayed
        $response->assertSee('bi bi-person-circle');
    }
}
