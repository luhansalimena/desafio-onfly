<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class TripOrderFilter extends BaseFilter
{
    public function status($value): Builder
    {
        return $this->builder->where('status', $value);
    }

    public function userId($value): Builder
    {
        return $this->builder->where('user_id', $value);
    }

    public function to($value): Builder
    {
        return $this->builder->where('to', 'like', "%$value%");
    }

    public function tripDateFrom($value): Builder
    {
        return $this->builder->whereDate('trip_date', '>=', $value);
    }

    public function tripDateTo($value): Builder
    {
        return $this->builder->whereDate('trip_date', '<=', $value);
    }
}
