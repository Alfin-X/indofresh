<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Allow both admin and employee to view catalogs
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            $action = $request->route()->getActionMethod();

            // Allow index and show for both admin and employee
            if (in_array($action, ['index', 'show'])) {
                if ($user->isAdmin() || $user->isEmployee()) {
                    return $next($request);
                }
            }

            // Only admin can create, edit, update, delete
            if (in_array($action, ['create', 'store', 'edit', 'update', 'destroy'])) {
                if ($user->isAdmin()) {
                    return $next($request);
                }
            }

            abort(403, 'Unauthorized access');
        });
    }

    /**
     * Display a listing of catalogs
     */
    public function index()
    {
        $catalogs = Catalog::active()->paginate(12);
        $user = auth()->user();

        if ($user->isAdmin()) {
            return view('admin.catalogs.index', compact('catalogs'));
        } else {
            return view('employee.catalogs.index', compact('catalogs'));
        }
    }

    /**
     * Show the form for creating a new catalog
     */
    public function create()
    {
        return view('admin.catalogs.create');
    }

    /**
     * Store a newly created catalog
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'status' => ['boolean'],
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('catalogs', 'public');
        }

        Catalog::create($data);

        return redirect()->route('catalogs.index')->with('success', 'Product added successfully.');
    }

    /**
     * Display the specified catalog
     */
    public function show(Catalog $catalog)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return view('admin.catalogs.show', compact('catalog'));
        } else {
            return view('employee.catalogs.show', compact('catalog'));
        }
    }

    /**
     * Show the form for editing the specified catalog
     */
    public function edit(Catalog $catalog)
    {
        return view('admin.catalogs.edit', compact('catalog'));
    }

    /**
     * Update the specified catalog
     */
    public function update(Request $request, Catalog $catalog)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'status' => ['boolean'],
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($catalog->image) {
                Storage::disk('public')->delete($catalog->image);
            }
            $data['image'] = $request->file('image')->store('catalogs', 'public');
        }

        $catalog->update($data);

        return redirect()->route('catalogs.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified catalog
     */
    public function destroy(Catalog $catalog)
    {
        // Delete image if exists
        if ($catalog->image) {
            Storage::disk('public')->delete($catalog->image);
        }

        $catalog->delete();

        return redirect()->route('catalogs.index')->with('success', 'Product deleted successfully.');
    }
}
