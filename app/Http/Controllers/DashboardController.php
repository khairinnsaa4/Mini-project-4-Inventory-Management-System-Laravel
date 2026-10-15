<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\StockMovement;

class DashboardController extends Controller
{
    public function index()
    {
        $total_produk = Product::count();
        $total_nilai = Product::sum(DB::raw('stock * price'));
        $total_low_stock = Product::whereColumn('stock', '<=', 'minimum_stock')->count();

        $total_in = StockMovement::where('type', 'IN')->sum('quantity');
        $total_out = StockMovement::where('type', 'OUT')->sum('quantity');

        $low_stock_products = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->get();

        $recent_movements = StockMovement::with(['product', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'total_produk',
            'total_nilai',
            'total_low_stock',
            'total_in',
            'total_out',
            'low_stock_products',
            'recent_movements'
        ));
    }
}
