<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyEmployee;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyEmployeeController extends Controller
{
    public function store(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        $user = User::where('email', $validated['email'])->first();

        $company->employees()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'position' => $validated['position'],
            'user_id' => $user ? $user->id : null,
        ]);

        return back()->with('success', 'Zaměstnanec by úspěšně přidán.');
    }

    public function destroy(Company $company, CompanyEmployee $employee)
    {
        if ($employee->company_id === $company->id) {
            $employee->delete();
        }

        return back()->with('success', 'Zaměstnanec byl odebrán.');
    }
}
