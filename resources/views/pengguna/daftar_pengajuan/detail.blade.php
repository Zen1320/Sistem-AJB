@extends('layouts.app')

@section('title', 'Detail Transaksi AJB')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0" >
                            <i class="fas fa-file-contract me-2"></i>Detail Transaksi AJB
                        </h3>
                        <div>
                            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-info-circle me-2"></i>Informasi Umum Transaksi
                        </h5>
                         <span>
                            <span class="text-primary">Status: </span>
                            {!!status_badge($pengajuan->status)!!}
                        </span>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-body border-0 shadow-sm mb-3">
                                <h6 class="text-muted mb-3"><i class="fas fa-calendar-alt me-2"></i>Tanggal Pengajuan</h6>
                                <p class="mb-0">{{ \Carbon\Carbon::parse($pengajuan->created_at)->translatedFormat('d F Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-body border-0 shadow-sm mb-3">
                                <h6 class="text-muted mb-3"><i class="fas fa-tag me-2"></i>Kode AJB </h6>
                                <p class="mb-0">{{ $pengajuan->kode_pengajuan }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-body border-0 shadow-sm mb-3">
                                <h6 class="text-muted mb-3"><i class="fas fa-money-bill-wave me-2"></i>Nilai Transaksi</h6>
                                <p class="mb-0">Rp {{ number_format($pengajuan->harga_transaksi_tanah, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-center">
                        <div class="nav nav-pills" id="transactionTabs" role="tablist">
                            <button class="nav-link active me-3" id="info-tab" data-bs-toggle="pill" data-bs-target="#info" type="button">
                                <i class="fas fa-user-circle me-1"></i> Informasi Pengguna
                            </button>
                            <button class="nav-link me-3" id="property-tab" data-bs-toggle="pill" data-bs-target="#property" type="button">
                                <i class="fas fa-map-marked-alt me-1"></i> Objek Tanah
                            </button>
                            <button class="nav-link" id="documents-tab" data-bs-toggle="pill" data-bs-target="#documents" type="button">
                                <i class="fas fa-file-alt me-1"></i> Berkas Dokumen
                                <span class="badge bg-primary ms-1">{{ count(array_filter((array)$pengajuan->berkas)) }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="transactionTabsContent">
        <!-- User Information Tab -->
        <div class="tab-pane fade show active" id="info" role="tabpanel">
            <div class="row">
                <!-- Seller Information -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0 ">
                                <i class="fas fa-user-tie me-2"></i>Informasi Penjual
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar avatar-xl bg-light-primary rounded-circle me-3">
                                    <i class="fas fa-user-tie fa-lg text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $pengajuan->penjual->nama_penjual }}</h5>
                                    <p class="text-muted mb-0">NIK: {{ $pengajuan->penjual->nik_penjual }}</p>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <th width="40%" class="text-muted">Tempat/Tgl Lahir</th>
                                            <td>{{ $pengajuan->penjual->tempat_lahir_penjual }}, {{ \Carbon\Carbon::parse($pengajuan->penjual->tgl_lahir_penjual)->translatedFormat('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Alamat</th>
                                            <td>{{ $pengajuan->penjual->alamat_penjual }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">No. Telepon</th>
                                            <td>{{ $pengajuan->penjual->no_telepon_penjual ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            @if($pengajuan->penjual->nama_istri_penjual)
                            <div class="border-top pt-3 mt-3">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-female me-2"></i>Informasi Istri Penjual
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm">
                                        <tbody>
                                            <tr>
                                                <th width="40%" class="text-muted">Nama Istri</th>
                                                <td>{{ $pengajuan->penjual->nama_istri_penjual }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">NIK Istri</th>
                                                <td>{{ $pengajuan->penjual->nik_istri_penjual }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Nomor Istri Penjual</th>
                                                <td>{{ $pengajuan->penjual->no_telepon_istri_penjual ?? '-'}}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Tempat/Tgl Lahir</th>
                                                <td>{{ $pengajuan->penjual->tempat_lahir_istri_penjual ?? '-'}}, {{ \Carbon\Carbon::parse($pengajuan->penjual->tgl_lahir_istri_penjual)->translatedFormat('d F Y') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Buyer Information -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>Informasi Pembeli
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4">
                                <div class="avatar avatar-xl bg-light-success rounded-circle me-3">
                                    <i class="fas fa-user fa-lg text-success"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">{{ $pengajuan->pembeli->nama_pembeli }}</h5>
                                    <p class="text-muted mb-0">NIK: {{ $pengajuan->pembeli->nik_pembeli }}</p>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <th width="40%" class="text-muted">Tempat/Tgl Lahir</th>
                                            <td>{{ $pengajuan->pembeli->tempat_lahir_pembeli }}, {{ \Carbon\Carbon::parse($pengajuan->pembeli->tgl_lahir_pembeli)->translatedFormat('d F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Alamat</th>
                                            <td>{{ $pengajuan->pembeli->alamat_pembeli }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">No. Telepon</th>
                                            <td>{{ $pengajuan->pembeli->no_telepon_pembeli ?? '-' }}</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      <div class="tab-pane fade" id="property" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-map-marked-alt me-2"></i>Informasi Objek Tanah
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Legal Information Card -->
                                <div class="col-md-6">
                                    <div class="card card-body border-0 shadow-sm mb-4">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-file-signature me-2"></i>Informasi Legal
                                        </h6>
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-sm">
                                                <tbody>
                                                    <tr>
                                                        <th width="45%" class="text-muted">Jenis Pengajuan</th>
                                                        <td>{{ $pengajuan->jenis->nama_jenis }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">No. Hak Bangun</th>
                                                        <td>{{ $pengajuan->objekTanah->nomor_hak_bangun }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">No. Surat Ukur</th>
                                                        <td>{{ $pengajuan->objekTanah->nomor_surat_ukur }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">No. NIB</th>
                                                        <td>{{ $pengajuan->objekTanah->nomor_nib }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">Pengesahan NIB</th>
                                                        <td>{{ $pengajuan->objekTanah->pengesahan_nib_oleh }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">No. SPP</th>
                                                        <td>{{ $pengajuan->objekTanah->nomor_spp }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location Information Card -->
                                <div class="col-md-6">
                                    <div class="card card-body border-0 shadow-sm mb-4">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-map-marker-alt me-2"></i>Lokasi Properti
                                        </h6>
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-sm">
                                                <tbody>
                                                    <tr>
                                                        <th width="45%" class="text-muted">Alamat Lengkap</th>
                                                        <td>{{ $pengajuan->objekTanah->alamat_lengkap }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">Jalan</th>
                                                        <td>{{ $pengajuan->objekTanah->jalan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">Kelurahan</th>
                                                        <td>{{ $pengajuan->objekTanah->kelurahan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">Kecamatan</th>
                                                        <td>{{ $pengajuan->objekTanah->kecamatan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">Kota/Kabupaten</th>
                                                        <td>{{ $pengajuan->objekTanah->kota }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-muted">Provinsi</th>
                                                        <td>{{ $pengajuan->objekTanah->provinsi }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Tab -->
        <div class="tab-pane fade" id="documents" role="tabpanel">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-folder-open me-2"></i>Berkas Pendukung
                                </h5>
                                <div>
                                    @if (auth()->user()->role == 0 || auth()->user()->role == 1)
                                    <a href="{{ route('pengajuan.zip', ['id' => $pengajuan->id]) }}"
                                                    class="btn btn-primary">
                                        <i class="fas fa-file-archive me-1"></i> Download Semua (ZIP)
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>Berikut adalah dokumen-dokumen yang telah diunggah untuk transaksi ini.
                            </div>

                            <div class="row">
                                @php
                                    $files = [
                                        'file_ktp_penjual' => ['label' => 'KTP Penjual', 'icon' => 'fa-id-card'],
                                        'file_ktp_istri_penjual' => ['label' => 'KTP Istri Penjual', 'icon' => 'fa-id-card'],
                                        'file_akta_nikah' => ['label' => 'Akta Nikah', 'icon' => 'fa-heart'],
                                        'file_kk_penjual' => ['label' => 'KK Penjual', 'icon' => 'fa-users'],
                                        'file_ktp_pembeli' => ['label' => 'KTP Pembeli', 'icon' => 'fa-id-card'],
                                        'file_kk_pembeli' => ['label' => 'KK Pembeli', 'icon' => 'fa-users'],
                                        'file_sertifikat' => ['label' => 'Sertifikat Tanah', 'icon' => 'fa-file-contract'],
                                        'file_bukti_pbb' => ['label' => 'Bukti PBB', 'icon' => 'fa-receipt'],
                                        'file_imb' => ['label' => 'IMB', 'icon' => 'fa-building'],
                                        'file_persetujuan' => ['label' => 'Surat Persetujuan', 'icon' => 'fa-file-signature'],
                                        'file_dokumen_lainnya' => ['label' => 'Dokumen Lainnya', 'icon' => 'fa-file-alt'],
                                    ];
                                @endphp

                                @foreach ($files as $field => $fileInfo)
                                    @php $file = $pengajuan->berkas->$field ?? null; @endphp
                                    @if ($file)
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-0 shadow-sm h-100">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-start">
                                                        <div class="avatar avatar-lg bg-light-primary rounded-circle me-3 flex-shrink-0">
                                                            <i class="fas {{ $fileInfo['icon'] }} text-primary"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="card-title mb-1">{{ $fileInfo['label'] }}</h6>
                                                            <p class="text-muted small mb-2">{{ basename($file) }}</p>
                                                            <div class="btn-group btn-group-sm">
                                                                @if (auth()->user()->role == 0 || auth()->user()->role == 1)
                                                                <a href="{{ route('pengajuan.download', ['id' => $pengajuan->id, 'file' => $field]) }}"
                                                                        class="btn btn-outline-primary" title="Download">
                                                                    </i> Unduh
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            @if(count(array_filter((array)$pengajuan->berkas)) === 0)
                                <div class="text-center py-5">
                                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada dokumen yang diunggah</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script> --}}
{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const downloadAllBtn = document.getElementById('downloadAllBtn');

    if (!downloadAllBtn) return;

    downloadAllBtn.addEventListener('click', async function () {
        if (typeof JSZip === 'undefined' || typeof saveAs === 'undefined') {
            alert('Library kompresi tidak tersedia. Silakan refresh halaman.');
            return;
        }

        const loadingAlert = Swal.fire({
            title: 'Menyiapkan dokumen',
            html: 'Sedang mengumpulkan semua file...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const files = @json($filesToDownload);
            console.log('Files to download:', files);

            if (!files || files.length === 0) {
                throw new Error('Tidak ada dokumen tersedia');
            }

            const zip = new JSZip();
            const folder = zip.folder('documents');
            let processedFiles = 0;

            const updateProgress = () => {
                loadingAlert.update({
                    html: `Memproses dokumen (${processedFiles}/${files.length})`
                });
            };

            await Promise.all(files.map(async file => {
                try {
                    const response = await fetch(file.url, {
                    method: 'GET',
                    cache: 'no-cache',
                    credentials: 'same-origin' // penting kalau file butuh auth session
                });

                if (!response.ok) {
                    throw new Error(`Gagal mengambil: ${file.name}, status: ${response.status}`);
                }

                const blob = await response.blob();
                console.log(`${file.name} size: ${blob.size} bytes`);
                folder.file(file.name, blob, { binary: true });
                    processedFiles++;
                    updateProgress();
                } catch (error) {
                    console.error(`Error pada file ${file.name}:`, error);
                    processedFiles++;
                    updateProgress();
                }
            }));

            const content = await zip.generateAsync({
                type: "blob",
                compression: "DEFLATE",
                compressionOptions: { level: 6 }
            }, metadata => {
                console.log(`ZIP progress: ${metadata.percent.toFixed(2)}%`);
            });

            saveAs(content, `documents.zip`);
            loadingAlert.close();

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Download selesai',
                showConfirmButton: false,
                timer: 3000
            });

        } catch (error) {
            console.error('ZIP error:', error);
            loadingAlert.close();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: error.message || 'Terjadi kesalahan saat membuat ZIP'
            });
        }
    });
});
</script> --}}
<script>
    async function downloadAllFiles() {
        const files = @json($filesToDownload);

        if (!files || files.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Tidak ada file',
                text: 'Tidak ada file untuk diunduh.'
            });
            return;
        }

        // Tampilkan loading
        const loading = Swal.fire({
            title: 'Menyiapkan Unduhan',
            html: 'Mengunduh file 1 dari ' + files.length,
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // Update progress
            Swal.update({
                html: `Mengunduh file ${i + 1} dari ${files.length}<br><b>${file.name}</b>`
            });

            await new Promise(resolve => {
                setTimeout(() => {
                    const link = document.createElement('a');
                    link.href = file.url;
                    link.download = file.name;
                    link.target = '_blank';
                    link.rel = 'noopener';
                    link.click();
                    resolve();
                }, 700); // JEDA 700ms antar file
            });
        }

        Swal.close();

        // Notifikasi selesai
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Semua file telah diunduh',
            showConfirmButton: false,
            timer: 3000
        });
    }
</script>



<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
@endpush
