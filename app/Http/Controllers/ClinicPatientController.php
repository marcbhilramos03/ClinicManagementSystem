<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vital;
use App\Models\Vitals;
use App\Models\CheckupType;
use App\Models\Inventories;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\ClinicSession;
use App\Models\MedicalRecord;

class ClinicPatientController extends Controller
{
    // -----------------------------
    // 1️⃣ View all patients (index)
    // -----------------------------
    public function index(Request $request)
    {
        $patients = User::where('role', 'patient')
            ->when($request->search, function($q) use ($request) {
                $search = $request->search;
                $q->where('username', 'like', "%$search%")
                  ->orWhereHas('personalInformation', function($q2) use ($search) {
                      $q2->where('first_name', 'like', "%$search%")
                         ->orWhere('last_name', 'like', "%$search%");
                  });
            })
            ->get();

        return view('clinic_staff.patients.index', compact('patients'));
    }

     // Show single Blade for Medical Record workflow
    public function addMedicalRecord(Request $request)
    {
        $patients = collect();
        $checkupTypes = CheckupType::all();
        $selectedPatient = null;

        // Step 1: Search patient
        if ($request->filled('search')) {
            $search = $request->search;
            $patients = User::where('role', 'patient')
                ->whereHas('personalInformation', fn($q) => $q->where('school_id', 'like', "%$search%"))
                ->get();
        }

        // Step 2: Selected patient
        if ($request->filled('patient_id')) {
            $selectedPatient = User::find($request->patient_id);
        }

        return view('clinic_staff.patients.add_medical_record', compact('patients', 'checkupTypes', 'selectedPatient'));
    }

    public function medicalRecordStore(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'checkup_type_id' => 'required|exists:checkup_types,id',
            'reason' => 'required|string',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
            'medicine_id' => 'nullable|exists:inventories,id',
            'dosage' => 'nullable|string',
            'duration' => 'nullable|string',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $patient = User::findOrFail($request->patient_id);

        // Create clinic session
        $session = ClinicSession::create([
            'patient_id' => $patient->id,
            'clinic_staff_id' => auth()->id(),
            'checkup_type_id' => $request->checkup_type_id,
            'session_date' => now(),
            'reason' => $request->reason,
        ]);

        // Create medical record
        $medicalRecord = MedicalRecord::create([
            'clinic_session_id' => $session->id,
            'diagnosis' => $request->diagnosis,
            'treatment' => $request->treatment,
            'notes' => $request->notes,
        ]);

        // Optional prescription
        if ($request->filled('medicine_id') && $request->quantity > 0) {
            $medicine = Inventories::find($request->medicine_id);
            if ($medicine && $medicine->quantity >= $request->quantity) {
                Prescription::create([
                    'clinic_session_id' => $session->id,
                    'inventory_id' => $medicine->id,
                    'dosage' => $request->dosage,
                    'duration' => $request->duration,
                    'quantity' => $request->quantity,
                    'frequency' => $request->frequency,
                ]);
                $medicine->decrement('quantity', $request->quantity);
            }
        }

        return redirect()->route('clinic_staff.patients.add_medical_record')
            ->with('success', 'Medical record added successfully!');
    }
public function addVitals(Request $request)
{
    $patients = collect();
    $selectedPatient = null;
    $checkupTypes = CheckupType::all(); // get all checkup types for dropdown

    // Step 1: Search patient
    if ($request->filled('search')) {
        $search = $request->search;
        $patients = User::where('role', 'patient')
            ->whereHas('personalInformation', fn($q) => $q->where('school_id', 'like', "%$search%"))
            ->get();
    }

    // Step 2: Selected patient
    if ($request->filled('patient_id')) {
        $selectedPatient = User::find($request->patient_id);
    }

    return view('clinic_staff.patients.add_vitals', compact('patients', 'selectedPatient', 'checkupTypes'));
}

public function vitalsStore(Request $request)
{
    $request->validate([
        'patient_id' => 'required|exists:users,id',
        'checkup_type_id' => 'required|exists:checkup_types,id',
        'weight' => 'required|numeric',
        'height' => 'required|numeric',
        'blood_pressure' => 'required|string',
        'heart_rate' => 'required|numeric',
        'respiratory_rate' => 'required|numeric',
        'temperature' => 'required|numeric',
        'reason' => 'nullable|string',
    ]);

    $patient = User::findOrFail($request->patient_id);

    // Create clinic session with selected checkup type
    $clinicSession = ClinicSession::create([
        'patient_id' => $patient->id,
        'clinic_staff_id' => auth()->id(),
        'checkup_type_id' => $request->checkup_type_id,
        'session_date' => now(),
        'reason' => $request->reason ?? 'Vitals Check',
    ]);

    // Calculate BMI
    $bmi = $request->weight / (($request->height / 100) ** 2);

    // Store vitals
    Vitals::create([
        'clinic_session_id' => $clinicSession->id,
        'weight' => $request->weight,
        'height' => $request->height,
        'blood_pressure' => $request->blood_pressure,
        'heart_rate' => $request->heart_rate,
        'respiratory_rate' => $request->respiratory_rate,
        'temperature' => $request->temperature,
        'bmi' => round($bmi, 2),
    ]);

    return redirect()->route('clinic_staff.patients.add_vitals', ['patient_id' => $patient->id])
        ->with('success', 'Vitals added and session created successfully!');
}


}
