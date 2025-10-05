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
    $patient = auth()->user();
    $departmentId = $patient->department_id;
    $programId = $patient->program_id;

    // Next upcoming appointment (future appointments only)
    $nextAppointment = Appointment::where(function ($query) use ($departmentId, $programId) {
            if ($departmentId) {
                $query->where('department_id', $departmentId);
            }
            if ($programId) {
                $query->orWhere('program_id', $programId);
            }
        })
        ->where('appointment_date', '>=', now())
        ->orderBy('appointment_date', 'asc')
        ->first();

    // Count medical records via clinic session
    $recordsCount = MedicalRecord::whereHas('clinicSession', fn($q) => $q->where('patient_id', $patient->id))->count();

    return view('patient.dashboard', compact('nextAppointment', 'recordsCount'));
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

        $records = MedicalRecord::with([
                'clinicSession.ClinicStaff.personalInformation',
                'clinicSession.checkupType'
            ])
            ->join('clinic_sessions', 'medical_records.clinic_session_id', '=', 'clinic_sessions.id')
            ->where('clinic_sessions.patient_id', $patientId)
            ->orderByDesc('clinic_sessions.session_date')
            ->select('medical_records.*') // important to keep MedicalRecord model
            ->paginate(10);

        return view('patient.records', compact('records'));
    }

    /**
     * Show appointments for patient
     */
     public function myAppointments()
{
    $patient = auth()->user();

    $departmentId = $patient->department_id;
    $programId = $patient->program_id;

    $appointments = Appointment::with([
        'department',
        'program',
        'clinicStaff.personalInformation'
    ])
    ->where(function ($query) use ($departmentId, $programId) {
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }
        if ($programId) {
            $query->orWhere('program_id', $programId);
        }
    })
    ->orderBy('appointment_date', 'desc')
    ->paginate(10);

    return view('patient.appointments', compact('appointments'));
}

}
