<?php

namespace App\Http\Controllers;

use App\Actions\TripOrders\CreateTripOrders;
use App\Http\Requests\StoreTripOrderRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Trip Orders",
 *     description="API Endpoints for Trip Order management"
 * )
 */
class TripOrderController extends Controller
{
    /**
     * @OA\Post(
     *     path="/trip-orders",
     *     summary="Create a new trip order",
     *     tags={"Trip Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"requester_name","status","from","to","trip_date","trip_return_date"},
     *             @OA\Property(property="status", type="string", example="requested"),
     *             @OA\Property(property="from", type="string", example="São Paulo"),
     *             @OA\Property(property="to", type="string", example="Rio de Janeiro"),
     *             @OA\Property(property="trip_date", type="string", format="date", example="2024-03-20"),
     *             @OA\Property(property="trip_return_date", type="string", format="date", example="2024-03-25")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Trip order created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", example="requested"),
     *             @OA\Property(property="from", type="string", example="São Paulo"),
     *             @OA\Property(property="to", type="string", example="Rio de Janeiro"),
     *             @OA\Property(property="trip_date", type="string", format="date", example="2024-03-20"),
     *             @OA\Property(property="trip_return_date", type="string", format="date", example="2024-03-25"),
     *             @OA\Property(property="created_at", type="string", format="datetime"),
     *             @OA\Property(property="updated_at", type="string", format="datetime")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreTripOrderRequest $request, CreateTripOrders $createTripOrders): JsonResponse
    {
        $tripOrder = $createTripOrders->execute($request->validated());

        return response()->json($tripOrder, 201);
    }
}
