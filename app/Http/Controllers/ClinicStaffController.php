<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Inventories;

class ClinicStaffController extends Controller
{
    // =========================
    // Dashboard (staff overview)
    // =========================
    public function dashboard()
    {
        return view('clinic_staff.dashboard');
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
