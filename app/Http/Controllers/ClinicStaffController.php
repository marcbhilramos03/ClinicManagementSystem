<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Appointment;
use App\Models\Inventories;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;

class ClinicStaffController extends Controller
{
    // =========================
    // Dashboard (staff overview)
    // =========================
    public function dashboard()
    {
        $today = Carbon::today();

        // Today's appointments (for this staff only or all, adjust if needed)
        $appointments = Appointment::with(['patient.personalInformation', 'clinicStaff.personalInformation'])
            ->whereDate('appointment_date', $today)
            ->orderBy('appointment_date', 'asc')
            ->get();

     // Recent medical records ordered by clinic session date (latest first)
    $medicalRecords = MedicalRecord::with([
            'clinicSession.patient.personalInformation',
            'clinicSession.checkupType'
        ])
        ->join('clinic_sessions', 'medical_records.clinic_session_id', '=', 'clinic_sessions.id')
        ->orderByDesc('clinic_sessions.session_date')
        ->select('medical_records.*')
        ->limit(5) // show last 5 records
        ->get();

        // Inventory stock alerts
        $inventory = Inventories::orderBy('quantity', 'asc')->get();

        return view('clinic_staff.dashboard', compact('appointments', 'medicalRecords', 'inventory'));
    }

    // =========================
    // Staff Profile
    // =========================
    public function profile()
    {
        $user = auth()->user();
        $info = $user->personalInformation;

        return view('clinic_staff.profile', compact('info'));
    }

    // =========================
    // Appointments
    // =========================
    public function appointments()
    {
        $appointments = Appointment::with('patient')->latest()->get();
        return view('clinic_staff.appointments', compact('appointments'));
    }

    public function updateAppointmentStatus(Request $request, Appointment $appointment)
    {
        $appointment->update(['status' => 'approved']);
        return back()->with('success', 'Appointment approved.');
    }

    public function destroyAppointment(Appointment $appointment)
    {
        $appointment->delete();
        return back()->with('success', 'Appointment cancelled.');
    }

    // =========================
    // Inventory
    // =========================
    public function medicineInventory()
    {
        $medicines = Inventories::where('type', 'medicine')->get();
        return view('clinic_staff.inventories.medicine', compact('medicines'));
    }

    public function equipmentInventory()
    {
        $equipments = Inventories::where('type', 'equipment')->get();
        return view('clinic_staff.inventories.equipment', compact('equipments'));
    }
}
