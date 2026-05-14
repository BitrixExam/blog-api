<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostFilter
{
    public function apply(Builder $query, Request $request): Builder
    {
        $this->applyDateFilter($query, $request);
        $this->applySorting($query, $request);
        $this->applyLimitOffset($query, $request);

        return $query;
    }

    private function applyDateFilter(Builder $query, Request $request): void
    {
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->query('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->query('date_to'));
        }
    }

    private function applySorting(Builder $query, Request $request): void
    {
        $sortBy = $request->query('sort_by', 'created_at');
        $sortDirection = $request->query('sort_direction', 'desc');

        if (!in_array($sortBy, ['created_at', 'title'], true)) {
            $sortBy = 'created_at';
        }

        if (!in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortBy, $sortDirection);
    }

    private function applyLimitOffset(Builder $query, Request $request): void
    {
        $limit = (int) $request->query('limit', 10);
        $offset = (int) $request->query('offset', 0);

        $query
            ->offset(max($offset, 0))
            ->limit($limit > 0 ? $limit : 10);
    }
}
