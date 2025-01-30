<?php

namespace Tests\Feature;

use App\Models\TripOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SeachTripOrdersTest extends TestCase
{
    use DatabaseMigrations;

    public function test_success_when_searching_trips_with_no_parameters(): void
    {
        $user = User::factory()->create();

        TripOrder::factory(10)->create();
        $validTrip = TripOrder::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user,'api')->get(route('trip-orders.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'status',
                    'from',
                    'to',
                    'trip_date',
                    'trip_return_date'
                ]
            ]
        ]);

        $response->assertJsonFragment([
            'id' => $validTrip->id,
            'status' => $validTrip->status->name,
            'from' => $validTrip->from,
            'to' => $validTrip->to,
            'trip_date' => $validTrip->trip_date,
            'trip_return_date' => $validTrip->trip_return_date,
        ]);
    }

    public function test_success_when_searching_trips_with_status_parameter(): void
    {
        $user = User::factory()->create();

        TripOrder::factory(10)->create();
        $validTrip = TripOrder::factory()->create(['user_id' => $user->id, 'status' => 'REQUESTED']);

        $response = $this->actingAs($user, 'api')->get(route('trip-orders.index', ['status' => 'REQUESTED']));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'status',
                    'from',
                    'to',
                    'trip_date',
                    'trip_return_date'
                ]
            ]
        ]);

        $response->assertJsonFragment([
            'id' => $validTrip->id,
            'status' => $validTrip->status->name,
            'from' => $validTrip->from,
            'to' => $validTrip->to,
            'trip_date' => $validTrip->trip_date,
            'trip_return_date' => $validTrip->trip_return_date,
        ]);
    }

    public function test_failure_when_searching_trips_with_invalid_parameter(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')->get(route('trip-orders.index', ['status' => 'invalid_status']), ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'status'
            ]
        ]);
    }


}
