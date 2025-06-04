<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $totalEmployees = User::where('role', 'employee')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        return view('admin.dashboard', compact('totalEmployees', 'totalAdmins'));
    }

    /**
     * Show admin profile
     */
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile.show', compact('admin'));
    }

    /**
     * Show edit admin profile form
     */
    public function editProfile()
    {
        $admin = Auth::user();
        return view('admin.profile.edit', compact('admin'));
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $admin->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Show change password form
     */
    public function changePasswordForm()
    {
        return view('admin.profile.change-password');
    }

    /**
     * Update admin password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')->with('success', 'Password updated successfully.');
    }
}
