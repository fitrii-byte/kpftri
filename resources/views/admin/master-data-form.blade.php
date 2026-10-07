@extends('layouts.admin')
@section('title', $debitur->exists ? 'Edit Data Debitur' : 'Tambah Data Debitur')

@section('content')
    <a href="{{ route('admin.master.index') }}" class="text-sm font-semibold text-teal-700">&larr; Kembali ke Master Data</a>

    <section class="mt-4 max-w-2xl rounded-2xl border border-slate-200 bg-white p-6">
        <h2 class="text-base font-extrabold">{{ $debitur->exists ? 'Edit Data Debitur' : 'Tambah Data Debitur' }}</h2>

        @if ($errors->any())
            <div class="mt-4 rounded-xl bg-red-50 p-4 text-sm text-red-600">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ $debitur->exists ? route('admin.master.update', $debitur) : route('admin.master.store') }}"
              class="mt-4 grid gap-4 sm:grid-cols-2">
            @csrf
            @if ($debitur->exists) @method('PUT') @endif

            <div>
                <label class="text-xs font-bold text-slate-500">CIF</label>
                <input name="cif" value="{{ old('cif', $debitur->cif) }}" required
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500">No Loan</label>
                <input name="no_loan" value="{{ old('no_loan', $debitur->no_loan) }}" required
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="text-xs font-bold text-slate-500">Nama Nasabah</label>
                <input name="nama" value="{{ old('nama', $debitur->nama) }}" required
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500">Segmen</label>
                <input name="segmen" value="{{ old('segmen', $debitur->segmen) }}" required
                       placeholder="Konsumer / Mikro / Komersial"
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500">Produk</label>
                <input name="produk" value="{{ old('produk', $debitur->produk) }}" required
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="text-xs font-bold text-slate-500">Cabang Pengelola</label>
                <input name="cabang_pengelola" value="{{ old('cabang_pengelola', $debitur->cabang_pengelola) }}" required
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500">Kolektibilitas (1-5)</label>
                <input type="number" min="1" max="5" name="kolektibilitas" value="{{ old('kolektibilitas', $debitur->kolektibilitas) }}" required
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                <p class="mt-1 text-[11px] text-slate-400">Kol 1-2 = Non NPF, Kol 3-5 = NPF (otomatis).</p>
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500">OS Pokok (Rp)</label>
                <input type="number" step="0.01" min="0" name="os_pokok" value="{{ old('os_pokok', $debitur->os_pokok) }}" required
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>

            <div class="sm:col-span-2 mt-2 flex gap-2">
                <button class="rounded-xl bg-teal-700 px-6 py-2.5 text-sm font-bold text-white">
                    {{ $debitur->exists ? 'Simpan Perubahan' : 'Simpan Data' }}
                </button>
                <a href="{{ route('admin.master.index') }}" class="rounded-xl border border-slate-300 px-6 py-2.5 text-sm font-bold text-slate-600">Batal</a>
            </div>
        </form>
    </section>
@endsection