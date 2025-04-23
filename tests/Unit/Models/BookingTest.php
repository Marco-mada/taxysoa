<?php

namespace Tests\Unit\Models;

use App\Models\Booking;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_user_relation()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $booking->user);
        $this->assertEquals($user->id, $booking->user->id);
    }

    /** @test */
    public function it_has_a_driver_relation()
    {
        $driver = Driver::factory()->create();
        $booking = Booking::factory()->create(['driver_id' => $driver->id]);

        $this->assertInstanceOf(Driver::class, $booking->driver);
        $this->assertEquals($driver->id, $booking->driver->id);
    }

    /** @test */
    public function it_calculates_price_correctly()
    {
        $booking = Booking::factory()->create([
            'base_price' => 10000,
            'distance' => 10,
            'duration' => 30,
        ]);

        $expectedPrice = 10000 + (10 * 500) + (30 * 100); // Base + (distance * rate) + (duration * rate)
        $this->assertEquals($expectedPrice, $booking->calculatePrice());
    }

    /** @test */
    public function it_can_be_cancelled()
    {
        $booking = Booking::factory()->create(['status' => 'pending']);
        
        $booking->cancel();
        
        $this->assertEquals('cancelled', $booking->status);
        $this->assertNotNull($booking->cancelled_at);
    }

    /** @test */
    public function it_cannot_be_cancelled_when_completed()
    {
        $booking = Booking::factory()->create(['status' => 'completed']);
        
        $this->expectException(\App\Exceptions\BookingException::class);
        $booking->cancel();
    }

    /** @test */
    public function it_has_valid_status_transitions()
    {
        $booking = Booking::factory()->create(['status' => 'pending']);
        
        $booking->accept();
        $this->assertEquals('accepted', $booking->status);
        
        $booking->start();
        $this->assertEquals('in_progress', $booking->status);
        
        $booking->complete();
        $this->assertEquals('completed', $booking->status);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);
        
        Booking::factory()->create([
            'pickup_location' => null,
            'destination' => null,
        ]);
    }
} 