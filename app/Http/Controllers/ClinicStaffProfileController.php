<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalInformation;
use App\Models\Credential;
use Illuminate\Support\Facades\Auth;

class ClinicStaffProfileController extends Controller
{
    /**
     * Show the form for editing the clinic staff profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $info = $user->personalInformation;
        $credential = $info?->credential;

        return view('clinic_staff.profile', compact('info', 'credential'));
    }

    /**
     * Update the clinic staff profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'school_id' => 'required|string|size:8|alpha_num|unique:personal_information,school_id,' . optional($user->personalInformation)->id,
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
            'credential_type' => 'required|in:license,degree',
            'license_type' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = $user->id;
        $validated['school_id'] = strtoupper($validated['school_id']);

        $personalInfo = PersonalInformation::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        Credential::updateOrCreate(
            ['personal_information_id' => $personalInfo->id],
            [
                'credential_type' => $request->credential_type,
                'license_type' => $request->license_type,
                'degree' => $request->degree,
            ]
        );

        $user->update(['profile_complete' => true]);

        return redirect()->route('clinic_staff.profile.view')
                         ->with('success', 'Profile updated successfully!');
    }
    public function profile()
{
    $user = auth()->user();
    $info = $user->personalInformation;
    $credential = $info?->credential;

    return view('clinic_staff.profile_view', compact('info', 'credential'));
}

}
