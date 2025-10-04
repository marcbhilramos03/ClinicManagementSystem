<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::with(['patient', 'staff'])->latest()->get();
        $patients = User::where('role', 'patient')->get();
        $staff = User::whereIn('role', ['doctor', 'nurse', 'clinic_staff'])->get();

        return view('patient.records', compact('records', 'patients', 'staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'staff_id'   => 'required|exists:users,id',
            'diagnosis'  => 'required|string|max:255',
            'treatment'  => 'required|string|max:255',
            'note'       => 'nullable|string',
            'date'       => 'required|date',
        ]);

        MedicalRecord::create($request->all());

        return redirect()->route('medical_records.index')->with('success', 'Medical record added successfully.');
    }

    public function update(Request $request, MedicalRecord $medical_record)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'staff_id'   => 'required|exists:users,id',
            'diagnosis'  => 'required|string|max:255',
            'treatment'  => 'required|string|max:255',
            'note'       => 'nullable|string',
            'date'       => 'required|date',
        ]);

        $medical_record->update($request->all());

        return redirect()->route('medical_records.index')->with('success', 'Medical record updated successfully.');
    }

    public function destroy(MedicalRecord $medical_record)
    {
        $medical_record->delete();

        return redirect()->route('medical_records.index')->with('success', 'Medical record deleted successfully.');
    }
}
