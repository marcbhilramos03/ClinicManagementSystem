<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Admin creates new users (patient or clinic staff)
     */
    public function createUser(Request $request)
    {
        // Only admin can create users
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Validate form
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:patient,clinic_staff', // only patient or clinic_staff
        ]);

        // Create user
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.manageUsers')
                         ->with('success', ucfirst($request->role) . ' account created successfully!');
    }

    /**
     * Admin view/manage users
     */
    public function manageUsers()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $users = User::with('personalInformation')->get();

        return view('admin.manageUsers', compact('users'));
    }

    /**
     * Handle patient registration (self-registration)
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'patient', // automatically assign patient role
        ]);

        Auth::login($user);

        return redirect()->route('patient.dashboard');
    }

    /**
     * Handle login for all users
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectByRole(Auth::user()->role);
        }

        return back()->withErrors([
            'username' => 'Invalid username or password',
        ])->with('openLoginModal', true);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logged out successfully.');
    }

    /**
     * Redirect users based on role
     */
    private function redirectByRole($role)
    {
        switch ($role) {
            case 'patient':
                return redirect()->route('patient.dashboard');
            case 'clinic_staff':
                return redirect()->route('clinic_staff.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                Auth::logout();
                return redirect()->route('homepage')->withErrors([
                    'role' => 'Unauthorized role. Please contact the administrator.',
                ]);
        }
    }

    /**
     * Shared patient dashboard
     */
    public function patientDashboard()
    {
        return view('patients.dashboard'); // single dashboard view for all patients
    }
    protected function authenticated($request, $user)
{
    if (!$user->profile_completed) {
        return redirect()->route('profile.complete'); // wizard route
    }

    return redirect()->route($user->role.'.dashboard');
}


}
