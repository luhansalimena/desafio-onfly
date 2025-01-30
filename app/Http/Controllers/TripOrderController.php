<?php

namespace App\Http\Controllers;

use App\Actions\TripOrders\CreateTripOrders;
use App\Actions\TripOrders\SearchTripOrders;
use App\Actions\TripOrders\UpdateTripOrders;
use App\Http\Requests\SearchTripOrdersRequest;
use App\Http\Requests\StoreTripOrderRequest;
use App\Http\Requests\UpdateOrdersRequest;
use App\Models\TripOrder;
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

    /**
     * @OA\Get(
     *     path="/trip-orders",
     *     summary="List all trip orders with filters",
     *     tags={"Trip Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *          name="status",
     *          in="query",
     *          description="Filter by status",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"REQUESTED", "APPROVED", "CANCELLED"},
     *              default="REQUESTED"
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of trip orders",
     *         @OA\JsonContent(
     *             @OA\Property(property="current_page", type="integer", example=1),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="status", type="string", example="REQUESTED"),
     *                     @OA\Property(property="from", type="string", example="São Paulo"),
     *                     @OA\Property(property="to", type="string", example="Rio de Janeiro"),
     *                     @OA\Property(property="trip_date", type="string", format="datetime", example="2024-03-20 00:00:00"),
     *                     @OA\Property(property="trip_return_date", type="string", format="date", example="2024-03-25"),
     *                     @OA\Property(property="user_id", type="integer", example=18),
     *                     @OA\Property(property="created_at", type="string", format="datetime", example="2024-03-20T00:00:00.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="datetime", example="2024-03-20T00:00:00.000000Z")
     *                 )
     *             ),
     *             @OA\Property(property="first_page_url", type="string", example="http://localhost/api/trip-orders?page=1"),
     *             @OA\Property(property="from", type="integer", example=1),
     *             @OA\Property(property="last_page", type="integer", example=2),
     *             @OA\Property(property="last_page_url", type="string", example="http://localhost/api/trip-orders?page=2"),
     *             @OA\Property(property="links", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="url", type="string", nullable=true),
     *                     @OA\Property(property="label", type="string", example="1"),
     *                     @OA\Property(property="active", type="boolean", example=true)
     *                 )
     *             ),
     *             @OA\Property(property="next_page_url", type="string", nullable=true, example="http://localhost/api/trip-orders?page=2"),
     *             @OA\Property(property="path", type="string", example="http://localhost/api/trip-orders"),
     *             @OA\Property(property="per_page", type="integer", example=15),
     *             @OA\Property(property="prev_page_url", type="string", nullable=true),
     *             @OA\Property(property="to", type="integer", example=15),
     *             @OA\Property(property="total", type="integer", example=19)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(SearchTripOrdersRequest $request, SearchTripOrders $searchTripOrders)
    {
        return $searchTripOrders->execute($request->validated());
    }

    /**
     * @OA\Put(
     *     path="/trip-orders/{id}",
     *     summary="Update a trip order",
     *     tags={"Trip Orders"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Trip order ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", enum={"REQUESTED", "APPROVED", "CANCELLED"}),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Trip order updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="status", type="string", example="APPROVED"),
     *             @OA\Property(property="from", type="string", example="São Paulo"),
     *             @OA\Property(property="to", type="string", example="Rio de Janeiro"),
     *             @OA\Property(property="trip_date", type="string", format="date", example="2024-03-20"),
     *             @OA\Property(property="trip_return_date", type="string", format="date", example="2024-03-25"),
     *             @OA\Property(property="created_at", type="string", format="datetime"),
     *             @OA\Property(property="updated_at", type="string", format="datetime")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Trip order not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateOrdersRequest $request, TripOrder $tripOrder, UpdateTripOrders $updateTripOrders): JsonResponse
    {
        $tripOrder = $updateTripOrders->execute($tripOrder, $request->validated());

        return response()->json($tripOrder);
    }
}
