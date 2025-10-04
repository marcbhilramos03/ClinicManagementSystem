<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalInformation;
use App\Models\Department;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class PatientProfileController extends Controller
{
    // Show patient profile view
    public function show()
    {
        $user = Auth::user();
        $info = $user->personalInformation;

        return view('patient.profile_view', compact('info'));
    }

    // Show patient profile edit form
    public function edit()
    {
        $user = Auth::user();
        $info = $user->personalInformation;

        $departments = Department::all();
        $programs = Program::all();

        return view('patient.profile', compact('info', 'departments', 'programs'));
    }

    // Update patient profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'school_id' => 'required|string|size:8|alpha_num|unique:personal_information,school_id,' . optional($user->personalInformation)->id,
            'category' => 'required|in:student,faculty,non_teaching_personnel,admin,other',
            'department_id' => 'nullable|exists:departments,id',
            'program_id' => 'nullable|exists:programs,id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'birthdate' => 'required|date',
            'address' => 'required|string|max:500',
            'contact_no' => 'required|string|max:20',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_no' => 'required|string|max:20',
            'emergency_contact_relationship' => 'required|string|max:100',
        ]);

        $validated['user_id'] = $user->id;
        $validated['school_id'] = strtoupper($validated['school_id']);

        // Update or create without timestamps
        PersonalInformation::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        $user->update(['profile_complete' => true]);

        return redirect()->route('patient.profile.view')
                         ->with('success', 'Profile updated successfully!');
    }
}
