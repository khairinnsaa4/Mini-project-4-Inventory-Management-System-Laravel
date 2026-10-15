<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockMovement;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menggunakan Query Builder Eloquent dengan Search, Filter, Sort, dan Pagination (Slide 32 & 38)
     */
    public function index(Request $request)
    {
        $allowedSort = ['name', 'sku', 'price', 'stock', 'created_at'];
        $sortBy = in_array($request->query('sort'), $allowedSort, true) ? $request->query('sort') : 'name';
        $order = strtolower($request->query('order', 'asc')) === 'desc' ? 'desc' : 'asc';

        $products = Product::with(['category', 'suppliers'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category_id'), function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->orderBy($sortBy, $order)
            ->paginate(5)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'sortBy', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeAdmin();

        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('products.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'sku'           => ['required', 'string', 'max:50', 'unique:products,sku'],
            'name'          => ['required', 'string', 'max:150'],
            'category_id'   => ['required', 'exists:categories,id'],
            'price'         => ['required', 'numeric', 'min:0'],
            'stock'         => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'suppliers'     => ['nullable', 'array'],
            'suppliers.*'   => ['exists:suppliers,id'],
        ]);

        DB::transaction(function () use ($validated, $request) {
            $product = Product::create([
                'sku'           => $validated['sku'],
                'name'          => $validated['name'],
                'category_id'   => $validated['category_id'],
                'price'         => $validated['price'],
                'stock'         => $validated['stock'],
                'minimum_stock' => $validated['minimum_stock'],
            ]);

            // Sync suppliers (Many-to-Many)
            if (!empty($validated['suppliers'])) {
                $syncData = [];
                foreach ($validated['suppliers'] as $supId) {
                    $syncData[$supId] = ['supplier_price' => $validated['price'] * 0.85];
                }
                $product->suppliers()->sync($syncData);
            }

            // Catat transaksi awal jika stok > 0
            if ($validated['stock'] > 0) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id'    => Auth::id(),
                    'type'       => 'IN',
                    'quantity'   => $validated['stock'],
                    'notes'      => 'Stok awal registrasi produk baru',
                ]);
            }
        });

        return redirect()->route('products.index')
            ->with('success', "Produk '{$validated['name']}' berhasil ditambahkan ke inventaris.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'suppliers', 'stockMovements.user']);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorizeAdmin();

        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $selectedSuppliers = $product->suppliers->pluck('id')->toArray();

        return view('products.edit', compact('product', 'categories', 'suppliers', 'selectedSuppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'sku'           => ['required', 'string', 'max:50', 'unique:products,sku,' . $product->id],
            'name'          => ['required', 'string', 'max:150'],
            'category_id'   => ['required', 'exists:categories,id'],
            'price'         => ['required', 'numeric', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'suppliers'     => ['nullable', 'array'],
            'suppliers.*'   => ['exists:suppliers,id'],
        ]);

        DB::transaction(function () use ($product, $validated) {
            $product->update([
                'sku'           => $validated['sku'],
                'name'          => $validated['name'],
                'category_id'   => $validated['category_id'],
                'price'         => $validated['price'],
                'minimum_stock' => $validated['minimum_stock'],
            ]);

            // Sync suppliers
            $syncData = [];
            if (!empty($validated['suppliers'])) {
                foreach ($validated['suppliers'] as $supId) {
                    $syncData[$supId] = ['supplier_price' => $validated['price'] * 0.85];
                }
            }
            $product->suppliers()->sync($syncData);
        });

        return redirect()->route('products.index')
            ->with('success', "Data produk '{$product->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorizeAdmin();

        // Business Rule (Slide 33): Produk yang punya histori tidak boleh dihapus sembarangan
        if ($product->stockMovements()->count() > 0) {
            return redirect()->route('products.index')
                ->with('error', "Produk '{$product->name}' tidak boleh dihapus karena memiliki rekam jejak transaksi stok.");
        }

        $product->suppliers()->detach();
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Produk '{$product->name}' berhasil dihapus dari sistem.");
    }

    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak: Hanya Admin yang diizinkan mengelola data produk.');
        }
    }
}
