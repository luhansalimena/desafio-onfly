<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseFilter
{
    protected $builder;

    public function apply(Builder $builder, array $filters): Builder
    {
        $this->builder = $builder;

        foreach($filters as $filter => $value) {
            if(method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }
}
