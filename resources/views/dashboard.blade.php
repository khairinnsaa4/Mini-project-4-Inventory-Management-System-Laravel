@extends('layouts.app')

@section('title', Auth::user()->role === 'admin' ? 'Executive Dashboard' : 'Dashboard Kasir')

@section('content')
<!-- Header Atas Dashboard -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 font-serif text-dark">
            {{ Auth::user()->role === 'admin' ? 'Executive Atelier Dashboard' : 'Dashboard Kasir & Operasional' }}
        </h3>
        <p class="text-muted small mb-0">
            {{ Auth::user()->role === 'admin'
                ? 'Pemantauan inventaris, valuasi butik, dan analitik mutasi stok secara real-time.' 
                : 'Pusat kasir penjualan VIP, cek ketersediaan stok heels, dan pencatatan restock harian.' }}
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">
        @if(Auth::user()->role === 'admin')
            <!-- Tombol Khusus Admin: Auto-Sales Simulation Bot & Tambah Koleksi -->
            <form method="POST" action="{{ route('stock.autoSale') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1 shadow-sm px-3" title="Simulasi transaksi penjualan VIP otomatis">
                    <i class="bi bi-cpu-fill"></i>
                    <span>Simulasi Terjual Otomatis</span>
                </button>
            </form>
            <a href="{{ route('products.create') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 shadow-sm px-3">
                <i class="bi bi-plus-lg"></i> Tambah Koleksi
            </a>
            <a href="{{ route('stock.in') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 shadow-sm px-3">
                <i class="bi bi-box-arrow-in-down"></i> Restock Butik
            </a>
        @else
            <!-- Tombol Khusus Staff: Akses Kasir Penjualan & Restock -->
            <a href="{{ route('stock.out') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 shadow-sm px-3">
                <i class="bi bi-bag-check"></i> Kasir Penjualan
            </a>
            <a href="{{ route('stock.in') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1 shadow-sm px-3">
                <i class="bi bi-box-arrow-in-down"></i> Restock Butik
            </a>
        @endif
    </div>
</div>

