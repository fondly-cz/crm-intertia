<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $perPage = $request->input('per_page', 20);
        $paginator = $query->paginate($perPage)->withQueryString();

        return inertia('Services/Index', [
            'services' => $paginator,
            'filters' => $request->only(['search', 'category', 'per_page']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'margin' => 'required|numeric|min:0',
            'days' => 'required|integer|min:0',
            'icon' => 'nullable|string|max:10',
            'payment_period' => 'required|string|in:once,monthly,yearly',
        ]);

        Service::create($validated);

        return back()->with('success', 'Služba byla úspěšně vytvořena.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'data' => 'required|string',
        ]);

        $lines = explode("\n", str_replace("\r", '', $request->data));
        $count = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            $parts = explode('|', $line);
            if (count($parts) < 3) {
                continue;
            }

            // Expected: Name|Icon|Category|Cost|Margin|Days
            Service::create([
                'name' => trim($parts[0]),
                'icon' => trim($parts[1]),
                'category' => trim($parts[2]),
                'cost' => (float) trim($parts[3] ?? 0),
                'margin' => (float) trim($parts[4] ?? 30),
                'days' => (int) trim($parts[5] ?? 0),
                'payment_period' => trim($parts[6] ?? 'once'),
                'description' => '',
            ]);
            $count++;
        }

        return back()->with('success', "Hromadně přidáno $count služeb.");
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'margin' => 'required|numeric|min:0',
            'days' => 'required|integer|min:0',
            'icon' => 'nullable|string|max:10',
            'is_active' => 'boolean',
            'payment_period' => 'required|string|in:once,monthly,yearly',
        ]);

        $service->update($validated);

        return back()->with('success', 'Služba byla úspěšně upravena.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return back()->with('success', 'Služba byla úspěšně smazána.');
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:services,id',
        ]);

        Service::whereIn('id', $validated['ids'])->delete();

        return back()->with('success', 'Vybrané služby byly smazány.');
    }
}
