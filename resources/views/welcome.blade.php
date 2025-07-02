<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem E-AJB | Pengelolaan Akta Jual Beli Tanah Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .testimonial-card {
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: scale(1.03);
        }

        .btn-primary {
            background-color: #4e54c8;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #4348a5;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #f5f7fa;
            color: #4e54c8;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #e4e8eb;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed w-full z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <div class="flex items-center">
                        <i class="fas fa-file-signature text-3xl text-indigo-600 mr-3"></i>
                        <span class="text-xl font-bold text-gray-800">E-AJB</span>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-6">
                        <a href="{{route('homepage.beranda')}}" class="px-3 py-2 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600">Beranda</a>
                        <a href="{{route('homepage.tentang')}}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Tentang</a>
                        {{-- <a href="#" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Kontak</a> --}}
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        @if (Route::has('login'))
                                @auth
                                    <a href="{{route('login')}}" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white btn-primary">Dashboard</a>
                                @else
                                <a href="{{route('login')}}" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white btn-primary">Masuk</a>
                                <a href="{{route('register')}}" class="ml-4 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium btn-secondary">Daftar</a>
                                @endauth
                            </nav>
                        @endif

                    </div>
                </div>
                <div class="-mr-2 flex md:hidden">
                    <button type="button" id="mobile-menu-button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="hidden md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{route('homepage.beranda')}}" class="block px-3 py-2 rounded-md text-base font-medium text-indigo-600 bg-indigo-50">Beranda</a>
                <a href="{{route('homepage.tentang')}}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Tentang</a>

            </div>
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="flex items-center px-5 space-x-4">
                    <a href="{{route('login')}}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white btn-primary">Masuk</a>
                    <a href="{{route('register')}}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium btn-secondary">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')
    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <div class="flex items-center">
                        <i class="fas fa-file-signature text-3xl text-white mr-3"></i>
                        <span class="text-xl font-bold text-white">E-AJB</span>
                    </div>
                    <p class="mt-4 text-gray-300 text-sm">
                        Sistem elektronik untuk pengelolaan Akta Jual Beli Tanah berbasis website.
                    </p>
                    <div class="mt-6 flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white tracking-wider uppercase">Legal</h3>
                    <ul class="mt-4 space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white text-sm">Kontak</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 border-t border-gray-700 pt-8">
                <p class="text-gray-400 text-sm text-center">
                    &copy; 2025 E-AJB. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.contains('hidden');
            if(isOpen) {
                mobileMenu.classList.remove('hidden');
                mobileMenuButton.innerHTML = `
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                `;
            } else {
                mobileMenu.classList.add('hidden');
                mobileMenuButton.innerHTML = `
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                `;
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if(targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if(targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>


