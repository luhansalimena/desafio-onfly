<?php

namespace App\Repositories;

use App\Filters\TripOrderFilter;
use App\Models\TripOrder;
use App\Repositories\Interface\TripOrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


class TripOrderRepository implements TripOrderRepositoryInterface
{

    public function __construct(
        private TripOrderFilter $filter
    ) {}

    public function create(array $data): TripOrder
    {
        return TripOrder::create($data);
    }

    public function search(array $filters, bool $paginated = true): Collection | LengthAwarePaginator
    {
        $query = TripOrder::query();

        if (!empty($filters)) {
            $query = $this->filter->apply($query, $filters);
        }

        if ($paginated) {
            return $query->paginate();
        }

        return $query->get();
    }

    public function update(TripOrder $tripOrder, array $data): TripOrder
    {
        $tripOrder->update($data);

        return $tripOrder->fresh();
    }
}
