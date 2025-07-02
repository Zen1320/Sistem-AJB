@extends('welcome')

@section('content')
    <div id="about-page" class="py-16 bg-white pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Tentang Kami</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Solusi Digital untuk Tanah di Indonesia
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 lg:grid-cols-2">
                <div class="prose prose-lg text-gray-600">
                    <h3 class="text-indigo-600">Visi & Misi</h3>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos id iusto sunt maxime quam harum praesentium odit sed laborum numquam. Dolorem, nulla dicta sed odio magnam nobis itaque molestias voluptates.
                    </p>
                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione magni distinctio enim. Quos sapiente eius unde eos debitis dolor amet temporibus. Sed necessitatibus provident at qui cum! Ea, eligendi officiis?
                    </p>

                    <h3 class="text-indigo-600 mt-8">Teknologi</h3>
                    <p>
                        Sistem dibangun dengan teknologi:
                    </p>
                    <ul>
                        <li>Laravel & Brezze</li>
                        <li>Whatsapp Library untuk mengirimkan notifikasi</li>
                    </ul>
                </div>

                <div class="bg-indigo-50 rounded-lg p-8">
                    <h3 class="text-xl font-bold text-indigo-800">Developer</h3>
                    <div class="mt-6 space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <img class="h-16 w-16 rounded-full" src="" alt="Programmer">
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900">Zen</h4>
                                <p class="text-indigo-600 text-sm">Programmer</p>
                                <p class="mt-1 text-gray-600 text-sm">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolores corrupti perferendis, eius laborum beatae voluptatum officiis nesciunt consequuntur iure hic est quod voluptas molestiae inventore nisi dignissimos adipisci obcaecati laboriosam?</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
