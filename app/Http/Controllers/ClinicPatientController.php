<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MedicalRecord;
use App\Models\Vital;
use App\Models\Inventories;

class ClinicPatientController extends Controller
{
    // View all patients
    public function index(Request $request)
    {
        $patients = User::where('role', 'patient')
            ->with('personalInformation')
            ->when($request->search, function ($query, $search) {
                $query->whereHas('personalInformation', function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%");
                });
            })
            ->get();

        return view('clinic_staff.patients.index', compact('patients'));
    }

    // Add Medical Record
    public function createMedicalRecord(User $patient)
    {
        $inventories = Inventories::where('type', 'medicine')->get(); // optional prescription
        return view('clinic_staff.patients.add_medical_record', compact('patient', 'inventories'));
    }

    public function storeMedicalRecord(Request $request, User $patient)
    {
        $data = $request->validate([
            'diagnosis' => 'required|string|max:255',
            'treatment' => 'required|string|max:255',
            'note'      => 'nullable|string',
            'date'      => 'required|date',
            // prescription fields optional
            'inventory_id' => 'nullable|exists:inventories,id',
            'dosage'       => 'nullable|string',
            'frequency'    => 'nullable|string',
            'duration'     => 'nullable|string',
            'quantity'     => 'nullable|integer|min:1',
        ]);

        MedicalRecord::create([
            'patient_id'      => $patient->id,
            'clinic_staff_id' => auth()->id(),
            'diagnosis'       => $data['diagnosis'],
            'treatment'       => $data['treatment'],
            'note'            => $data['note'] ?? null,
            'date'            => $data['date'],
        ]);

        return redirect()->route('clinic_staff.patients.index')->with('success', 'Medical record added.');
    }

    // Add Vitals
    public function createVitals(User $patient)
    {
        return view('clinic_staff.patients.add_vitals', compact('patient'));
    }

    public function storeVitals(Request $request, User $patient)
    {
        $data = $request->validate([
            'blood_pressure'   => 'nullable|string',
            'heart_rate'       => 'nullable|integer',
            'respiratory_rate' => 'nullable|integer',
            'temperature'      => 'nullable|numeric',
            'weight'           => 'nullable|numeric',
            'height'           => 'nullable|numeric',
            'bmi'              => 'nullable|numeric',
        ]);

        Vital::create([
            'patient_id'      => $patient->id,
            'clinic_staff_id' => auth()->id(),
            'blood_pressure'  => $data['blood_pressure'] ?? null,
            'heart_rate'      => $data['heart_rate'] ?? null,
            'respiratory_rate'=> $data['respiratory_rate'] ?? null,
            'temperature'     => $data['temperature'] ?? null,
            'weight'          => $data['weight'] ?? null,
            'height'          => $data['height'] ?? null,
            'bmi'             => $data['bmi'] ?? null,
        ]);

        return redirect()->route('clinic_staff.patients.index')->with('success', 'Vitals recorded.');
    }
}
