<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use Illuminate\Http\Request;

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

            // Only admin can create, edit, update
            if (in_array($action, ['create', 'store', 'edit', 'update'])) {
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
        $catalogs = Catalog::paginate(12);
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
            'id_produk' => ['required', 'string', 'size:6', 'unique:catalogs,id_produk'],
            'nama' => ['required', 'string', 'max:20'],
            'stock' => ['required', 'integer', 'min:0'],
            'keterangan' => ['required', 'string', 'max:50'],
            'harga' => ['required', 'integer', 'min:0'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            'id_produk.required' => 'Data tidak boleh kosong',
            'id_produk.size' => 'ID Produk harus 6 karakter',
            'id_produk.unique' => 'ID Produk sudah digunakan',
            'nama.required' => 'Data tidak boleh kosong',
            'nama.max' => 'Nama produk maksimal 20 karakter',
            'stock.required' => 'Data tidak boleh kosong',
            'keterangan.required' => 'Data tidak boleh kosong',
            'keterangan.max' => 'Keterangan maksimal 50 karakter',
            'harga.required' => 'Data tidak boleh kosong',
        ]);

        $data = $request->only(['id_produk', 'nama', 'stock', 'keterangan', 'harga']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = file_get_contents($request->file('gambar')->getRealPath());
        }

        Catalog::create($data);

        return redirect('/catalogs')->with('success', 'Produk berhasil ditambahkan.');
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
            'nama' => ['required', 'string', 'max:20'],
            'stock' => ['required', 'integer', 'min:0'],
            'keterangan' => ['required', 'string', 'max:50'],
            'harga' => ['required', 'integer', 'min:0'],
            'gambar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            'nama.required' => 'Data tidak boleh kosong',
            'nama.max' => 'Nama produk maksimal 20 karakter',
            'stock.required' => 'Data tidak boleh kosong',
            'keterangan.required' => 'Data tidak boleh kosong',
            'keterangan.max' => 'Keterangan maksimal 50 karakter',
            'harga.required' => 'Data tidak boleh kosong',
        ]);

        $data = $request->only(['nama', 'stock', 'keterangan', 'harga']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = file_get_contents($request->file('gambar')->getRealPath());
        }

        $catalog->update($data);

        // Handle AJAX request
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Produk berhasil diubah.']);
        }

        return redirect('/catalogs')->with('success', 'Produk berhasil diubah.');
    }


}
