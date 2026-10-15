<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->withSum('products as total_stock', 'stock')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', "Kategori '{$validated['name']}' berhasil dibuat.");
    }

    public function edit(Category $category)
    {
        $this->authorizeAdmin();
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', "Kategori '{$category->name}' berhasil diperbarui.");
    }

    public function destroy(Category $category)
    {
        $this->authorizeAdmin();

        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', "Kategori tidak dapat dihapus karena masih digunakan oleh produk di inventaris.");
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', "Kategori berhasil dihapus.");
    }

    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak: Hanya Admin yang dapat mengelola kategori.');
        }
    }
}
