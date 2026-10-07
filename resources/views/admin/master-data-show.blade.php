@extends('layouts.admin')
@section('title', 'Detail Debitur')

@section('content')
    <a href="{{ route('admin.master.index') }}" class="text-sm font-semibold text-teal-700">&larr; Kembali ke Master Data</a>

    <section class="mt-4 max-w-2xl rounded-2xl border border-slate-200 bg-white p-6">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <h2 class="text-xl font-extrabold">{{ $debitur->nama }}</h2>
                <p class="text-sm text-slate-500">CIF {{ $debitur->cif }} &middot; No Loan {{ $debitur->no_loan }}</p>
            </div>
            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $debitur->is_npf ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-700' }}">
                Kol {{ $debitur->kolektibilitas }} &middot; {{ $debitur->is_npf ? 'NPF' : 'Non NPF' }}
            </span>
        </div>

        <dl class="mt-6 grid gap-4 sm:grid-cols-2 text-sm">
            <div><dt class="text-xs text-slate-500">Segmen</dt><dd class="font-bold">{{ $debitur->segmen }}</dd></div>
            <div><dt class="text-xs text-slate-500">Produk</dt><dd class="font-bold">{{ $debitur->produk }}</dd></div>
            <div class="sm:col-span-2"><dt class="text-xs text-slate-500">Cabang Pengelola</dt><dd class="font-bold">{{ $debitur->cabang_pengelola }}</dd></div>
            <div><dt class="text-xs text-slate-500">OS Pokok</dt><dd class="font-bold text-teal-700">Rp {{ number_format($debitur->os_pokok, 0, ',', '.') }}</dd></div>
            <div><dt class="text-xs text-slate-500">Terdaftar</dt><dd class="font-bold">{{ $debitur->created_at?->format('d/m/Y H:i') }}</dd></div>
        </dl>

        <div class="mt-6 flex gap-2">
            <a href="{{ route('admin.master.edit', $debitur) }}" class="rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white">Edit Data</a>
            <form method="POST" action="{{ route('admin.master.destroy', $debitur) }}" onsubmit="return confirm('Hapus data debitur ini?')">
                @csrf @method('DELETE')
                <button class="rounded-xl bg-red-50 px-5 py-2.5 text-sm font-bold text-red-600">Hapus</button>
            </form>
        </div>
    </section>

    @if ($debitur->asets->count())
        <h2 class="mt-8 text-lg font-extrabold">Aset Agunan Terkait</h2>
        <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($debitur->asets as $aset)
                <a href="{{ route('katalog.show', $aset) }}" target="_blank" class="overflow-hidden rounded-2xl border border-slate-200 bg-white hover:shadow-lg">
                    <img src="{{ $aset->gambar_url }}" alt="{{ $aset->nama }}" class="h-36 w-full object-cover" loading="lazy">
                    <div class="p-3">
                        <p class="font-bold text-sm">{{ $aset->nama }}</p>
                        <p class="text-xs text-slate-500">{{ $aset->kota }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection