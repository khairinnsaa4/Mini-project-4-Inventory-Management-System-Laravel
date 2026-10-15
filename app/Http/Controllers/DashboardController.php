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
        $user = Auth::user();

        // 1. Total Koleksi Heels (COUNT) & Unit Ready
        $total_produk = Product::count();
        $total_unit_ready = (int)Product::sum('stock');

        // 2. Valuasi Inventaris Butik (SUM(stock * price))
        $total_nilai = (float)Product::sum(DB::raw('stock * price'));

        // 3. Heels Stok Menipis (stock <= minimum_stock)
        $total_low_stock = Product::whereColumn('stock', '<=', 'minimum_stock')->count();

        // 4. Statistik Perputaran Masuk & Keluar (Total Unit)
        $total_in = (int)StockMovement::where('type', 'IN')->sum('quantity');
        $total_out = (int)StockMovement::where('type', 'OUT')->sum('quantity');

        // 5. Statistik Transaksi Hari Ini (Khusus Aktivitas Petugas Login)
        $my_tx_today = StockMovement::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->count();
        $my_units_today = (int)StockMovement::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->sum('quantity');

        // 6. Data Grafik Tren Mutasi 7 Hari Terakhir (Chart.js)
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

        // 7. Data Grafik Distribusi Kategori Heels (Chart.js)
        $categoriesData = Category::withCount(['products as total_stock' => function ($query) {
            $query->select(DB::raw('COALESCE(SUM(stock), 0)'));
        }])->orderByDesc('total_stock')->get();

        $catLabels = $categoriesData->pluck('name')->toArray();
        $catStocks = $categoriesData->pluck('total_stock')->map(fn($v) => (int)$v)->toArray();

        // 8. Daftar Produk Perlu Re-order
        $low_stock_products = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->take(6)
            ->get();

        // 9. Aktivitas Mutasi Terkini
        $recent_movements = StockMovement::with(['product', 'user.profile'])
            ->latest('created_at')
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'total_produk',
            'total_unit_ready',
            'total_nilai',
            'total_low_stock',
            'total_in',
            'total_out',
            'my_tx_today',
            'my_units_today',
            'chartDates',
            'chartSales',
            'chartRestock',
            'catLabels',
            'catStocks',
            'low_stock_products',
            'recent_movements'
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
                ->with('error', 'Semua koleksi heels habis stok! Simulasi otomatis tidak dapat dijalankan.');
        }

        $qtySold = rand(1, min(2, (int)$candidate->stock));
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
            ->with('success', "Simulasi Berhasil: Terjual {$qtySold} pasang '{$candidate->name}' (Faktur #{$invoiceCode}). Stok berkurang dan grafik ter-update!");
    }
}
