<?php

namespace Tests\Feature;

use App\Models\TripOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TripOrdersTest extends TestCase
{
    use DatabaseMigrations;

    public function test_success_when_creating_trips(): void
    {
        $user = User::factory()->create();

        $validTrip = TripOrder::factory()->create();

        $response = $this->actingAs($user,'api')->post(route('trip-orders.store'), $validTrip->toArray());

        $response->assertStatus(201);

        $this->assertDatabaseHas('trip_orders', $validTrip->toArray());
    }

    public function test_returns_validation_errors(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user,'api')->post(route('trip-orders.store'), [], ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['status', 'from', 'to', 'trip_date', 'trip_return_date']);

        $this->assertDatabaseCount('trip_orders', 0);
    }
}
