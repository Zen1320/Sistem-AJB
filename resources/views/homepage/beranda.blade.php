@extends('welcome')
@section('content')
    <section class="hero-gradient pt-24 pb-16 md:pt-32 md:pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                    <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span class="block">E-AJB</span>
                        <span class="block text-indigo-600">Electronik Akta Jual Beli</span>
                    </h1>
                    <p class="mt-3 text-base text-gray-600 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                        E-AJB memberikan solusi digital untuk pengelolaan akta jual beli tanah yang aman, cepat, dan terpercaya.
                    </p>
                    <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left lg:mx-0">
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                            <a href="{{route('login')}}" class="px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white btn-primary md:py-4 md:text-lg md:px-10">
                                Mulai Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                    <div class="relative mx-auto w-full rounded-lg shadow-lg lg:max-w-md">
                        <div class="relative block w-full bg-white rounded-lg overflow-hidden">
                            <img class="w-full" src="{{asset('panel/assets/img/logo.jpg')}}" alt="Gambar">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partner Logos -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-semibold uppercase text-gray-500 tracking-wide">
                Bekerja sama dengan instansi terpercaya
            </p>
            <div class="mt-6 grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
                <div class="col-span-1 flex justify-center">
                    <img class="h-12" src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e6/Pertamina_Logo.svg/1200px-Pertamina_Logo.svg.png" alt="Pertamina">
                </div>
                <div class="col-span-1 flex justify-center">
                    <img class="h-12" src="https://upload.wikimedia.org/wikipedia/id/thumb/5/55/BNI_logo.svg/1200px-BNI_logo.svg.png" alt="BNI">
                </div>
                <div class="col-span-1 flex justify-center">
                    <img class="h-12" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQHVgSISwM9A9WhH7aV2RKjSOJT7ML-aB6yPA&s" alt="BRI">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Fitur Unggulan</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Solusi Digital untuk Transaksi Tanah
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 lg:mx-auto">
                   E-AJB memberikan kemudahan dalam mengelola semua proses akta jual beli tanah secara online.
                </p>
            </div>

            <div class="mt-20">
                <div class="space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8 lg:gap-y-12">
                    <!-- Feature 1 -->
                    <div class="feature-card group relative p-8 bg-white rounded-xl shadow-md transition duration-300">
                        <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 w-20 h-20 rounded-full bg-indigo-600 flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-file-contract text-3xl"></i>
                        </div>
                        <h3 class="mt-8 text-lg font-medium text-gray-900 text-center">Pembuatan Akta Digital</h3>
                        <p class="mt-2 text-base text-gray-600 text-center">
                            Buat akta jual beli tanah secara digital dengan proses yang mudah dan cepat hanya melalui Website.
                        </p>
                        <div class="mt-6 flex justify-center">
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card group relative p-8 bg-white rounded-xl shadow-md transition duration-300">
                        <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 w-20 h-20 rounded-full bg-indigo-600 flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-fingerprint text-3xl"></i>
                        </div>
                        <h3 class="mt-8 text-lg font-medium text-gray-900 text-center">Verifikasi Identitas</h3>
                        <p class="mt-2 text-base text-gray-600 text-center">
                            Staff mudah verifikasi Data untuk memastikan keaslian identitas para pihak dalam transaksi.
                        </p>
                        <div class="mt-6 flex justify-center">
                            {{-- <a href="#" class="text-indigo-600 font-medium text-sm inline-flex items-center group-hover:text-indigo-500">
                                Pelajari lebih lanjut
                                <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a> --}}
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card group relative p-8 bg-white rounded-xl shadow-md transition duration-300">
                        <div class="absolute -top-10 left-1/2 transform -translate-x-1/2 w-20 h-20 rounded-full bg-indigo-600 flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-shield-alt text-3xl"></i>
                        </div>
                        <h3 class="mt-8 text-lg font-medium text-gray-900 text-center">Keamanan</h3>
                        <p class="mt-2 text-base text-gray-600 text-center">
                            Dokumen tercatat secara realtime untuk memastikan keaslian dan tidak bisa dipalsukan.
                        </p>
                        <div class="mt-6 flex justify-center">
                            {{-- <a href="#" class="text-indigo-600 font-medium text-sm inline-flex items-center group-hover:text-indigo-500">
                                Pelajari lebih lanjut
                                <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Proses Kerja</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Bagaimana Sistem E-AJB Bekerja
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-600 lg:mx-auto">
                    Proses pembuatan akta jual beli tanah yang sederhana dalam 4 langkah mudah.
                </p>
            </div>

            <div class="mt-16">
                <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                    <!-- Step 1 -->
                    <div class="relative pb-12">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <span class="text-xl font-bold">1</span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Registrasi & Verifikasi</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-base text-gray-600">
                                Buat akun dan lengkapi verifikasi identitas menggunakan e-KTP
                            </p>
                        </div>
                        <div class="absolute top-0 right-0 h-full w-0.5 bg-gray-200 hidden lg:block"></div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative pb-12">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <span class="text-xl font-bold">2</span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Input Data Transaksi</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-base text-gray-600">
                                Masukkan detail transaksi, data properti, dan unggah dokumen pendukung.
                            </p>
                        </div>
                        <div class="absolute top-0 right-0 h-full w-0.5 bg-gray-200 hidden lg:block"></div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative pb-12">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <span class="text-xl font-bold">3</span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Validasi Notaris</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-base text-gray-600">
                                Dokumen diverifikasi oleh notaris terdaftar dan disahkan secara digital.
                            </p>
                        </div>
                        <div class="absolute top-0 right-0 h-full w-0.5 bg-gray-200 hidden lg:block"></div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-600 text-white">
                                <span class="text-xl font-bold">4</span>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Akta Terbit</h3>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-base text-gray-600">
                                Akta digital selesai dengan tanda tangan dan disimpan dengan aman.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- CTA Section -->
    <section class="bg-indigo-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">Siap memodernisasi proses AJB Anda?</span>
                <span class="block text-indigo-200">Daftar sekarang dan dapatkan masa percobaan gratis.</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-100">
                        Mulai Gratis
                    </a>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Hubungi Sales
                    </a>
                </div>
            </div>
        </div>
    </section> --}}


@endsection
