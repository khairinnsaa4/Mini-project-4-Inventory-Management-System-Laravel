<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\StockMovement;

class StockController extends Controller
{
    /**
     * Tampilan Form Transaksi Barang Masuk (IN)
     */
    public function in(Request $request)
    {
        $products = Product::orderBy('name')->get();
        $selectedProductId = $request->query('product_id');

        return view('stock.in', compact('products', 'selectedProductId'));
    }

    /**
     * Proses Simpan Transaksi Barang Masuk
     */
    public function storeIn(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'notes'      => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

            // Tambah stok
            $product->increment('stock', $validated['quantity']);

            // Catat histori mutasi
            StockMovement::create([
                'product_id' => $product->id,
                'user_id'    => Auth::id(),
                'type'       => 'IN',
                'quantity'   => $validated['quantity'],
                'notes'      => $validated['notes'] ?: 'Penerimaan barang masuk (Laravel)',
            ]);
        });

        return redirect()->route('stock.history')
            ->with('success', "Berhasil mencatat barang masuk sebanyak {$validated['quantity']} unit.");
    }

    /**
     * Tampilan Form Transaksi Barang Keluar (OUT)
     */
    public function out(Request $request)
    {
        $products = Product::orderBy('name')->get();
        $selectedProductId = $request->query('product_id');

        return view('stock.out', compact('products', 'selectedProductId'));
    }

    /**
     * Proses Simpan Transaksi Barang Keluar
     * Business Rule (Slide 26 & 33): Barang keluar tidak boleh melebihi stok (Stok tidak boleh minus)
     */
    public function storeOut(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'notes'      => ['nullable', 'string', 'max:255'],
        ]);

        $errorMsg = null;

        DB::transaction(function () use ($validated, &$errorMsg) {
            // LockForUpdate untuk mencegah race condition (Slide 26)
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

            if ($validated['quantity'] > $product->stock) {
                $errorMsg = "Stok tidak mencukupi! Sisa stok '{$product->name}' hanya {$product->stock} unit, sedangkan permintaan keluar adalah {$validated['quantity']} unit.";
                return;
            }

            // Kurangi stok
            $product->decrement('stock', $validated['quantity']);

            // Catat histori mutasi
            StockMovement::create([
                'product_id' => $product->id,
                'user_id'    => Auth::id(),
                'type'       => 'OUT',
                'quantity'   => $validated['quantity'],
                'notes'      => $validated['notes'] ?: 'Pengeluaran barang keluar (Laravel)',
            ]);
        });

        if ($errorMsg) {
            return back()->withInput()->with('error', $errorMsg);
        }

        return redirect()->route('stock.history')
            ->with('success', "Berhasil mengeluarkan {$validated['quantity']} unit barang.");
    }

    /**
     * Tampilan Audit Log Riwayat Pergerakan Stok
     */
    public function history(Request $request)
    {
        $type = $request->query('type');

        $movements = StockMovement::with(['product', 'user.profile'])
            ->when(in_array($type, ['IN', 'OUT'], true), function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('stock.history', compact('movements', 'type'));
    }
}
