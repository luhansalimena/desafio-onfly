<?php

namespace App\Repositories\Interface;

use App\Models\TripOrder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TripOrderRepositoryInterface
{
    public function create(array $data): TripOrder;
    public function search(array $filters, bool $paginated = true): Collection | LengthAwarePaginator;
    public function update(TripOrder $tripOrder, array $data): TripOrder;
}
