<?php

namespace Takshak\Adash\Traits\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait ColumnFilterTrait
{
    public function scopeColumnFilter(Builder $query, $filter = true)
    {
        if (!$filter) {
            return $query;
        }

        $columns = Schema::getColumnListing($this->getTable());
        foreach ($columns as $column) {
            $query->when(request($column) != '', function ($query) use ($column) {
                $query->where($column, request($column));
            });
        }

        return $query;
    }
}
