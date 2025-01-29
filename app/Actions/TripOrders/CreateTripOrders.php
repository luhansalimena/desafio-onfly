<?php

namespace App\Actions\TripOrders;

use App\Models\TripOrder;
use App\Repositories\Interface\TripOrderRepositoryInterface;

class CreateTripOrders
{
    public function __construct(public TripOrderRepositoryInterface $tripOrderRepository){}

    public function execute(array $data): TripOrder
    {
        $data = array_merge($data, ['user_id' => auth()->id()]);
        return $this->tripOrderRepository->create($data);
    }
}
