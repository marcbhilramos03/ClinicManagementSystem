<?php

namespace App\Http\Controllers;

use App\Models\ClinicSession;
use Illuminate\Http\Request;

class ClinicSessionController extends Controller
{
    // List all sessions
    public function index()
    {
        $sessions = ClinicSession::with(['patient', 'staff'])->latest()->get();
        return response()->json($sessions);
    }

    // Store a new session
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'staff_id'   => 'required|exists:users,id',
            'session_type' => 'required|in:general,dental',
            'reason'     => 'nullable|string',
            'notes'      => 'nullable|string',
            'weight'     => 'nullable|numeric',
            'height'     => 'nullable|numeric',
            'blood_pressure' => 'nullable|string',
            'heart_rate' => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'temperature' => 'nullable|numeric',
        ]);

        $session = ClinicSession::create($validated);

        return response()->json([
            'message' => 'Clinic session created successfully',
            'data' => $session
        ]);
    }

    // Show a single session
    public function show($id)
    {
        $session = ClinicSession::with(['patient', 'staff'])->findOrFail($id);
        return response()->json($session);
    }

    // Update a session
    public function update(Request $request, $id)
    {
        $session = ClinicSession::findOrFail($id);

        $validated = $request->validate([
            'session_type' => 'nullable|in:general,dental',
            'reason'     => 'nullable|string',
            'notes'      => 'nullable|string',
            'weight'     => 'nullable|numeric',
            'height'     => 'nullable|numeric',
            'blood_pressure' => 'nullable|string',
            'heart_rate' => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'temperature' => 'nullable|numeric',
        ]);

        $session->update($validated);

        return response()->json([
            'message' => 'Clinic session updated successfully',
            'data' => $session
        ]);
    }

    // Delete a session
    public function destroy($id)
    {
        $session = ClinicSession::findOrFail($id);
        $session->delete();

        return response()->json([
            'message' => 'Clinic session deleted successfully'
        ]);
    }
}
