<?php

namespace App\Actions\TripOrders;

use App\Repositories\Interface\TripOrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchTripOrders
{
    public function __construct(public TripOrderRepositoryInterface $tripOrderRepository){}

    public function execute(array $filters): Collection | LengthAwarePaginator
    {
        $filters = [...$filters, 'userId' => auth()->user()->id];
        $filters = array_filter($filters);
        return $this->tripOrderRepository->search($filters);
    }
}
