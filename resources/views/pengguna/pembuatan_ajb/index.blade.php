@extends('layouts.app')
@section('title','Formulir')

@section('content')
<div class="container py-4">
      <div class="card border-0 shadow-sm rounded-0">
        <div class="card-body">
 <!-- Header dengan progress indicator -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Formulir Pengajuan Akta Jual Beli</h2>
        <p class="text-muted">Lengkapi formulir berikut untuk mengajukan pembuatan Akta Jual Beli (AJB)</p>

        <!-- Progress Steps -->
        <div class="d-flex justify-content-between position-relative mt-4">
            <div class="progress-line position-absolute top-50 start-0 end-0" style="height: 3px; background-color: #e9ecef;"></div>
            <div class="progress-line-active position-absolute top-50 start-0" style="height: 3px; background-color: #0d6efd;"></div>

            <div class="step active" data-step="0">
                <div class="step-circle bg-primary text-white">1</div>
                <div class="step-label mt-2 small">Penjual</div>
            </div>
            <div class="step" data-step="1">
                <div class="step-circle bg-light border">2</div>
                <div class="step-label mt-2 small">Pembeli</div>
            </div>
            {{-- <div class="step" data-step="2">
                <div class="step-circle bg-light border">3</div>
                <div class="step-label mt-2 small">Saksi</div>
            </div> --}}
            <div class="step" data-step="2">
                <div class="step-circle bg-light border">3</div>
                <div class="step-label mt-2 small">Objek</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-circle bg-light border">4</div>
                <div class="step-label mt-2 small">Berkas</div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{route('pengguna.AJB.store')}}" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        <!-- Step 1: Informasi Penjual -->
        <div class="form-step active">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i> Informasi Penjual</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <x-form.input label="Nama Lengkap" name="penjual_nama" value="{{ old('penjual_nama') }}" icon="user" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="NIK" name="penjual_nik" icon="id-card" required maxlength="16" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Tanggal Lahir" name="penjual_tgl_lahir" type="date" icon="calendar" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Tempat Lahir" name="penjual_tempat_lahir" icon="map-marker-alt" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="No Telp" name="no_telepon_penjual" required>
                                <x-slot name="prepend">+62</x-slot>
                            </x-form.input>
                            <span class="text-muted">*Nomor yang dimasukan sudah terhubung dengan whatsapp</span>
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Pekerjaan" name="pekerjaan_penjual" icon="briefcase" required />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-female me-2"></i> Informasi Istri Penjual
                    </h5>
                    <small class="text-white-50 ms-4 fst-italic">
                        *Kosongkan bila belum menikah
                    </small>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <x-form.input label="Nama Istri" name="istri_nama" icon="user" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="NIK Istri" name="istri_nik" icon="id-card" maxlength="16" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Tanggal Lahir Istri" name="istri_tgl_lahir" type="date" icon="calendar" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Tempat Lahir Istri" name="istri_tempat_lahir" icon="map-marker-alt" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="No Telp" name="no_telepon_istri_penjual" >
                                <x-slot name="prepend">+62</x-slot>
                            </x-form.input>
                            <span class="text-muted">*Nomor yang dimasukan sudah terhubung dengan whatsapp</span>
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Pekerjaan" name="pekerjaan_penjual_istri" icon="briefcase" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-home me-2"></i> Alamat Penjual</h5>
                </div>
                <div class="card-body">
                    <x-form.textarea label="Alamat Lengkap" name="penjual_alamat" icon="map-marked-alt" required />
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-primary next-step">
                    Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </div>

        <!-- Step 2: Informasi Pembeli -->
        <div class="form-step">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i> Informasi Pembeli</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <x-form.input label="Nama Lengkap" name="pembeli_nama" icon="user" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="NIK" name="pembeli_nik" icon="id-card" required maxlength="16" />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Tanggal Lahir" name="pembeli_tgl_lahir" type="date" icon="calendar" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Tempat Lahir" name="pembeli_tempat_lahir" icon="map-marker-alt" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="No Telp" name="no_telepon_pembeli" required>
                                <x-slot name="prepend">+62</x-slot>
                            </x-form.input>
                            <span class="text-muted">*Nomor yang dimasukan sudah terhubung dengan whatsapp</span>
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Pekerjaan" name="pekerjaan" icon="briefcase" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-home me-2"></i> Alamat Pembeli</h5>
                </div>
                <div class="card-body">
                    <x-form.textarea label="Alamat Lengkap" name="pembeli_alamat" icon="map-marked-alt" required />
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary prev-step">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </button>
                <button type="button" class="btn btn-success next-step">
                    Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </div>

        <div class="form-step">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 text-uppercase">
                        <i class="fas fa-map-marked-alt me-2"></i> Informasi Objek Tanah
                    </h5>
                </div>

                <div class="card-body">
                    {{-- Informasi Surat --}}
                    <h6 class="text-primary fw-bold border-start border-4 ps-2 mb-3">
                        <i class="fas fa-file-alt me-2"></i> Data Surat
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <x-form.selected
                                label="Jenis Pengajuan"
                                name="id_jenis"
                                icon="list-alt"
                                required
                            >
                                <option value="">Pilih Jenis Pengajuan</option>
                                @foreach($jenis_pengajuan as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                                @endforeach
                            </x-form.selected>
                        </div>
                        <div class="col-md-4">
                            <x-form.input label="Nomor Hak Bangun" name="nomor_hak_bangun" icon="hashtag" required />
                        </div>
                        <div class="col-md-4">
                            <x-form.input label="Nomor Surat Ukur" name="nomor_surat_ukur" icon="ruler-combined" required />
                        </div>
                        <div class="col-md-4">
                            <x-form.input label="Tanggal Surat Ukur" name="tanggal_surat_ukur" type="date" icon="calendar" required />
                        </div>
                        <div class="col-md-4">
                            <x-form.input label="Luas Tanah (m²) (meter persegi)" name="luas_tanah" icon="map" required />
                        </div>
                        <div class="col-md-4">
                            <x-form.input label="Luas Bangunan (m²) (meter persegi)" name="luas_bangunan" icon="building" required />
                        </div>
                        <div class="col-md-4">
                            <x-form.input label="Nomor NIB" name="nomor_nib" icon="file-alt" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Pengesah NIB Oleh" name="pengesah_nib_oleh" icon="stamp" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Nomor SPP" name="nomor_spp" icon="file-signature" required />
                        </div>
                        <div class="col-md-4">
                            <x-form.input label="Harga Transaksi" name="harga_transaksi" icon="money-bill-wave" required class="rupiah-format" />
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Lokasi Tanah --}}
                    <h6 class="text-primary fw-bold border-start border-4 ps-2 mb-3">
                        <i class="fas fa-map me-2"></i> Lokasi Tanah
                    </h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <x-form.input label="Provinsi" name="provinsi" icon="globe-asia" required />
                        </div>
                        <div class="col-md-3">
                            <x-form.input label="Kota/Kabupaten" name="kota" icon="city" required />
                        </div>
                        <div class="col-md-3">
                            <x-form.input label="Kecamatan" name="kecamatan" icon="map" required />
                        </div>
                        <div class="col-md-3">
                            <x-form.input label="Kelurahan" name="kelurahan" icon="map-pin" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Jalan" name="jalan" icon="road" required />
                        </div>
                        <div class="col-12">
                            <x-form.textarea label="Alamat Lengkap" name="alamat_lengkap" icon="map-marked-alt" required rows="3" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Navigasi --}}
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary px-4 py-2 prev-step">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </button>
                <button type="button" class="btn btn-primary text-white px-4 py-2 next-step">
                    Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </div>


        <!-- Step 5: Pemberkasan File -->
        <div class="form-step">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-file-upload me-2"></i> Unggah Berkas</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Pastikan semua dokumen diunggah dalam format PDF/JPG/PNG dengan ukuran maksimal 5MB
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <x-form.file label="KTP Pembeli" name="berkas_ktp_pembeli" icon="id-card" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.file label="KK Pembeli" name="berkas_kk_pembeli" icon="file-contract" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.file label="KTP Penjual" name="berkas_ktp_penjual" icon="id-card" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.file label="KTP Istri Penjual " name="berkas_ktp_istri" icon="id-card" />
                        </div>
                        <div class="col-md-6">
                            <x-form.file label="Akta Nikah " name="berkas_akta_nikah" icon="file-contract" />
                        </div>
                          <div class="col-md-6">
                            <x-form.file label="KK Penjual " name="berkas_kk_penjual" icon="file-contract" />
                        </div>
                        <div class="col-md-6">
                            <x-form.file label="Sertifikat Tanah" name="berkas_sertifikat" icon="file" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.file label="Bukti PBB" name="berkas_bukti_pbb" icon="receipt" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.file label="Dokumen IMB" name="berkas_file_imb" icon="receipt" required />
                        </div>
                        <div class="col-md-6">
                            <x-form.file label="Persetujuan" name="berkas_file_persetujuan" icon="file-signature" required/>
                        </div>
                        <div class="col-12">
                            <x-form.file label="Dokumen Pendukung Lainnya" name="berkas_dokumen_lainnya" icon="file-archive" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary prev-step">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </button>
                <button type="submit" class="btn btn-dark">
                    <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan
                </button>
            </div>
        </div>
    </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-step {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .form-step.active {
        display: block;
    }

    /* Progress Steps */
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
        width: 25%; /* <= Tetapkan untuk 4 step */
    }

    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        border: 2px solid #dee2e6;
        transition: all 0.3s ease-in-out;
    }
    .step-circle:hover {
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
    cursor: pointer;
}

    .step.active .step-circle {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .step-label {
        font-weight: 500;
        color: #6c757d;
    }

    .step.active .step-label {
        color: #0d6efd;
        font-weight: 600;
    }

    .progress-line {
        z-index: 0;
    }

    .progress-line-active {
        z-index: 1;
        width: 0%;
        transition: width 0.5s ease;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* File Input Styling */
    .custom-file-button input[type="file"] {
        position: absolute;
        opacity: 0;
        width: 1px;
        height: 1px;
    }

    .custom-file-button label {
        cursor: pointer;
    }

    /* Card styling */
    .card-header {
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.form-step');
    const stepIndicators = document.querySelectorAll('.step');
    const progressLine = document.querySelector('.progress-line-active');
    let currentStep = 0;


    // Initialize
    updateProgress();

    // Next step buttons
    document.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                goToStep(currentStep + 1);
            }
        });
    });

    // Previous step buttons
    document.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', function() {
            goToStep(currentStep - 1);
        });
    });

    // Step indicator click
    stepIndicators.forEach(indicator => {
        indicator.addEventListener('click', function() {
            const step = parseInt(this.getAttribute('data-step'));
            if (step < currentStep) {
                goToStep(step);
            }
        });
    });

    function goToStep(step) {
        if (step >= 0 && step < steps.length) {
            stepIndicators.forEach((indicator, index) => {
                const circle = indicator.querySelector('.step-circle');

                if (index < step) {
                    // Sudah dilewati
                    circle.classList.remove('bg-light');
                    circle.classList.add('bg-primary');
                    circle.classList.add('text-white');
                } else if (index === step) {
                    // Step aktif sekarang
                    circle.classList.remove('bg-light');
                    circle.classList.add('bg-primary');
                    circle.classList.add('text-white');
                } else {
                    // Belum dilewati
                    circle.classList.remove('bg-primary');
                    circle.classList.remove('text-white');
                    circle.classList.add('bg-light');
                }

                // Highlight aktif
                if (index === step) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });

            steps.forEach((formStep, index) => {
                formStep.classList.toggle('active', index === step);
            });

            currentStep = step;
            updateProgress();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }



    function updateProgress() {
        const percentage = (currentStep / (steps.length - 1)) * 100;
        progressLine.style.width = `${percentage}%`;
    }

    function validateStep(step) {
        const currentFormStep = steps[step];
        const inputs = currentFormStep.querySelectorAll('[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            // Scroll to first invalid input
            const firstInvalid = currentFormStep.querySelector('.is-invalid');
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        return isValid;
    }

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (!validateStep(currentStep)) {
            e.preventDefault();
        }
    });

    // File input preview
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const label = this.nextElementSibling;
            const fileName = this.files[0]?.name || 'Pilih file...';
            label.querySelector('.file-name').textContent = fileName;
        });
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const rupiahInputs = document.querySelectorAll(".rupiah-format");

    rupiahInputs.forEach(input => {
        input.addEventListener("input", function (e) {
            // Hilangkan semua karakter non-digit
            let value = this.value.replace(/\D/g, "");
            // Format angka ke ribuan
            value = new Intl.NumberFormat("id-ID").format(value);
            this.value = value;
        });

        // Saat submit form, ubah format ke nilai angka asli
        input.closest("form")?.addEventListener("submit", function () {
            input.value = input.value.replace(/\./g, "");
        });
    });
});
</script>

@endpush

