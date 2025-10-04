<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Program;
use App\Models\MedicalRecord;

class PatientController extends Controller
{
    /**
     * Dashboard with summary counts
     */
    public function dashboard()
    {
        $patientId = auth()->id();

        // Count appointments for this patient
        $appointmentsCount = Appointment::where('patient_id', $patientId)->count();

        // Count medical records via clinic session
        $recordsCount = MedicalRecord::whereHas('clinicSession', function ($query) use ($patientId) {
            $query->where('patient_id', $patientId);
        })->count();

        return view('patient.dashboard', compact('appointmentsCount', 'recordsCount'));
    }

    /**
     * Show patient profile
     */
    public function profile()
    {
        $user = auth()->user();
        $info = $user->personalInformation;

        // Departments for selection (programs can load via AJAX)
        $departments = Department::all();

        return view('patient.profile', compact('user', 'info', 'departments'));
    }

    /**
     * Show health records for patient
     */
    public function records()
    {
        $patientId = auth()->id();

        $records = MedicalRecord::whereHas('clinicSession', function ($query) use ($patientId) {
            $query->where('patient_id', $patientId);
        })
        ->with(['clinicSession.staff.personalInformation'])
        ->latest()
        ->paginate(10);

        return view('patient.records', compact('records'));
    }

    /**
     * Show appointments for patient
     */
    public function myAppointments()
    {
        $patientId = auth()->id();

        $appointments = Appointment::with(['department', 'program', 'clinicStaff.personalInformation'])
                                   ->where('patient_id', $patientId)
                                   ->orderBy('appointment_date', 'desc')
                                   ->get();

        return view('patient.appointments', compact('appointments'));
    }
}
