<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockMovement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $total_produk = Product::count();
        $total_nilai = Product::sum(DB::raw('stock * price'));
        $total_low_stock = Product::whereColumn('stock', '<=', 'minimum_stock')->count();

        $total_in = StockMovement::where('type', 'IN')->sum('quantity');
        $total_out = StockMovement::where('type', 'OUT')->sum('quantity');

        // Data Grafik Tren Mutasi 7 Hari Terakhir (Chart.js)
        $chartDates = [];
        $chartSales = [];
        $chartRestock = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateStr = $date->toDateString();
            $chartDates[] = $date->format('d M');

            $chartRestock[] = (int)StockMovement::where('type', 'IN')
                ->whereDate('created_at', $dateStr)
                ->sum('quantity');

            $chartSales[] = (int)StockMovement::where('type', 'OUT')
                ->whereDate('created_at', $dateStr)
                ->sum('quantity');
        }

        // Data Grafik Distribusi Kategori Heels (Chart.js)
        $categoriesData = Category::withCount(['products as total_stock' => function ($query) {
            $query->select(DB::raw('COALESCE(SUM(stock), 0)'));
        }])->orderByDesc('total_stock')->get();

        $catLabels = $categoriesData->pluck('name')->toArray();
        $catStocks = $categoriesData->pluck('total_stock')->map(fn($v) => (int)$v)->toArray();

        $low_stock_products = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();

        $recent_movements = StockMovement::with(['product', 'user'])
            ->latest()
            ->take(6)
            ->get();

        $available_products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('dashboard', compact(
            'total_produk',
            'total_nilai',
            'total_low_stock',
            'total_in',
            'total_out',
            'chartDates',
            'chartSales',
            'chartRestock',
            'catLabels',
            'catStocks',
            'low_stock_products',
            'recent_movements',
            'available_products'
        ));
    }

    /**
     * Fitur Real-time: Simulasi Penjualan Otomatis (Auto-Sales Bot)
     * Mengurangi stok otomatis dan mencatat histori transaksi di database seketika
     */
    public function autoSale(Request $request)
    {
        $candidate = Product::where('stock', '>', 0)->inRandomOrder()->first();

        if (!$candidate) {
            return redirect()->route('dashboard')
                ->with('error', 'Semua koleksi heels habis stok! Transaksi otomatis tidak dapat diproses.');
        }

        $qtySold = rand(1, min(2, $candidate->stock));
        $invoiceCode = 'MAI-VIP-' . strtoupper(bin2hex(random_bytes(3)));

        DB::transaction(function () use ($candidate, $qtySold, $invoiceCode) {
            $candidate->decrement('stock', $qtySold);

            StockMovement::create([
                'product_id' => $candidate->id,
                'user_id'    => Auth::id(),
                'type'       => 'OUT',
                'quantity'   => $qtySold,
                'notes'      => "Auto-Sales Bot: Pesanan VIP Butik - Faktur #{$invoiceCode}",
            ]);
        });

        return redirect()->route('dashboard')
            ->with('success', "⚡ Transaksi Otomatis Real-time Berhasil! Terjual {$qtySold} pasang heels '{$candidate->name}' (Faktur #{$invoiceCode}). Stok berkurang dan grafik ter-update!");
    }
}
