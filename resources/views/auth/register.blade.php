<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem E-AJB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#2563eb',
                            dark: '#1d4ed8'
                        },
                        secondary: '#1e40af',
                        dark: '#1e293b',
                        light: '#f8fafc'
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .auth-input {
                @apply w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition duration-200;
            }
            .auth-btn {
                @apply w-full py-3 px-4 rounded-lg font-semibold text-white bg-primary hover:bg-primary-dark transition duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-primary py-6 px-8 text-center">
                <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Pendaftaran E-AJB</h1>
                <p class="text-white opacity-90 mt-1">Buat akun untuk mengakses sistem Akta Jual Beli Elektronik</p>
            </div>

            <!-- Form Register -->
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Formulir Pendaftaran</h2>
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="nama_depan" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap*</label>
                        <input type="text" id="nama_depan" class="auth-input" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap" required>
                    </div>

                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Kependudukan (NIK)*</label>
                        <input type="text" id="nik" class="auth-input" placeholder="16 digit NIK" name="nik" value="{{ old('nik') }}" required maxlength="16" pattern="[0-9]{16}">
                        <p class="mt-1 text-xs text-gray-500">Pastikan NIK sesuai dengan KTP</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                            <input type="email" id="email" class="auth-input" name="email" value="{{ old('email') }}" placeholder="Alamat email aktif" required>
                        </div>

                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">Nomor Handphone Whatsapp*</label>
                             <div class="flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-700 text-sm">+62</span>
                                <input type="tel" id="no_hp" class="auth-input" name="no_telp" value="{{ old('no_telp') }}" placeholder="Contoh: 812233445" required>
                             </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password*</label>
                            <input type="password" id="password" class="auth-input" name="password" placeholder="Minimal 8 karakter" required minlength="8">
                        </div>

                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password*</label>
                            <input type="password" id="confirm_password" class="auth-input" name="confirm_password" placeholder="Ulangi password" required minlength="8">
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" class="focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded" {{ old('terms') ? 'checked' : '' }} required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="font-medium text-gray-700">Saya menyetujui</label>
                            <p class="text-gray-500">Dengan mendaftar, saya setuju dengan <a href="" class="text-primary hover:underline">Syarat & Ketentuan</a> dan <a href="" class="text-primary hover:underline">Kebijakan Privasi</a> yang berlaku</p>
                        </div>
                    </div>

                    <button type="submit" class="auth-btn flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Daftar Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    Sudah memiliki akun?
                    <a href="{{route('login')}}" class="font-medium text-primary hover:underline">Masuk disini</a>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.querySelector("form").addEventListener("submit", function (e) {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        if (password !== confirmPassword) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Password Tidak Sama',
                text: 'Pastikan Password dan Konfirmasi Password cocok.',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Perbaiki'
            });
        }
    });
    </script>

</body>
</html>