<!-- 4 KARTU METRIK UTAMA (DIPERSONALISASI SESUAI ROLE) -->
<div class="row g-3 mb-4">
    @if(Auth::user()->role === 'admin')
        <!-- 1. Total Koleksi (Admin) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.6px;">Koleksi Heels</span>
                        <h3 class="fw-bold my-1 font-serif text-dark">{{ number_format($total_produk) }}</h3>
                        <span class="badge bg-light text-dark border rounded-pill small">{{ number_format($total_unit_ready) }} Pasang Ready</span>
                    </div>
                    <div class="stat-card-icon" style="background-color: #FDF2F4; color: var(--rouge-primary);">
                        <i class="bi bi-handbag"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Valuasi Inventaris Butik (Admin Only) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.6px;">Valuasi Butik</span>
                        <h4 class="fw-bold my-1 font-serif text-dark" style="font-size: 1.25rem;">Rp {{ number_format($total_nilai, 0, ',', '.') }}</h4>
                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill">Total Aset Stok</span>
                    </div>
                    <div class="stat-card-icon" style="background-color: #FAF4E8; color: #8C6D2B;">
                        <i class="bi bi-gem"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Perputaran Masuk & Terjual (Admin) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.6px;">Perputaran Stok</span>
                        <h3 class="fw-bold my-1 font-serif text-dark">
                            <span class="text-success">+{{ $total_in }}</span> 
                            <span class="text-muted fs-6">/</span> 
                            <span class="text-danger">-{{ $total_out }}</span>
                        </h3>
                        <span class="text-muted small">Unit (IN / OUT)</span>
                    </div>
                    <div class="stat-card-icon" style="background-color: #F0FDF4; color: #16A34A;">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Alert Stok Kritis (Admin) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.6px;">Alert Stok Kritis</span>
                        <h3 class="fw-bold my-1 font-serif {{ ($total_low_stock > 0) ? 'text-danger' : 'text-dark' }}">
                            {{ number_format($total_low_stock) }}
                        </h3>
                        <span class="badge {{ ($total_low_stock > 0) ? 'bg-danger text-white' : 'bg-success text-white' }} rounded-pill">
                            {{ ($total_low_stock > 0) ? 'Perlu Re-order' : 'Stok Aman' }}
                        </span>
                    </div>
                    <div class="stat-card-icon" style="background-color: {{ ($total_low_stock > 0) ? '#FEF2F2' : '#F0FDF4' }}; color: {{ ($total_low_stock > 0) ? '#DC2626' : '#16A34A' }};">
                        <i class="bi bi-bell"></i>
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- METRIK KHUSUS STAFF (OPERASIONAL KASIR) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.6px;">Koleksi Terdaftar</span>
                        <h3 class="fw-bold my-1 font-serif text-dark">{{ number_format($total_produk) }}</h3>
                        <span class="badge bg-light text-dark border rounded-pill">Model Heels Aktif</span>
                    </div>
                    <div class="stat-card-icon" style="background-color: #FDF2F4; color: var(--rouge-primary);">
                        <i class="bi bi-handbag"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.6px;">Total Siap Jual</span>
                        <h3 class="fw-bold my-1 font-serif text-dark">{{ number_format($total_unit_ready) }} <span class="fs-6 fw-normal text-muted">psg</span></h3>
                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Stok Ready Butik</span>
                    </div>
                    <div class="stat-card-icon" style="background-color: #F0FDF4; color: #16A34A;">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.6px;">Transaksi Hari Ini</span>
                        <h3 class="fw-bold my-1 font-serif text-dark">{{ $my_tx_today }} <span class="fs-6 fw-normal text-muted">({{ $my_units_today }} unit)</span></h3>
                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-pill">Aktivitas Saya</span>
                    </div>
                    <div class="stat-card-icon" style="background-color: #EFF6FF; color: #2563EB;">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.6px;">Alert Stok Menipis</span>
                        <h3 class="fw-bold my-1 font-serif {{ ($total_low_stock > 0) ? 'text-danger' : 'text-dark' }}">
                            {{ number_format($total_low_stock) }}
                        </h3>
                        <span class="badge {{ ($total_low_stock > 0) ? 'bg-danger text-white' : 'bg-success text-white' }} rounded-pill">
                            {{ ($total_low_stock > 0) ? 'Lapor Restock' : 'Semua Cukup' }}
                        </span>
                    </div>
                    <div class="stat-card-icon" style="background-color: {{ ($total_low_stock > 0) ? '#FEF2F2' : '#F0FDF4' }}; color: {{ ($total_low_stock > 0) ? '#DC2626' : '#16A34A' }};">
                        <i class="bi bi-bell"></i>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@if(Auth::user()->role === 'admin')
    <!-- BAGIAN GRAFIK ANALITIK INTERAKTIF (KHUSUS ADMIN) -->
    <div class="row g-4 mb-4">
        <!-- Grafik 1: Tren Mutasi & Penjualan 7 Hari Terakhir -->
        <div class="col-12 col-lg-8">
            <div class="card p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold mb-0 font-serif">Aktivitas Perputaran Heels (7 Hari Terakhir)</h6>
                        <small class="text-muted">Perbandingan unit Restock Masuk (IN) vs Unit Terjual (OUT)</small>
                    </div>
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-graph-up me-1"></i> Real-time</span>
                </div>
                <div style="height: 270px; position: relative;">
                    <canvas id="salesMovementChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Grafik 2: Komposisi Koleksi Kategori Heels -->
        <div class="col-12 col-lg-4">
            <div class="card p-3 h-100">
                <div class="mb-3">
                    <h6 class="fw-bold mb-0 font-serif">Distribusi Siluet Heels</h6>
                    <small class="text-muted">Porsi persediaan stok per kategori</small>
                </div>
                <div style="height: 230px; position: relative;">
                    <canvas id="categoryDoughnutChart"></canvas>
                </div>
                <div class="text-center mt-2">
                    <span class="text-muted small" style="font-size: 0.72rem;"><i class="bi bi-info-circle me-1"></i> Terhubung langsung ke database</span>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- 2 KOLOM BAWAH: DAFTAR PERLU RE-ORDER & AKTIVITAS BUKU BESAR -->
