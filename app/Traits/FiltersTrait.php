<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait FiltersTrait
{
    public function applyFilters(Request $request, $query)
    {
        if ($request->has('user_id')) {
            return $query->select('*')->find($request->input('user_id'));
        }
        if ($request->has('service')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('name', $request->input('service'));
            });
        }
        if ($request->has('sort_by') && $request->has('sort_order')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_order'));
        }
        if ($request->has('page') && $request->has('per_page')) {
            $perPage = $request->input('per_page');
            return $query->paginate($perPage);
        }

        return $query->get();
    }
}
