<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Application;

class CrmController extends Controller
{
    public function welcome()
    {
        return Inertia::render('Welcome', [
            'laravelVersion' => Application::VERSION,
        ]);
    }
}
