<?php

namespace App\Http\Controllers;

use App\Models\Inventories;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InventoriesController extends Controller
{
    // Show all medicines
    public function medicines()
    {
        $items = Inventories::where('category', 'medicine')->get();
        return view('admin.inventory.medicine', compact('items'));
    }

    // Show all equipment
    public function equipment()
    {
        $items = Inventories::where('category', 'equipment')->get();
        return view('admin.inventory.equipment', compact('items'));
    }

    // Store new inventory item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:medicine,equipment',
            'type' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'condition' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
        ]);

        Inventories::create(array_merge($request->all(), [
            'admin_id' => auth()->id(),
        ]));

        return back()->with('success', 'Inventory item added!');
    }

    // Edit inventory item
    public function edit($id)
    {
        $item = Inventories::findOrFail($id);
        return view('admin.inventory.edit', compact('item'));
    }

    // Update inventory item
    public function update(Request $request, $id)
    {
        $item = Inventories::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:medicine,equipment',
            'type' => 'nullable|string|max:255',
            'quantity' => 'required|integer|min:0',
            'condition' => 'nullable|string|max:255',
            'expiration_date' => 'nullable|date',
        ]);

        $item->update($request->all());

        return back()->with('success', 'Inventory item updated!');
    }

    // Delete inventory item
    public function destroy($id)
    {
        Inventories::destroy($id);
        return back()->with('success', 'Inventory item deleted!');
    }

    // Show expired / archived items
    public function expired()
    {
        $today = Carbon::today();

        $expiredMedicines = Inventories::where('category', 'medicine')
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<', $today)
            ->get();

        $expiredEquipment = Inventories::where('category', 'equipment')
            ->whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<', $today)
            ->get();

        return view('admin.inventory.archived', compact('expiredMedicines', 'expiredEquipment'));
    }

public function indexForStaff()
{
    $medicines = Inventories::where('category', 'medicine')->get();
    $equipments = Inventories::where('category', 'equipment')->get();

    // Return the existing inventory view
    return view('clinic_staff.inventory', compact('medicines', 'equipments'));
}
}
