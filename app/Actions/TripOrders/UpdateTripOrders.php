<?php

namespace App\Actions\TripOrders;

use App\Models\TripOrder;
use App\Notifications\TripOrderStatusChanged;
use App\OrderStatus;
use App\Repositories\Interface\TripOrderRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;


class UpdateTripOrders
{
    public function __construct(public TripOrderRepositoryInterface $tripOrderRepository){}

    public function execute(TripOrder $tripOrder, array $data): TripOrder
    {
        if($tripOrder->status !== OrderStatus::REQUESTED) {
            throw ValidationException::withMessages(['Only requested orders can be approved or cancelled']);
        }

        $this->validateStatus($tripOrder, $data['status']);

        $tripOrder = $this->tripOrderRepository->update($tripOrder, $data);

        $tripOrder->user->notify(new TripOrderStatusChanged($data['status']));

        return $tripOrder;
    }

    public function validateStatus(TripOrder $tripOrder, string $status): void
    {
        if(!in_array($status, [OrderStatus::APPROVED->value, OrderStatus::CANCELLED->value])) {
            throw ValidationException::withMessages(['Cannot update order status to ' . $status]);
        }

        if($status === OrderStatus::CANCELLED->value && Carbon::createFromDate($tripOrder->trip_date)->isPast()) {
            throw ValidationException::withMessages(['Cannot cancel order for past trips']);
        }
    }
}