<div class="row g-4">
    <!-- Peringatan Stok Menipis -->
    <div class="col-12 col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="font-serif fw-bold"><i class="bi bi-exclamation-circle text-danger me-2"></i>Koleksi Perlu Re-order</span>
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                    {{ $low_stock_products->count() }} Model
                </span>
            </div>
            <div class="card-body p-0">
                @if($low_stock_products->isEmpty())
                    <div class="text-center py-5 text-muted small">
                        <i class="bi bi-shield-check text-success fs-2 d-block mb-2"></i>
                        Semua persediaan heels dalam kondisi stok aman.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Model Heels</th>
                                    <th class="text-center">Sisa</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($low_stock_products as $p)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $p->name }}</div>
                                            <div class="text-muted small font-monospace" style="font-size: 0.72rem;">{{ $p->sku }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-danger rounded-pill px-2">{{ $p->stock }} psg</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('stock.in', ['product_id' => $p->id]) }}" class="btn btn-outline-primary btn-sm py-1 px-2" style="font-size: 0.75rem;">
                                                <i class="bi bi-plus-lg me-1"></i>Restock
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Aktivitas Buku Besar Mutasi Terkini -->
    <div class="col-12 col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="font-serif fw-bold"><i class="bi bi-journal-bookmark text-secondary me-2"></i>Riwayat Transaksi Terakhir</span>
                <a href="{{ route('stock.history') }}" class="small text-decoration-none fw-semibold" style="color: var(--rouge-primary);">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @if($recent_movements->isEmpty())
                    <div class="text-center py-5 text-muted small">Belum ada catatan transaksi heels.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-custom mb-0">
                            <thead>
                                <tr>
                                    <th>Tipe</th>
                                    <th>Model & SKU</th>
                                    <th class="text-center">Jumlah</th>
                                    <th>Catatan / Faktur</th>
                                    <th class="text-end">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_movements as $m)
                                    <tr>
                                        <td>
                                            @if($m->type === 'IN')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                    <i class="bi bi-arrow-down-left"></i> Restock
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                    <i class="bi bi-bag-check"></i> Terjual
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $m->product->name ?? 'Produk Dihapus' }}</div>
                                            <div class="text-muted font-monospace" style="font-size: 0.72rem;">{{ $m->product->sku ?? '-' }}</div>
                                        </td>
                                        <td class="text-center fw-bold {{ ($m->type === 'IN') ? 'text-success' : 'text-danger' }}">
                                            {{ ($m->type === 'IN' ? '+' : '-') . $m->quantity }} psg
                                        </td>
                                        <td>
                                            <small class="text-muted d-block text-truncate" style="max-width: 220px;" title="{{ $m->notes }}">
                                                {{ $m->notes }}
                                            </small>
                                        </td>
                                        <td class="text-end text-muted small" style="font-size: 0.75rem;">
                                            {{ $m->created_at->format('d M H:i') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(Auth::user()->role === 'admin')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Line Chart: Tren Mutasi (Restock IN vs Terjual OUT)
    const ctxSales = document.getElementById('salesMovementChart').getContext('2d');
    
    const gradSales = ctxSales.createLinearGradient(0, 0, 0, 240);
    gradSales.addColorStop(0, 'rgba(139, 21, 56, 0.2)');
    gradSales.addColorStop(1, 'rgba(139, 21, 56, 0.0)');

    const gradRestock = ctxSales.createLinearGradient(0, 0, 0, 240);
    gradRestock.addColorStop(0, 'rgba(197, 160, 89, 0.2)');
    gradRestock.addColorStop(1, 'rgba(197, 160, 89, 0.0)');

    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartDates) !!},
            datasets: [
                {
                    label: 'Unit Terjual (OUT)',
                    data: {!! json_encode($chartSales) !!},
                    borderColor: '#8B1538',
                    backgroundColor: gradSales,
                    borderWidth: 2.5,
                    tension: 0.35,
                    fill: true,
                    pointBackgroundColor: '#8B1538',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Restock Masuk (IN)',
                    data: {!! json_encode($chartRestock) !!},
                    borderColor: '#C5A059',
                    backgroundColor: gradRestock,
                    borderWidth: 2,
                    tension: 0.35,
                    fill: true,
                    pointBackgroundColor: '#C5A059',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        font: { family: "'Plus Jakarta Sans', sans-serif", size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' pasang';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 2,
                        font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 }
                    },
                    grid: { color: '#F3EDE8' }
                },
                x: {
                    ticks: {
                        font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 }
                    },
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Doughnut Chart: Distribusi Siluet Heels
    const ctxCat = document.getElementById('categoryDoughnutChart').getContext('2d');
    new Chart(ctxCat, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($catLabels) !!},
            datasets: [{
                data: {!! json_encode($catStocks) !!},
                backgroundColor: [
                    '#8B1538',
                    '#C5A059',
                    '#27272A',
                    '#A84B66',
                    '#E5C58A'
                ],
                borderWidth: 2,
                borderColor: '#FFFFFF'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 10,
                        font: { family: "'Plus Jakarta Sans', sans-serif", size: 10 }
                    }
                }
            },
            cutout: '70%'
        }
    });
});
</script>
@endif
@endpush
