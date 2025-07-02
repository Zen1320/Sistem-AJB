@extends('layouts.app')
@section('title', 'Pengaturan Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Pengaturan Profile</h5>
                </div>

                <div class="card-body">
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Error Message -->
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="row">
                        <!-- Profile Picture Section -->
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="position-relative mx-auto" style="width: 150px;">
                                <img src="{{Storage::url(Auth::user()->foto)  ?? asset('images/default-avatar.png') }}"
                                     class="rounded-circle img-thumbnail"
                                     alt="Profile Picture"
                                     id="profile-picture-preview"
                                     style="width: 150px; height: 150px; object-fit: cover;">

                                <button class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle"
                                        data-bs-toggle="modal" data-bs-target="#changePhotoModal"
                                        style="width: 36px; height: 36px;">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>

                            <h5 class="mt-3 mb-0">{{ Auth::user()->name }}</h5>
                            <p class="text-muted">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Account Details Section -->
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h6 class="border-bottom pb-2 mb-3">Informasi Akun</h6>
                                <div class="row mb-2">
                                    <div class="col-sm-4 fw-bold">Nama Lengkap</div>
                                    <div class="col-sm-8">{{ Auth::user()->name }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4 fw-bold">Email</div>
                                    <div class="col-sm-8">{{ Auth::user()->email }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 fw-bold">Bergabung Pada</div>
                                    <div class="col-sm-8">{{ Auth::user()->created_at->format('d F Y') }}</div>
                                </div>
                            </div>

                            <!-- Change Password Section -->
                            <div>
                                <h6 class="border-bottom pb-2 mb-3">Ubah Password</h6>
                                <form method="POST" action="{{ route('profile.update-password') }}" id="passwordForm">
                                    @csrf

                                    <!-- Current Password -->
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Password Saat Ini</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control"
                                                id="current_password" name="current_password" required
                                                placeholder="Masukkan password saat ini">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="current_password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback" id="currentPasswordError"></div>
                                    </div>

                                    <!-- New Password -->
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control"
                                                id="new_password" name="new_password" required
                                                placeholder="Minimal 8 karakter"
                                                minlength="8">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">Minimal 8 karakter</div>
                                        <div class="invalid-feedback" id="newPasswordError">
                                            Password harus minimal 8 karakter
                                        </div>
                                    </div>

                                    <!-- Confirm New Password -->
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control"
                                                id="new_password_confirmation" name="new_password_confirmation" required
                                                placeholder="Ketik ulang password baru">
                                            <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password_confirmation">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback" id="confirmPasswordError">
                                            Password tidak cocok
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Photo Modal -->
<div class="modal fade" id="changePhotoModal" tabindex="-1" aria-labelledby="changePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('profile.update-photo') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="changePhotoModalLabel">Ubah Foto Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="photo" class="form-label">Pilih Foto Baru</label>
                        <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                        <div class="form-text">Format: JPG, PNG, maksimal 2MB</div>
                    </div>
                    <div class="text-center">
                        <img id="photo-preview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-width: 200px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Foto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview selected photo before upload
    document.getElementById('photo').addEventListener('change', function(e) {
        const preview = document.getElementById('photo-preview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }

            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.classList.add('d-none');
        }
    });

      document.addEventListener('DOMContentLoaded', function () {
        const toggleButtons = document.querySelectorAll('.toggle-password');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const targetInput = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (targetInput.type === 'password') {
                    targetInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    targetInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
</script>
@endpush
