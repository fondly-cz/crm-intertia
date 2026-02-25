<?php

namespace App\Http\Controllers;

use App\Models\MyCompany;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MyCompanyController extends Controller
{
    public function edit()
    {
        $myCompany = MyCompany::first() ?: new MyCompany;

        return Inertia::render('MyCompany/Edit', [
            'myCompany' => $myCompany,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'ico' => 'nullable|string|max:20',
            'dic' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'website' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:255',
        ]);

        $myCompany = MyCompany::first();

        if ($myCompany) {
            $myCompany->update($validated);
        } else {
            MyCompany::create($validated);
        }

        return redirect()->back()->with('success', 'Informace o mojí firmě byly aktualizovány.');
    }
}
