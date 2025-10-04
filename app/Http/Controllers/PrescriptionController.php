<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    // List prescriptions
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'staff', 'dentalRecord', 'clinicSession'])->latest()->get();
        return response()->json($prescriptions);
    }

    // Store prescription
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'        => 'required|exists:users,id',
            'staff_id'          => 'required|exists:users,id',
            'medicine_name'     => 'required|string',
            'dosage'            => 'required|string',
            'frequency'         => 'required|string',
            'duration_days'     => 'nullable|integer',
            'instructions'      => 'nullable|string',
            'dental_record_id'  => 'nullable|exists:dental_records,id',
            'clinic_session_id' => 'nullable|exists:clinic_sessions,id',
        ]);

        $prescription = Prescription::create($validated);

        return response()->json([
            'message' => 'Prescription created successfully',
            'data'    => $prescription,
        ]);
    }

    // Show single prescription
    public function show($id)
    {
        $prescription = Prescription::with(['patient', 'staff', 'dentalRecord', 'clinicSession'])->findOrFail($id);
        return response()->json($prescription);
    }

    // Update prescription
    public function update(Request $request, $id)
    {
        $prescription = Prescription::findOrFail($id);

        $validated = $request->validate([
            'medicine_name' => 'nullable|string',
            'dosage'        => 'nullable|string',
            'frequency'     => 'nullable|string',
            'duration_days' => 'nullable|integer',
            'instructions'  => 'nullable|string',
        ]);

        $prescription->update($validated);

        return response()->json([
            'message' => 'Prescription updated successfully',
            'data'    => $prescription,
        ]);
    }

    // Delete prescription
    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->delete();

        return response()->json([
            'message' => 'Prescription deleted successfully'
        ]);
    }
}
