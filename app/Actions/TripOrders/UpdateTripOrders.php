<?php

namespace App\Actions\TripOrders;

use App\Models\TripOrder;
use App\OrderStatus;
use App\Repositories\Interface\TripOrderRepositoryInterface;
use Illuminate\Validation\ValidationException;


class UpdateTripOrders
{
    public function __construct(public TripOrderRepositoryInterface $tripOrderRepository){}

    public function execute(TripOrder $tripOrder, array $data): TripOrder
    {
        if($tripOrder->status !== OrderStatus::REQUESTED) {
            throw ValidationException::withMessages(['Only requested orders can be approved or cancelled']);
        }

        if(!in_array($data['status'], [OrderStatus::APPROVED->value, OrderStatus::CANCELLED->value])) {
            throw ValidationException::withMessages(['Cannot update order status to ' . $data['status']]);
        }

        return $this->tripOrderRepository->update($tripOrder, $data);
    }
}
