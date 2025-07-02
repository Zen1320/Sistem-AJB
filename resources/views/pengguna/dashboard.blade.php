@extends('layouts.app')
@section('title','Dashboard')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Dashboard User -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mt-4 fw-bold text-primary"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
            <p class="text-muted mb-0">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        <a href="{{route('pengguna.AJB.store')}}" class="btn btn-primary shadow-sm">
            <i class="fas fa-file-signature me-2"></i>Ajukan AJB Baru
        </a>
    </div>

    <!-- Ringkasan AJB - Lebih Menarik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-primary bg-opacity-10 position-relative overflow-hidden">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-wrapper bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-file-alt fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Total AJB Diajukan</p>
                        <h3 class="text-primary fw-bold mb-0">24</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-success bg-opacity-10 position-relative overflow-hidden">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-wrapper bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1">AJB Selesai</p>
                        <h3 class="text-success fw-bold mb-0">18</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 bg-warning bg-opacity-10 position-relative overflow-hidden">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="icon-wrapper bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fas fa-spinner fa-lg fa-spin"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Dalam Proses</p>
                        <h3 class="text-warning fw-bold mb-0">6</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- AJB Terbaru -->
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0"><i class="fas fa-clock me-2"></i>AJB Terbaru Anda</h5>

        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No. AJB</th>
                        <th>Jenis Transaksi</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>AJB-2023-01128</td>
                        <td>Jual Beli Rumah</td>
                        <td>15 Nov 2023</td>
                        <td><span class="badge bg-success">Selesai</span></td>

                    </tr>
                    <tr>
                        <td>AJB-2023-01127</td>
                        <td>Jual Beli Tanah</td>
                        <td>14 Nov 2023</td>

                        <td><span class="badge bg-warning text-dark">Proses Notaris</span></td>

                    </tr>
                    <tr>
                        <td>AJB-2023-01126</td>
                        <td>Jual Beli Ruko</td>
                        <td>13 Nov 2023</td>

                        <td><span class="badge bg-danger">Perlu Revisi</span></td>

                    </tr>
                    <tr>
                        <td>AJB-2023-01125</td>
                        <td>Jual Beli Apartemen</td>
                        <td>12 Nov 2023</td>

                        <td><span class="badge bg-primary">Menunggu Verifikasi</span></td>

                    </tr>
                </tbody>
            </table>
            <div class="mt-2">
                <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
            </div>

        </div>
    </div>

    <!-- Proses & Panduan -->
    <div class="row">
        <!-- Proses Berjalan -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="fw-bold mb-0"><i class="fas fa-tasks me-2"></i>Proses AJB Berjalan</h5>
                </div>
                <div class="card-body">
                    <!-- Proses Item -->
                    @php
                        $proses = [
                            ['id' => '01127', 'jenis' => 'Jual Beli Tanah', 'status' => 'Proses Notaris', 'color' => 'warning', 'progress' => 65, 'update' => '2 hari lalu'],
                            ['id' => '01125', 'jenis' => 'Jual Beli Apartemen', 'status' => 'Menunggu Verifikasi', 'color' => 'primary', 'progress' => 30, 'update' => '5 hari lalu'],
                            ['id' => '01126', 'jenis' => 'Jual Beli Ruko', 'status' => 'Perlu Revisi', 'color' => 'danger', 'progress' => 45, 'update' => 'Dokumen tanah kurang'],
                        ];
                    @endphp

                    @foreach ($proses as $item)
                    <div class="mb-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 p-3 bg-{{ $item['color'] }} bg-opacity-10 rounded-circle me-3">
                                <i class="fas fa-file-alt fs-4 text-{{ $item['color'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">AJB-2023-{{ $item['id'] }}</h6>
                                <p class="text-muted mb-1">{{ $item['jenis'] }} - {{ $item['status'] }}</p>

                                <small class="text-muted">
                                    {{ is_numeric($item['update']) ? 'Diperbarui: '.$item['update'] : 'Pesan: '.$item['update'] }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-footer text-center bg-white">
                    <a href="#" class="btn btn-outline-primary btn-sm">Lihat Semua Proses</a>
                </div>
            </div>
        </div>

        <!-- Panduan Cepat -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="fw-bold mb-0"><i class="fas fa-lightbulb me-2"></i>Panduan Cepat</h5>
                </div>
                {{-- <div class="card-body">
                    <div class="list-group list-group-flush">
                        @php
                            $panduan = [
                                ['icon' => 'plus-circle', 'title' => 'Cara Mengajukan AJB Baru', 'desc' => 'Panduan langkah demi langkah', 'color' => 'primary'],
                                ['icon' => 'file-download', 'title' => 'Download Dokumen Contoh', 'desc' => 'Template dokumen yang diperlukan', 'color' => 'success'],
                                ['icon' => 'question-circle', 'title' => 'Pertanyaan Umum (FAQ)', 'desc' => 'Temukan jawaban atas pertanyaan Anda', 'color' => 'warning'],
                                ['icon' => 'headset', 'title' => 'Hubungi Dukungan', 'desc' => 'Butuh bantuan lebih lanjut?', 'color' => 'info'],
                            ];
                        @endphp

                        @foreach ($panduan as $item)
                        <a href="#" class="list-group-item list-group-item-action border-0 py-3">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-{{ $item['color'] }} bg-opacity-10 rounded me-3">
                                    <i class="fas fa-{{ $item['icon'] }} text-{{ $item['color'] }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $item['title'] }}</h6>
                                    <small class="text-muted">{{ $item['desc'] }}</small>
                                </div>
                                <i class="fas fa-chevron-right text-muted"></i>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div> --}}
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action border-0 py-3 rounded d-flex align-items-center mb-1 shadow-sm hover-shadow transition" data-bs-toggle="modal" data-bs-target="#modalAjukanAJB">
                            <div class="p-3 bg-primary bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-plus-circle text-primary fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold">Cara Mengajukan AJB Baru</h6>
                                <small class="text-muted">Panduan langkah demi langkah</small>
                            </div>
                            <i class="fas fa-chevron-right text-muted ms-2"></i>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action border-0 py-3 rounded d-flex align-items-center mb-1 shadow-sm hover-shadow transition" data-bs-toggle="modal" data-bs-target="#modalDownloadDokumen">
                            <div class="p-3 bg-success bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-file-download text-success fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold">Download Dokumen Contoh</h6>
                                <small class="text-muted">Template dokumen yang diperlukan</small>
                            </div>
                            <i class="fas fa-chevron-right text-muted ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal --}}
<!-- Modal Cara Pengajuan AJB -->
<div class="modal fade" id="modalAjukanAJB" tabindex="-1" aria-labelledby="caraAjbModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header bg-info text-white rounded-top-4">
        <h5 class="modal-title" id="caraAjbModalLabel"><i class="fas fa-question-circle me-2"></i>Cara Pengajuan AJB</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4 py-3">
        <ol class="list-group list-group-numbered list-group-flush">
          <li class="list-group-item">
            <strong>Login ke Akun Anda</strong><br>
            Masuk menggunakan email dan password yang telah didaftarkan.
          </li>
          <li class="list-group-item">
            <strong>Buka Menu "Pembuatan AJB"</strong><br>
            Navigasi ke menu <em>“Pembuatan AJB”</em> di sidebar/dashboard.
          </li>
          <li class="list-group-item">
            <strong>Isi Formulir Pengajuan</strong><br>
            Lengkapi data penjual, pembeli, dan objek tanah atau bangunan.
          </li>
          <li class="list-group-item">
            <strong>Unggah Dokumen Pendukung</strong><br>
            Upload KTP, Sertifikat Tanah, dan dokumen lain yang diminta.
          </li>
          <li class="list-group-item">
            <strong>Ajukan Pengajuan</strong><br>
            Klik tombol <code>Ajukan</code> untuk mengirim data ke notaris.
          </li>
          <li class="list-group-item">
            <strong>Tunggu Verifikasi</strong><br>
            Tim notaris akan memverifikasi dan menghubungi jika ada koreksi.
          </li>
          <li class="list-group-item">
            <strong>AJB Diproses</strong><br>
            Setelah verifikasi, proses pembuatan AJB dimulai dan bisa dilacak melalui dashboard.
          </li>
        </ol>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>



@endsection
