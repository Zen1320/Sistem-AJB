@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4 fw-bold text-primary">Dashboard E-AJB</h1>

    </div>

    <!-- Statistik Utama -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 fw-normal">Total Transaksi</h6>
                            <h3 class="mb-0 fw-bold">{{$totalTransaksi}}</h3>
                        </div>
                        <div class="bg-white-10 p-3 rounded">
                            <i class="fas fa-file-contract fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 fw-normal">Selesai</h6>
                            <h3 class="mb-0 fw-bold">{{$selesai}}</h3>
                        </div>
                        <div class="bg-white-10 p-3 rounded">
                            <i class="fas fa-check-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 fw-normal">Dalam Proses</h6>
                            <h3 class="mb-0 fw-bold">{{$dalamProses}}</h3>
                        </div>
                        <div class="bg-white-10 p-3 rounded">
                            <i class="fas fa-spinner fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 fw-normal">Di Revisi</h6>
                            <h3 class="mb-0 fw-bold">{{$diRevisi}}</h3>
                        </div>
                        <div class="bg-white-10 p-3 rounded">
                            <i class="fas fa-times-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Statistik Pengajuan E-AJB</h5>
                </div>
                <div class="card-body">
                    <canvas id="transactionChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Aktivitas Terkini</h5>
                </div>
                <div class="card-body p-0" style="max-height: 370px; overflow-y: auto;">
                    <div class="list-group list-group-flush">
                        @foreach ($aktivitas->take(6) as $item)
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $item['kode'] }}</h6>
                                    <span class="badge {{ $item['status_class'] }}">{{ $item['status_text'] }}</span>
                                </div>
                                <p class="mb-1 text-truncate">{{ $item['alamat'] }}</p>
                                <small class="text-muted">{{ $item['waktu'] }}</small>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Daftar Transaksi Terbaru -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">📝 Daftar Pengajuan Terbaru</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive table-hover">
                <table class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>No. AJB</th>
                            <th>Tanggal</th>
                            <th>Pembeli</th>
                            <th>Penjual</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data_pengajuan as $item)
                            <tr>
                                <td class="fw-semibold">{{ $item->kode_pengajuan }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->pembeli->nama_pembeli ?? '-' }}</td>
                                <td>{{ $item->penjual->nama_penjual ?? '-' }}</td>
                                <td>{{ $item->objekTanah->alamat_lengkap ?? '-' }}</td>
                                <td>{!! status_badge($item->status) !!}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada pengajuan terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('transactionChart').getContext('2d');
    const transactionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [
                {
                    label: 'Pengajuan Selesai',
                    data: @json($dataSelesai),
                    backgroundColor: 'rgba(37, 99, 235, 0.7)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pengajuan Proses',
                    data: @json($dataProses),
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 50
                    }
                }
            }
        }
    });
</script>

@endsection

@push('styles')
<style>
    .text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.badge.text-primary { background-color: #cfe2ff; color: #084298; }
.badge.text-danger { background-color: #f8d7da; color: #842029; }
.badge.text-warning { background-color: #fff3cd; color: #664d03; }
.badge.text-success { background-color: #d1e7dd; color: #0f5132; }
.badge.text-info { background-color: #cff4fc; color: #055160; }
.badge.text-secondary { background-color: #e2e3e5; color: #41464b; }
.badge.text-muted { background-color: #f8f9fa; color: #6c757d; }
</style>
@endpush
