<?php

namespace Tests\Feature;

use App\Models\TripOrder;
use App\Models\User;
use App\Notifications\TripOrderStatusChanged;
use App\OrderStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UpdateTripOrdersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_update_trip_order_successfully(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $tripRequester = User::factory()->create();

        $tripOrder = TripOrder::factory()->create(['status' => OrderStatus::REQUESTED->value,'user_id' => $tripRequester->id]);


        $response = $this->actingAs($user,'api')->putJson("/api/trip-orders/{$tripOrder->id}", [
            'status' => OrderStatus::APPROVED->value,
        ]);

        Notification::assertSentTo(
            [$tripRequester], TripOrderStatusChanged::class
        );


        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $tripOrder->id,
                     'status' => OrderStatus::APPROVED->value,
                 ]);
    }


    public function test_update_trip_order_that_is_already_cancelled(): void
    {
        $user = User::factory()->create();

        $tripOrder = TripOrder::factory()->create(['status' => OrderStatus::CANCELLED->value]);

        $response = $this->actingAs($user,'api')->putJson("/api/trip-orders/{$tripOrder->id}", [
            'status' => OrderStatus::CANCELLED->value,
        ]);

        $response->assertStatus(422)
                ->assertJson([
                    'message' => 'Only requested orders can be approved or cancelled',
                    'errors' => [
                        ['Only requested orders can be approved or cancelled']
                    ]
                ]);
    }

    public function test_update_trip_order_to_requested(): void
    {
        $user = User::factory()->create();

        $tripOrder = TripOrder::factory()->create(['status' => OrderStatus::REQUESTED->value]);

        $response = $this->actingAs($user,'api')->putJson("/api/trip-orders/{$tripOrder->id}", [
            'status' => OrderStatus::REQUESTED->value,
        ]);

        $response->assertStatus(422)
                ->assertJson([
                    'message' => 'Cannot update order status to ' . OrderStatus::REQUESTED->value,
                    'errors' => [
                        ['Cannot update order status to ' . OrderStatus::REQUESTED->value]
                    ]
                ]);
    }

}
