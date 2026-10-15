<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('products')
            ->orderBy('name')
            ->get();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:120'],
            'contact_person' => ['nullable', 'string', 'max:100'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'address'        => ['nullable', 'string'],
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', "Supplier '{$validated['name']}' berhasil ditambahkan.");
    }

    public function edit(Supplier $supplier)
    {
        $this->authorizeAdmin();
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:120'],
            'contact_person' => ['nullable', 'string', 'max:100'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'address'        => ['nullable', 'string'],
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', "Data supplier '{$supplier->name}' berhasil diperbarui.");
    }

    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak: Hanya Admin yang dapat mengelola supplier.');
        }
    }
}
