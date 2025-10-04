<?php

namespace App\Http\Controllers;

use App\Models\DentalRecords;
use Illuminate\Http\Request;

class DentalRecordsController extends Controller
{
    // List all dental records
    public function index()
    {
        $records = DentalRecords::with(['patient', 'staff'])->latest()->get();
        return response()->json($records);
    }

    // Store a new dental record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'staff_id'   => 'required|exists:users,id',
            'diagnosis'  => 'required|string',
            'treatment'  => 'nullable|string',
            'notes'      => 'nullable|string',
            'date'       => 'required|date',
        ]);

        $record = DentalRecords::create($validated);

        return response()->json([
            'message' => 'Dental record created successfully',
            'data' => $record
        ]);
    }

    // Show a single dental record
    public function show($id)
    {
        $record = DentalRecords::with(['patient', 'staff'])->findOrFail($id);
        return response()->json($record);
    }

    // Update a dental record
    public function update(Request $request, $id)
    {
        $record = DentalRecords::findOrFail($id);

        $validated = $request->validate([
            'diagnosis'  => 'nullable|string',
            'treatment'  => 'nullable|string',
            'notes'      => 'nullable|string',
            'date'       => 'nullable|date',
        ]);

        $record->update($validated);

        return response()->json([
            'message' => 'Dental record updated successfully',
            'data' => $record
        ]);
    }

    // Delete a dental record
    public function destroy($id)
    {
        $record = DentalRecords::findOrFail($id);
        $record->delete();

        return response()->json([
            'message' => 'Dental record deleted successfully'
        ]);
    }
}
