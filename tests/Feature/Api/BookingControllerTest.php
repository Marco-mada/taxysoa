<?php

namespace Tests\Feature\Api;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    /** @test */
    public function it_can_create_a_booking()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/api/bookings', [
                'pickup_location' => 'Antananarivo',
                'destination' => 'Toamasina',
                'vehicle_type' => 'standard',
                'passengers' => 2,
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'pickup_location',
                    'destination',
                    'status',
                    'price',
                    'created_at',
                ]
            ]);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'pickup_location' => 'Antananarivo',
            'destination' => 'Toamasina',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->postJson('/api/bookings', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'pickup_location',
                'destination',
                'vehicle_type',
            ]);
    }

    /** @test */
    public function it_can_accept_a_booking()
    {
        $driver = Driver::factory()->create();
        $booking = \App\Models\Booking::factory()->create(['status' => 'pending']);
        
        $response = $this->actingAs($driver->user)
            ->postJson("/api/bookings/{$booking->id}/accept");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'status' => 'accepted',
                    'driver_id' => $driver->id,
                ]
            ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'accepted',
            'driver_id' => $driver->id,
        ]);
    }

    /** @test */
    public function it_can_cancel_a_booking()
    {
        $user = User::factory()->create();
        $booking = \App\Models\Booking::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);
        
        $response = $this->actingAs($user)
            ->postJson("/api/bookings/{$booking->id}/cancel");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'status' => 'cancelled',
                ]
            ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled',
        ]);
    }

    /** @test */
    public function it_can_get_booking_history()
    {
        $user = User::factory()->create();
        $bookings = \App\Models\Booking::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);
        
        $response = $this->actingAs($user)
            ->getJson('/api/bookings/history');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'pickup_location',
                        'destination',
                        'status',
                        'price',
                        'created_at',
                    ]
                ]
            ]);
    }

    /** @test */
    public function it_can_get_booking_details()
    {
        $user = User::factory()->create();
        $booking = \App\Models\Booking::factory()->create([
            'user_id' => $user->id,
        ]);
        
        $response = $this->actingAs($user)
            ->getJson("/api/bookings/{$booking->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $booking->id,
                    'pickup_location' => $booking->pickup_location,
                    'destination' => $booking->destination,
                    'status' => $booking->status,
                ]
            ]);
    }
} 