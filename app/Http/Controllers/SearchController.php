<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use App\Models\Company;
use App\Models\Service;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([
                'calculations' => [],
                'companies' => [],
                'services' => [],
            ]);
        }

        $calculations = Calculation::where('customer_name', 'like', "%{$query}%")
            ->orWhere('customer_email', 'like', "%{$query}%")
            ->orWhere('customer_company', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'customer_name', 'customer_company', 'total_price']);

        $companies = Company::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'name', 'email']);

        $services = Service::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->take(5)
            ->get(['id', 'name', 'price', 'category']);

        return response()->json([
            'calculations' => $calculations,
            'companies' => $companies,
            'services' => $services,
        ]);
    }
}
