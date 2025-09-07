<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PaginationService
{
    /**
     * Пагинатор
     */
    public function paginate(Builder $query, Request $request, int $perPage = 12): LengthAwarePaginator
    {
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', $perPage);
        $offset = ($page - 1) * $perPage;

        $total = $query->count();
        $items = $query->offset($offset)->limit($perPage)->get();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query()
            ]
        );
    }
}