<?php

namespace App\Http\Controllers;

use App\Models\ArchivedInventory;
use Illuminate\Http\Request;

class ArchivedInventoryController extends Controller
{
    public function index()
    {
        $items = ArchivedInventory::with(['inventory', 'admin'])->latest()->get();
        return view('admin.inventory.archived', compact('items'));
    }

    public function show($id)
    {
        $item = ArchivedInventory::with(['inventory', 'admin'])->findOrFail($id);
        return view('admin.inventory.archive.show', compact('item'));
    }

    public function edit($id)
    {
        $item = ArchivedInventory::findOrFail($id);
        return view('admin.inventory.archive.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = ArchivedInventory::findOrFail($id);

        $request->validate([
            'status' => 'required|in:expired,used,damaged,other',
            'notes'  => 'nullable|string|max:1000',
        ]);

        $item->update($request->only(['status', 'notes']));

        return back()->with('success', 'Archived inventory updated successfully!');
    }

    public function destroy($id)
    {
        $item = ArchivedInventory::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Archived inventory deleted permanently!');
    }
}
