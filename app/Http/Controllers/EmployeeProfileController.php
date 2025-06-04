<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class EmployeeProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:employee');
    }

    /**
     * Show employee profile
     */
    public function show()
    {
        $employee = Auth::user();
        return view('employee.profile.show', compact('employee'));
    }

    /**
     * Show edit employee profile form
     */
    public function edit()
    {
        $employee = Auth::user();
        return view('employee.profile.edit', compact('employee'));
    }

    /**
     * Update employee profile
     */
    public function update(Request $request)
    {
        $employee = Auth::user();
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $employee->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('employee.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Show change password form
     */
    public function changePasswordForm()
    {
        return view('employee.profile.change-password');
    }

    /**
     * Update employee password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $employee = Auth::user();

        if (!Hash::check($request->current_password, $employee->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $employee->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('employee.profile')->with('success', 'Password updated successfully.');
    }
}
