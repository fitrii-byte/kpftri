@extends('layouts.admin')
@section('title', 'Booklet Aset')

@section('content')
    <section class="rounded-2xl border border-slate-200 bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 p-5">
            <div>
                <h2 class="text-base font-extrabold">Daftar Aset Siap Cetak Booklet</h2>
                <p class="text-sm text-slate-500">Pilih aset debitur untuk membuka booklet promosi siap cetak.</p>
            </div>
            <form action="{{ route('admin.booklet.index') }}" class="flex gap-2">
                <input name="q" value="{{ $q }}" placeholder="Cari nasabah, no loan, cabang..." class="rounded-xl border border-slate-300 px-3 py-2 text-sm">
                <button class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-bold text-white">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-bold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Foto</th>
                        <th class="px-4 py-3">Aset</th>
                        <th class="px-4 py-3">Debitur / No Loan</th>
                        <th class="px-4 py-3">Cabang</th>
                        <th class="px-4 py-3">Estimasi Harga</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($asets as $i => $aset)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">{{ $asets->firstItem() + $i }}</td>
                            <td class="px-4 py-3"><img src="{{ $aset->gambar_url }}" class="h-12 w-16 rounded-lg object-cover" alt=""></td>
                            <td class="px-4 py-3">
                                <p class="font-semibold">{{ $aset->nama }}</p>
                                <p class="text-xs text-slate-500">{{ $aset->jenis }} &middot; {{ $aset->kota }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p>{{ $aset->debitur->nama ?? '-' }}</p>
                                <p class="font-mono text-xs text-slate-500">{{ $aset->debitur->no_loan ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3">{{ $aset->debitur->cabang_pengelola ?? '-' }}</td>
                            <td class="px-4 py-3 font-bold text-teal-700">Rp {{ number_format($aset->harga_estimasi, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.booklet.show', $aset) }}" target="_blank"
                                   class="rounded-lg bg-teal-700 px-3 py-1.5 text-xs font-bold text-white">Buka Booklet</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-slate-500">Belum ada aset siap cetak.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $asets->links() }}</div>
    </section>
@endsection
