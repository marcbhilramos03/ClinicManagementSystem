<?php

namespace App\Http\Controllers;

use App\Models\Inventories;
use App\Models\ArchivedInventory;
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

    // Delete inventory item (with archiving)
    public function destroy($id)
    {
        $item = Inventories::findOrFail($id);

        // Archive before deleting
        ArchivedInventory::create([
            'name' => $item->name,
            'type' => $item->type,
            'quantity' => $item->quantity,
            'condition' => $item->condition ?? 'Deleted',
            'expiration_date' => $item->expiration_date,
            'notes' => 'Deleted by admin',
        ]);

        $item->delete();

        return back()->with('success', 'Inventory item archived and deleted!');
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

        // Archive expired medicines
        foreach ($expiredMedicines as $med) {
            ArchivedInventory::firstOrCreate([
                'name' => $med->name,
                'type' => $med->type,
                'quantity' => $med->quantity,
                'condition' => 'Expired',
                'expiration_date' => $med->expiration_date,
            ]);
        }

        // Archive expired equipment
        foreach ($expiredEquipment as $eq) {
            ArchivedInventory::firstOrCreate([
                'name' => $eq->name,
                'type' => $eq->type,
                'quantity' => $eq->quantity,
                'condition' => 'Expired',
                'expiration_date' => $eq->expiration_date,
            ]);
        }

        return view('admin.inventory.archived', compact('expiredMedicines', 'expiredEquipment'));
    }

    // Staff view of current inventory
    public function indexForStaff()
    {
        $medicines = Inventories::where('category', 'medicine')->get();
        $equipments = Inventories::where('category', 'equipment')->get();

        return view('clinic_staff.inventory', compact('medicines', 'equipments'));
    }
}
