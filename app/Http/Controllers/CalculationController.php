<?php

namespace App\Http\Controllers;

use App\Models\Calculation;
use App\Models\Service;
use Illuminate\Http\Request;

class CalculationController extends Controller
{
    public function index()
    {
        return inertia('Calculations/Index', [
            'calculations' => Calculation::with('items')->latest()->get(),
        ]);
    }

    public function create()
    {
        return inertia('Calculations/Create', [
            'services' => Service::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_company' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'services' => 'required|array',
            'services.*.id' => 'required|exists:services,id',
            'services.*.parent_index' => 'nullable|integer',
            'services.*.price' => 'required|numeric|min:0',
            'services.*.days' => 'required|integer|min:0',
            'services.*.payment_period' => 'required|string|in:once,monthly,yearly',
            'services.*.description' => 'nullable|string',
        ]);

        $calculation = Calculation::create([
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_company' => $validated['customer_company'],
            'note' => $validated['note'],
            'user_id' => auth()->id(),
            'total_price' => 0,
            'total_days' => 0,
        ]);

        $services = Service::whereIn('id', collect($validated['services'])->pluck('id'))->get();
        $createdItems = [];

        // Save items first (flat)
        foreach ($validated['services'] as $index => $itemData) {
            $service = $services->firstWhere('id', $itemData['id']);
            if (! $service) {
                continue;
            }

            $item = $calculation->items()->create([
                'service_id' => $service->id,
                'name' => $service->name,
                'description' => $itemData['description'] ?? $service->description,
                'cost' => 0, // Costs are now individual per calculation
                'margin' => 0,
                'price' => $itemData['price'],
                'days' => $itemData['days'],
                'payment_period' => $itemData['payment_period'],
                'is_accepted' => false,
            ]);

            $createdItems[$index] = $item;
        }

        // Apply hierarchy based on parent_index
        foreach ($validated['services'] as $index => $itemData) {
            if (isset($itemData['parent_index']) && isset($createdItems[$itemData['parent_index']])) {
                /** @var \App\Models\CalculationItem $item */
                $item = $createdItems[$index];
                /** @var \App\Models\CalculationItem $parentItem */
                $parentItem = $createdItems[$itemData['parent_index']];
                $item->update(['parent_id' => $parentItem->id]);
            }
        }

        return redirect()->route('calculations.show', $calculation);
    }

    public function show(Calculation $calculation)
    {
        return inertia('Calculations/Show', [
            'calculation' => $calculation->load('items'),
        ]);
    }

    public function showPublic(string $token)
    {
        $calculation = Calculation::where('access_token', $token)->firstOrFail();

        return inertia('Calculations/Show', [
            'calculation' => $calculation->load('items'),
            'is_public' => true,
        ]);
    }

    public function acceptPublic(Request $request, string $token)
    {
        $calculation = Calculation::where('access_token', $token)->firstOrFail();

        $validated = $request->validate([
            'accepted_items' => 'required|array',
            'accepted_items.*' => 'exists:calculation_items,id',
        ]);

        $acceptedIds = collect($validated['accepted_items']);

        $totalPrice = 0;
        $totalDays = 0;

        foreach ($calculation->items as $item) {
            /** @var \App\Models\CalculationItem $item */
            $isAccepted = $acceptedIds->contains($item->id);
            $item->update(['is_accepted' => $isAccepted]);

            if ($isAccepted) {
                $totalPrice += $item->price;
                $totalDays += $item->days;
            }
        }

        $calculation->update([
            'total_price' => $totalPrice,
            'total_days' => $totalDays,
            'status' => 'confirmed',
        ]);

        return back()->with('success', 'Kalkulace byla úspěšně potvrzena. Děkujeme!');
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:calculations,id',
        ]);

        Calculation::whereIn('id', $validated['ids'])->delete();

        return back()->with('success', 'Vybrané kalkulace byly smazány.');
    }
}
