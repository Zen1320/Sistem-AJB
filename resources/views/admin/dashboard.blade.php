@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4 fw-bold text-primary">Dashboard E-AJB</h1>
        <div class="d-flex">
            <div class="dropdown me-2">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-calendar-alt me-1"></i> Periode: Bulan Ini
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" href="#">Hari Ini</a></li>
                    <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                    <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                    <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Custom Range</a></li>
                </ul>
            </div>
            <button class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Buat AJB Baru
            </button>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 fw-normal">Total Transaksi</h6>
                            <h3 class="mb-0 fw-bold">1,248</h3>
                        </div>
                        <div class="bg-white-10 p-3 rounded">
                            <i class="fas fa-file-contract fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-primary-dark">
                    <a class="small text-white stretched-link" href="#">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 fw-normal">Selesai</h6>
                            <h3 class="mb-0 fw-bold">982</h3>
                        </div>
                        <div class="bg-white-10 p-3 rounded">
                            <i class="fas fa-check-circle fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-success-dark">
                    <a class="small text-white stretched-link" href="#">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 fw-normal">Dalam Proses</h6>
                            <h3 class="mb-0 fw-bold">156</h3>
                        </div>
                        <div class="bg-white-10 p-3 rounded">
                            <i class="fas fa-spinner fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-warning-dark">
                    <a class="small text-white stretched-link" href="#">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 fw-normal">Ditolak</h6>
                            <h3 class="mb-0 fw-bold">110</h3>
                        </div>
                        <div class="bg-white-10 p-3 rounded">
                            <i class="fas fa-times-circle fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-danger-dark">
                    <a class="small text-white stretched-link" href="#">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik dan Aktivitas Terkini -->
    <div class="row">
        <!-- Grafik Transaksi -->
        <div class="col-xl-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Statistik Transaksi E-AJB</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="chartDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Tahun 2023
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="chartDropdown">
                            <li><a class="dropdown-item" href="#">2023</a></li>
                            <li><a class="dropdown-item" href="#">2022</a></li>
                            <li><a class="dropdown-item" href="#">2021</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="transactionChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terkini -->
        <div class="col-xl-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Aktivitas Terkini</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">AJB-2023-01128</h6>
                                <small class="text-success">Selesai</small>
                            </div>
                            <p class="mb-1">Jl. Merdeka No. 45, Jakarta Pusat</p>
                            <small class="text-muted">Diselesaikan 2 jam lalu</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">AJB-2023-01127</h6>
                                <small class="text-warning">Proses Notaris</small>
                            </div>
                            <p class="mb-1">Perumahan Taman Asri Blok B5</p>
                            <small class="text-muted">Diperbarui 5 jam lalu</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">AJB-2023-01126</h6>
                                <small class="text-danger">Perlu Revisi</small>
                            </div>
                            <p class="mb-1">Apartemen Green Park Tower Lt. 12</p>
                            <small class="text-muted">Ditinjau kemarin</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">AJB-2023-01125</h6>
                                <small class="text-primary">Verifikasi</small>
                            </div>
                            <p class="mb-1">Ruko Niaga Blok A No. 7</p>
                            <small class="text-muted">Dikirim 2 hari lalu</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action border-bottom-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">AJB-2023-01124</h6>
                                <small class="text-success">Selesai</small>
                            </div>
                            <p class="mb-1">Tanah Kavling Pondok Indah</p>
                            <small class="text-muted">Diselesaikan 3 hari lalu</small>
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua Aktivitas</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Transaksi Terbaru -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Transaksi Terbaru</h5>
            <div>
                <button class="btn btn-sm btn-outline-secondary me-2">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-download me-1"></i> Export
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. AJB</th>
                            <th>Tanggal</th>
                            <th>Pembeli</th>
                            <th>Penjual</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>AJB-2023-01128</td>
                            <td>15 Nov 2023</td>
                            <td>Budi Santoso</td>
                            <td>PT Properti Maju</td>
                            <td>Jakarta Pusat</td>
                            <td><span class="badge bg-success">Selesai</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>AJB-2023-01127</td>
                            <td>14 Nov 2023</td>
                            <td>Ani Wijaya</td>
                            <td>Dian Permata</td>
                            <td>Bekasi</td>
                            <td><span class="badge bg-warning text-dark">Proses</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>AJB-2023-01126</td>
                            <td>13 Nov 2023</td>
                            <td>PT Sejahtera</td>
                            <td>CV Bangun Jaya</td>
                            <td>Tangerang</td>
                            <td><span class="badge bg-danger">Revisi</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>AJB-2023-01125</td>
                            <td>12 Nov 2023</td>
                            <td>Rina Amelia</td>
                            <td>PT Tanah Makmur</td>
                            <td>Depok</td>
                            <td><span class="badge bg-primary">Verifikasi</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>AJB-2023-01124</td>
                            <td>10 Nov 2023</td>
                            <td>David Lim</td>
                            <td>Hendra Kurniawan</td>
                            <td>Jakarta Selatan</td>
                            <td><span class="badge bg-success">Selesai</span></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end mt-3">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Inisialisasi Grafik Transaksi
    const ctx = document.getElementById('transactionChart').getContext('2d');
    const transactionChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Transaksi Selesai',
                data: [85, 92, 78, 105, 120, 98, 115, 132, 110, 145, 125, 160],
                backgroundColor: 'rgba(37, 99, 235, 0.7)',
                borderColor: 'rgba(37, 99, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Transaksi Proses',
                data: [15, 18, 22, 25, 30, 32, 25, 28, 40, 35, 30, 25],
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1
            }]
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
