<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminController extends Controller
{
// public function settings()
// {
//     return view('admin.settings');
// }
public function profile()
{
    return view('admin.profile');
}

public function updateProfile(Request $request)
{
    $user = auth()->user();

    $data = $request->validate([
        'first_name'    => 'nullable|string|max:255',
        'last_name'     => 'nullable|string|max:255',
        'address'       => 'nullable|string|max:255',
        'phone'         => 'nullable|string|max:50',
        'date_of_birth' => 'nullable|date',
    ]);

    // Update or create personal information
    $user->personalInformation()->updateOrCreate(
        ['user_id' => $user->id],
        $data
    );

    return redirect()->route('admin.profile')->with('success', 'Personal information updated!');
}

// public function updateSettings(Request $request)
// {
//     $user = auth()->user();

//     $request->validate([
//         'email' => 'required|email|unique:users,email,' . $user->id,
//         'password' => 'nullable|min:6|confirmed',
//     ]);

//     $user->email = $request->email;

//     if ($request->filled('password')) {
//         $user->password = bcrypt($request->password);
//     }

//     $user->save();

//     return redirect()->route('admin.settings')->with('success', 'Settings updated successfully!');
// }
    public function manageUsers()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.manageUsers', compact('users'));
    }
    public function dashboard()
    {
    $totalUsers = User::count();
    $totalPatient = User::where('role', 'patient')->count();
    $totalStaff = User::where('role', 'clinic_staff')->count();
    $totalAppointments = Appointment::count();

    return view('admin.dashboard', compact(
        'totalUsers', 
        'totalPatient',  
        'totalStaff', 
        'totalAppointments'
    ));
}


}
