<?php

namespace App\Repositories\Interface;

use App\Models\TripOrder;

interface TripOrderRepositoryInterface
{
    public function create(array $data): TripOrder;
}
