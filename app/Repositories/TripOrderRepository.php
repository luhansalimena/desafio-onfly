<?php

namespace App\Repositories;

use App\Models\TripOrder;
use App\Repositories\Interface\TripOrderRepositoryInterface;


class TripOrderRepository implements TripOrderRepositoryInterface
{
    public function create(array $data): TripOrder{
        return TripOrder::create($data);
    }
}
