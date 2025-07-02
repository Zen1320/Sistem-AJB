@extends('layouts.app')
@section('title','verify')
@section('content')
    <div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header dengan progress bar -->
            <div class="d-flex flex-column mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="fw-bold text-primary mb-0">Lengkapi Profil Anda</h2>
                    <span class="badge bg-primary rounded-pill">Wajib Diisi</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%;"
                        aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted mt-2">Lengkapi {{ $progress }}% dari profil Anda</small>
            </div>

            <div class="row g-4">
                <!-- Form Utama -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 p-md-5">
                            <form id="profileForm" method="POST" action="{{ route('profile.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!-- Section Informasi Pribadi -->
                                <div class="mb-5">
                                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                                        <span class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        Informasi Pribadi
                                    </h5>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $user->name) }}"
                                                placeholder="Sesuai KTP" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                                id="nik" name="nik" value="{{ old('nik', $user->nik) }}"
                                                placeholder="16 digit NIK" required maxlength="16">
                                            @error('nik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Nomor Induk Kependudukan sesuai KTP</small>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">+62</span>
                                                <input type="tel" class="form-control @error('no_telp') is-invalid @enderror"
                                                    id="phone" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}" required>
                                            </div>
                                            @error('no_telp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                                id="alamat" name="alamat" rows="3" required
                                                placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan, Kota">{{ old('alamat', $user->alamat) }}</textarea>
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Upload Dokumen -->
                                <div class="mb-5">
                                    <h5 class="fw-bold mb-4 d-flex align-items-center">
                                        <span class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                                            <i class="fas fa-file-upload"></i>
                                        </span>
                                        Upload Dokumen
                                    </h5>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="foto" class="form-label">Foto Profil</label>
                                            <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                                id="photo" name="foto" accept="image/*">
                                            @error('foto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Format: JPG/PNG (maks. 2MB)</small>

                                            @if($user->foto)
                                                <div class="mt-3">
                                                    <p class="small mb-1">Foto saat ini:</p>
                                                    <img src="{{ Storage::url($user->foto) }}" alt="Foto Profil"
                                                        class="img-thumbnail" width="120">
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-6">
                                            <label for="file_ktp" class="form-label">Scan KTP <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('file_ktp') is-invalid @enderror"
                                                id="file_ktp" name="file_ktp" accept=".pdf,.jpg,.jpeg,.png"
                                                {{ !$user->file_ktp ? 'required' : '' }}>
                                            @error('file_ktp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Format: PDF/JPG/PNG (maks. 5MB)</small>

                                            @if($user->file_ktp)
                                                <div class="mt-3">
                                                    <p class="small mb-1">KTP saat ini:</p>
                                                    <a href="{{ Storage::url($user->file_ktp) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i> Lihat KTP
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Section Persetujuan -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input @error('terms') is-invalid @enderror"
                                            type="checkbox" id="terms" name="terms" required>
                                        <label class="form-check-label" for="terms">
                                            Saya menyatakan bahwa semua data yang saya berikan adalah benar dan valid.
                                            Saya memahami bahwa data palsu akan berakibat pada pembatalan layanan.
                                        </label>
                                        @error('terms')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <button type="submit" class="btn btn-primary px-4 py-2">
                                        <i class="fas fa-save me-2"></i> Simpan Profil
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Panduan -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="fas fa-info-circle text-primary"></i>
                                </div>
                                <h5 class="mb-0">Panduan Pengisian</h5>
                            </div>

                            <div class="accordion" id="guideAccordion">
                                <div class="accordion-item border-0 mb-3">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button bg-light p-3 rounded" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#guideNIK">
                                            <i class="fas fa-id-card text-primary me-2"></i> Tentang NIK
                                        </button>
                                    </h6>
                                    <div id="guideNIK" class="accordion-collapse collapse show"
                                        data-bs-parent="#guideAccordion">
                                        <div class="accordion-body pt-2 small">
                                            <p>NIK adalah Nomor Induk Kependudukan 16 digit yang tercantum pada KTP Anda. Pastikan:</p>
                                            <ul>
                                                <li>Diisi tanpa spasi atau tanda baca</li>
                                                <li>Sesuai dengan dokumen asli</li>
                                                <li>Masukkan semua 16 digit angka</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item border-0 mb-3">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed bg-light p-3 rounded" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#guidePhoto">
                                            <i class="fas fa-camera text-primary me-2"></i> Foto Profil
                                        </button>
                                    </h6>
                                    <div id="guidePhoto" class="accordion-collapse collapse"
                                        data-bs-parent="#guideAccordion">
                                        <div class="accordion-body pt-2 small">
                                            <p>Gunakan foto terbaru dengan kriteria:</p>
                                            <ul>
                                                <li>Wajah jelas terlihat (tidak menggunakan kacamata hitam)</li>
                                                <li>Latar belakang polos (disarankan warna netral)</li>
                                                <li>Ukuran file maksimal 2MB</li>
                                                <li>Format JPG atau PNG</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item border-0">
                                    <h6 class="accordion-header">
                                        <button class="accordion-button collapsed bg-light p-3 rounded" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#guideKTP">
                                            <i class="fas fa-id-card-alt text-primary me-2"></i> Scan KTP
                                        </button>
                                    </h6>
                                    <div id="guideKTP" class="accordion-collapse collapse"
                                        data-bs-parent="#guideAccordion">
                                        <div class="accordion-body pt-2 small">
                                            <p>Pastikan scan KTP memenuhi persyaratan:</p>
                                            <ul>
                                                <li>Seluruh bagian KTP terlihat jelas</li>
                                                <li>Tidak blur atau buram</li>
                                                <li>Format PDF, JPG, atau PNG</li>
                                                <li>Ukuran file maksimal 5MB</li>
                                                <li>Data terbaca dengan baik</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Profil -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4 text-center">
                            <div class="position-relative d-inline-block mb-3">
                                @if($user->foto)
                                    <img src="{{ Storage::url($user->foto) }}"
                                        class="rounded-circle border border-3 border-primary"
                                        width="120" height="120" alt="Foto Profil">
                                @else
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                        style="width: 120px; height: 120px;">
                                        <i class="fas fa-user text-muted fs-1"></i>
                                    </div>
                                @endif
                                <span class="position-absolute bottom-0 end-0 bg-primary rounded-circle p-2 border border-2 border-white">
                                    <i class="fas fa-check text-white"></i>
                                </span>
                            </div>

                            <h5 class="mb-1">{{ $user->nama }}</h5>
                            <p class="text-muted small mb-3">{{ $user->email }}</p>

                            <div class="d-flex justify-content-between small mb-3">
                                <div>
                                    <p class="mb-0 fw-bold">NIK</p>
                                    <p class="text-muted">{{ $user->nik ? ($user->nik) : 'Belum diisi' }}</p>
                                </div>
                                <div>
                                    <p class="mb-0 fw-bold">Telepon</p>
                                    <p class="text-muted">{{ $user->no_telp ? '+62'.$user->no_telp : 'Belum diisi' }}</p>
                                </div>
                            </div>

                            <div class="alert alert-light p-2 small mb-0">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Profil {{ $user->verify ? 'sudah' : 'belum' }} lengkap
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    document.getElementById('nik').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);
    });
    document.getElementById('photo').addEventListener('change', function(e) {
        validateFileSize(this, 2); // 2MB
    });

    document.getElementById('ktp_file').addEventListener('change', function(e) {
        validateFileSize(this, 5); // 5MB
    });

    function validateFileSize(input, maxSizeMB) {
        if (input.files && input.files[0]) {
            const fileSize = input.files[0].size / 1024 / 1024;
            if (fileSize > maxSizeMB) {
                alert(`Ukuran file maksimal ${maxSizeMB}MB`);
                input.value = '';
            }
        }
    }
</script>
@endpush
