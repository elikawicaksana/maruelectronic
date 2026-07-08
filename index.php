<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maru's Electronics</title>
    <link href="src/output.css" rel="stylesheet">
    
</head>
<body class="bg-black text-gray-200">

    <nav class="bg-black border-b border-green-800/50 fixed w-full z-20 top-0 start-0">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <div class="w-8 h-8 bg-green-800 rounded flex items-center justify-center border border-green-900">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="self-center text-2xl font-bold whitespace-nowrap text-white tracking-tight">Maru's <span class="text-green-800">Electronics</span></span>
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <a href="login.html" class="text-white bg-green-800 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-900 font-bold rounded-lg text-sm px-5 py-2.5 text-center transition-colors">Login / Register</a>
                <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-green-800 rounded-lg md:hidden hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-green-800" aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Buka menu utama</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-900 rounded-lg bg-gray-900 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-black">
                    <li><a href="#" class="block py-2 px-3 text-white bg-green-800 rounded md:bg-transparent md:text-green-800 md:p-0 font-bold" aria-current="page">Beranda</a></li>
                    <li><a href="#katalog" class="block py-2 px-3 text-gray-400 rounded hover:bg-gray-800 md:hover:bg-transparent md:hover:text-green-800 md:p-0 transition-colors">Katalog Produk</a></li>
                    <li><a href="cart.html" class="block py-2 px-3 text-gray-400 rounded hover:bg-gray-800 md:hover:bg-transparent md:hover:text-green-800 md:p-0 transition-colors">Keranjang <span class="inline-flex items-center justify-center w-5 h-5 ms-2 text-xs font-bold text-white bg-green-800 rounded-full">0</span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="bg-black pt-20 border-b border-green-800/30">
        <div class="grid max-w-screen-xl px-4 py-16 mx-auto lg:gap-8 xl:gap-0 lg:py-24 lg:grid-cols-12">
            <div class="mr-auto place-self-center lg:col-span-7">
                <span class="bg-green-900/20 text-green-600 text-xs font-medium px-2.5 py-0.5 rounded border border-green-800 mb-4 inline-block">Sistem Integrasi Ujian Akhir</span>
                <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl text-white">Komputasi & <br>Periferal <span class="text-green-800">Kinerja Tinggi</span></h1>
                <p class="max-w-2xl mb-6 font-light text-gray-400 lg:mb-8 md:text-lg lg:text-xl">Platform penyedia perangkat keras unggulan. Terintegrasi dengan pemrosesan pembayaran instan untuk pengalaman checkout tanpa hambatan.</p>
                <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                    <a href="#katalog" class="inline-flex items-center justify-center px-6 py-3 text-base font-bold text-center text-white rounded-lg bg-green-800 hover:bg-green-900 focus:ring-4 focus:ring-green-900 transition-colors">
                        Lihat Katalog Lengkap
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            </div>
            <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                <img src="https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?auto=format&fit=crop&w=800&q=80" alt="CPU Dashboard" class="rounded-xl shadow-[0_0_20px_rgba(22,101,52,0.4)] border border-green-800 opacity-90 hover:opacity-100 transition-opacity">
            </div>                
        </div>
    </section>

    <section id="katalog" class="bg-black py-12">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <div class="mb-8 items-end justify-between space-y-4 sm:space-y-0 border-b border-gray-800 pb-4">
                <div>
                    <h2 class="text-2xl text-center font-bold text-white sm:text-3xl tracking-tight">Katalog Produk</h2>
                    <p class="mt-2 text-center text-gray-400 text-sm">Pilih komponen dan perangkat keras untuk simulasi checkout Anda.</p>
                </div>
            </div>
            
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl border border-gray-800 bg-gray-900 p-6 shadow-sm hover:border-green-800 transition-colors">
                    <div class="h-48 w-full flex items-center justify-center overflow-hidden rounded-lg bg-black mb-4">
                        <img class="object-cover h-full w-full opacity-80 hover:opacity-100 transition-opacity" src="https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?auto=format&fit=crop&w=400&q=80" alt="Produk" />
                    </div>
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="bg-black text-gray-300 border border-gray-700 text-xs font-medium px-2 py-0.5 rounded">Kategori Dummy</span>
                            <span class="text-sm font-bold text-green-600">Stok: 12</span>
                        </div>
                        <a href="detail.html" class="text-lg font-bold leading-tight text-white hover:text-green-500 transition-colors">Nama Produk Dummy</a>
                        <p class="mt-4 text-xl font-extrabold text-white">Rp 00.000.000</p>
                        <div class="mt-5">
                            <button type="button" class="w-full justify-center inline-flex items-center rounded-lg bg-green-800 px-5 py-2.5 text-sm font-bold text-white hover:bg-green-900 focus:outline-none focus:ring-4 focus:ring-green-900 transition-colors">
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </section>

    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>