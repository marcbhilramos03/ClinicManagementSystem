<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vital;
use App\Models\User;

class VitalController extends Controller
{
    // Show all vitals
    public function index()
    {
        $vitals = Vital::with('patient')->latest()->get();
        return view('clinic_staff.vitals.index', compact('vitals'));
    }

    // Show form to create
    public function create()
    {
        $patients = User::where('role', 'student')->get(); // or patient role
        return view('clinic_staff.vitals.create', compact('patients'));
    }

    // Store vitals
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'blood_pressure' => 'nullable|string|max:20',
            'heart_rate' => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'temperature' => 'nullable|numeric',
        ]);

        Vital::create($request->all());

        return redirect()->route('vitals.index')->with('success', 'Vitals added successfully!');
    }

    // Optional: Show individual vitals
    public function show(Vital $vital)
    {
        return view('clinic_staff.vitals.show', compact('vital'));
    }
}
