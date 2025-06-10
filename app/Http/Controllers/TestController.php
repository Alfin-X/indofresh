<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalog;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function testEmployeeAccess()
    {
        $user = auth()->user();
        
        $response = [
            'user_name' => $user->name,
            'user_role' => $user->role,
            'is_employee' => $user->isEmployee(),
            'is_admin' => $user->isAdmin(),
            'message' => 'Employee access test successful!'
        ];
        
        return response()->json($response);
    }
    
    public function testCatalogAccess()
    {
        $user = auth()->user();
        
        // Check if user is employee or admin
        if (!$user->isEmployee() && !$user->isAdmin()) {
            return response()->json(['error' => 'Access denied'], 403);
        }
        
        $catalogs = Catalog::active()->take(5)->get();
        
        return response()->json([
            'user' => $user->name,
            'role' => $user->role,
            'catalogs_count' => $catalogs->count(),
            'catalogs' => $catalogs->pluck('name'),
            'message' => 'Catalog access successful!'
        ]);
    }
    
    public function testRoleMiddleware()
    {
        $user = auth()->user();
        
        return response()->json([
            'user' => $user->name,
            'role' => $user->role,
            'message' => 'Role middleware test passed! Employee can access this route.'
        ]);
    }
}
