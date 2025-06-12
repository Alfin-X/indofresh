<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->except('index');
        $this->middleware('role:admin,employee')->only('index');
    }

    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $employees = User::where('role', 'employee')->get();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => ['required', 'string', 'max:6', 'unique:users,id_pegawai'],
            'nama_pegawai' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:20', 'unique:users'],
            'password' => ['required', 'string', 'max:20'],
        ], [
            'id_pegawai.required' => 'Data tidak boleh kosong',
            'id_pegawai.max' => 'ID Pegawai maksimal 6 karakter',
            'id_pegawai.unique' => 'ID Pegawai sudah digunakan',
            'nama_pegawai.required' => 'Data tidak boleh kosong',
            'nama_pegawai.max' => 'Nama Pegawai maksimal 20 karakter',
            'email.required' => 'Data tidak boleh kosong',
            'email.max' => 'Email maksimal 20 karakter',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Data tidak boleh kosong',
            'password.max' => 'Password maksimal 20 karakter',
        ]);

        $employee = User::create([
            'id_pegawai' => $request->id_pegawai,
            'name' => $request->nama_pegawai,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
        ]);

        return redirect()->route('employees.index')->with('success', 'Akun pegawai berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(User $employee)
    {
        // Ensure we're only editing employees
        if ($employee->role !== 'employee') {
            abort(404);
        }

        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, User $employee)
    {
        // Ensure we're only updating employees
        if ($employee->role !== 'employee') {
            abort(404);
        }

        $request->validate([
            'id_pegawai' => ['required', 'string', 'max:6', 'unique:users,id_pegawai,' . $employee->id],
            'nama_pegawai' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:20', 'unique:users,email,' . $employee->id],
            'password' => ['nullable', 'string', 'max:20'],
        ], [
            'id_pegawai.required' => 'Data tidak boleh kosong',
            'id_pegawai.max' => 'ID Pegawai maksimal 6 karakter',
            'id_pegawai.unique' => 'ID Pegawai sudah digunakan',
            'nama_pegawai.required' => 'Data tidak boleh kosong',
            'nama_pegawai.max' => 'Nama Pegawai maksimal 20 karakter',
            'email.required' => 'Data tidak boleh kosong',
            'email.max' => 'Email maksimal 20 karakter',
            'email.unique' => 'Email sudah digunakan',
            'password.max' => 'Password maksimal 20 karakter',
        ]);

        $data = [
            'id_pegawai' => $request->id_pegawai,
            'name' => $request->nama_pegawai,
            'email' => $request->email,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Data pegawai berhasil diubah.');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(User $employee)
    {
        // Ensure we're only deleting employees
        if ($employee->role !== 'employee') {
            abort(404);
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
