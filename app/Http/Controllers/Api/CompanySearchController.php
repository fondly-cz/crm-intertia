<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanySearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $search = $request->input('q');

        if (! $search) {
            return response()->json([]);
        }

        $companies = Company::where('name', 'like', "%{$search}%")
            ->orWhere('ico', 'like', "%{$search}%")
            ->select('id', 'name', 'ico', 'email', 'phone')
            ->limit(10)
            ->get();

        return response()->json($companies);
    }
}
