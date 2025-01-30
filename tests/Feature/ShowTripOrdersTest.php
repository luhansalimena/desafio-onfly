<?php

namespace Tests\Feature;

use App\Models\TripOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTripOrdersTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_trip_order_successfully(): void
    {
        $user = User::factory()->create();
        $tripOrder = TripOrder::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->getJson("/api/trip-orders/{$tripOrder->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $tripOrder->id,
                     'status' => $tripOrder->status->name,
                     'from' => $tripOrder->from,
                     'to' => $tripOrder->to,
                     'trip_date' => $tripOrder->trip_date,
                     'trip_return_date' => $tripOrder->trip_return_date,
                     'user_id' => $tripOrder->user_id,
                     'created_at' => $tripOrder->created_at->toISOString(),
                     'updated_at' => $tripOrder->updated_at->toISOString(),
                 ]);
    }

    public function test_show_trip_order_not_found(): void
    {
        $user = User::factory()->create();
        $nonExistentId = 999;

        $response = $this->actingAs($user, 'api')->getJson("/api/trip-orders/{$nonExistentId}");

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'No query results for model [App\\Models\\TripOrder] 999'
                 ]);
    }

    public function test_show_trip_order_not_authorized(): void
    {
        $user = User::factory()->create();
        $tripRequester = User::factory()->create();
        $tripOrder = TripOrder::factory()->create([
            'user_id' => $tripRequester->id,
        ]);

        $response = $this->actingAs($user, 'api')->getJson("/api/trip-orders/{$tripOrder->id}");

        $response->assertStatus(403);
    }
}
