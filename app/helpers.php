<?php

use Illuminate\Database\Eloquent\Builder;

function getQueryWithFilters($filters, Builder $query): Builder
{
    foreach ($filters as $filter => $value) {
        if (is_array($value) && $value) {
            $query->whereIn($filter, $value);
        } else {
            if ($value) {
                $query->where($filter, $value);
            }
        }
    }
    return $query;
}
