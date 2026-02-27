<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyEmployee;
use Illuminate\Http\Request;

class CompanyEmployeeSearchController extends Controller
{
    public function __invoke(Request $request, $companyId)
    {
        $search = $request->input('q');

        $query = CompanyEmployee::where('company_id', $companyId);

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $employees = $query->limit(10)->get();

        return response()->json($employees);
    }
}
