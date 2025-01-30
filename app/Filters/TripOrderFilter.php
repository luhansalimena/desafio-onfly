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
}
