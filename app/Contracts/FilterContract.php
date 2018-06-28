<?php

namespace App\Contracts;

interface FilterContract
{
    /**
     * Apply the filter.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query);
}