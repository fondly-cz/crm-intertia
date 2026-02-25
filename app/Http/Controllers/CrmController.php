<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use App\Models\Company;
use App\Models\Service;
use Inertia\Inertia;

class CrmController extends Controller
{
    public function welcome()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'companies' => Company::count(),
                'calculations' => Calculation::count(),
                'services' => Service::count(),
            ],
        ]);
    }
}
