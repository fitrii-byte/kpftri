@extends('layouts.user')
@section('title', 'Selamat Datang')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="flex flex-col items-center text-center">
            <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-teal-600 text-2xl font-extrabold text-white">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </span>

            <h1 class="mt-5 text-2xl font-extrabold text-slate-800">
                Halo, selamat datang {{ auth()->user()->name }} 👋
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Senang bertemu kamu lagi di Portal Digital Aset BSI.
            </p>
        </div>

        <section class="mt-8 overflow-hidden rounded-3xl bg-gradient-to-br from-teal-800 to-emerald-700 px-6 py-8 text-white sm:px-10">
            <span class="inline-block rounded-full bg-white/15 px-3 py-1 text-[11px] font-bold uppercase tracking-wide">Bank Syariah Indonesia</span>
            <h2 class="mt-3 max-w-xl text-xl font-extrabold leading-snug sm:text-2xl">
                Temukan aset lelang terbaik dari BSI, transparan dan terpercaya.
            </h2>
            <p class="mt-2 max-w-xl text-sm text-white/80">
                Jelajahi ribuan pilihan aset agunan seperti tanah, rumah, ruko, hingga gudang langsung dari Bank Syariah Indonesia.
            </p>
        </section>

        @if ($banners->count())
            <h2 class="mt-8 text-lg font-extrabold text-slate-800">Info &amp; Promo BSI</h2>
            <div class="mt-3 grid gap-4 sm:grid-cols-2">
                @foreach ($banners as $b)
                    <a href="{{ $b->link ?? '#' }}" class="overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:shadow-lg">
                        @if ($b->gambar)
                            <img src="{{ asset($b->gambar) }}" alt="{{ $b->judul }}" class="h-36 w-full object-cover" loading="lazy">
                        @endif
                        <div class="p-4">
                            <h3 class="font-bold text-slate-800">{{ $b->judul }}</h3>
                            @if ($b->deskripsi)
                                <p class="mt-1 text-sm text-slate-600">{{ $b->deskripsi }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('katalog') }}"
               class="inline-block rounded-xl bg-teal-700 px-8 py-3 text-sm font-bold text-white hover:bg-teal-800">
                Lanjut ke Katalog
            </a>
        </div>
    </div>
@endsection