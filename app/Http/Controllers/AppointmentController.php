<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Department;
use App\Models\Program;

class AppointmentController extends Controller
{
    // -------------------------------
    // Admin: View all appointments
    // -------------------------------
    public function index()
    {
        $appointments = Appointment::with([
            'department',
            'program',
            'clinicStaff.personalInformation',
            'patient.personalInformation'
        ])->get();

        $departments = Department::all();
        $programs = Program::all();
        $clinicStaff = User::where('role', 'clinic_staff')->with('personalInformation')->get();

        return view('admin.appointment', compact('appointments', 'departments', 'programs', 'clinicStaff'));
    }

    // Admin: Store new appointment
    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'program_id' => 'nullable|exists:programs,id',
            'clinic_staff_id' => 'nullable|exists:users,id',
            'appointment_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        Appointment::create($data);

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment created successfully!');
    }

    // Admin: Update appointment status and info
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'clinic_staff_id' => 'nullable|exists:users,id',
            'appointment_date' => 'required|date',
            'status' => 'required|in:pending,approved,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($data);

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment updated!');
    }

    // Admin: Delete appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted.');
    }

    // -------------------------------
    // Clinic Staff: View own appointments
    // -------------------------------
 public function clinicStaffAppointments()
{
    $appointments = Appointment::with(['patient', 'department', 'program', 'clinicStaff'])->get();

    return view('clinic_staff.appointments', compact('appointments')); // <- no ".index"
}


    // Optional: Clinic Staff update notes or status
    public function updateClinicStaffAppointment(Request $request, Appointment $appointment)
    {
        $user = auth()->user();

        // Ensure this appointment belongs to this staff
        if ($appointment->clinic_staff_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'status' => 'required|in:pending,approved,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($data);

        return redirect()->route('clinic_staff.appointments.index')->with('success', 'Appointment updated!');
    }
    
}
