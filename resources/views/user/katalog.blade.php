@extends('layouts.user')
@section('title', 'Katalog Aset')

@section('content')
    <h1 class="text-2xl font-extrabold">Mau cari aset apa?</h1>
    <p class="mt-1 text-sm text-slate-500">Pilih kategori atau gunakan pencarian.</p>

    @if ($hargaMax > 0)
        <div class="mt-3 flex flex-wrap items-center gap-2 rounded-xl border border-teal-200 bg-teal-50 px-4 py-2.5 text-sm text-teal-800">
            <span>Menampilkan aset dengan harga maksimal <strong>Rp {{ number_format($hargaMax, 0, ',', '.') }}</strong> (sesuai simulasi KPR kamu)</span>
            <a href="{{ route('katalog') }}" class="ml-auto text-xs font-bold underline">Hapus filter</a>
        </div>
    @endif

    <form action="{{ route('katalog') }}" class="mt-4 grid gap-2 sm:grid-cols-[1fr_auto_auto_auto]">
        @if ($hargaMax > 0)
            <input type="hidden" name="harga_max" value="{{ $hargaMax }}">
        @endif
        <input name="q" value="{{ $q }}" placeholder="Cari nama aset, alamat, kota..." class="rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-teal-500 focus:outline-none">
        <select name="jenis" class="rounded-xl border border-slate-300 px-3 py-3 text-sm">
            <option value="">Semua jenis</option>
            @foreach ($kategori as $k)
                <option value="{{ $k }}" @selected($jenis === $k)>{{ $k }}</option>
            @endforeach
        </select>
        <select name="kota" class="rounded-xl border border-slate-300 px-3 py-3 text-sm">
            <option value="">Semua kota</option>
            @foreach ($kotaList as $k)
                <option value="{{ $k }}" @selected($kota === $k)>{{ $k }}</option>
            @endforeach
        </select>
        <button class="rounded-xl bg-teal-700 px-6 py-3 text-sm font-bold text-white">Cari</button>
    </form>

    <div class="mt-4 flex flex-wrap gap-2">
        @foreach ($kategori as $k)
            <a href="{{ route('katalog', ['jenis' => $k]) }}"
               class="rounded-full px-4 py-1.5 text-xs font-bold {{ $jenis === $k ? 'bg-teal-700 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">{{ $k }}</a>
        @endforeach
    </div>

    <p class="mt-6 text-sm text-slate-500">Ditemukan <b>{{ $asets->total() }}</b> aset.</p>

    <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($asets as $aset)
            @include('user.partials.kartu-aset', ['aset' => $aset, 'liked' => in_array($aset->id, $likedIds, true)])
        @empty
            <p class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500 sm:col-span-2 lg:col-span-3">Belum ada aset yang cocok.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $asets->links() }}</div>
@endsection