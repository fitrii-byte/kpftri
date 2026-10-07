@extends('layouts.admin')
@section('title', 'Master Data Inti')

@section('content')
    <section class="rounded-2xl border border-slate-200 bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 p-5">
            <div>
                <h2 class="text-base font-extrabold">Data Portofolio Nasabah</h2>
                <p class="text-sm text-slate-500">Database portofolio pembiayaan NPF &amp; Non NPF.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <form action="{{ route('admin.master.index') }}" class="flex gap-2">
                    <input name="q" value="{{ $q }}" placeholder="Cari nasabah, no loan, cabang..." class="rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    <select name="status" class="rounded-xl border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Semua</option>
                        <option value="npf" @selected($status === 'npf')>NPF</option>
                        <option value="non-npf" @selected($status === 'non-npf')>Non NPF</option>
                    </select>
                    <button class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-bold text-white">Cari</button>
                </form>
                <a href="{{ route('admin.master.create') }}" class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-bold text-white">+ Tambah Data</a>
                <a href="{{ route('admin.master.export') }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-bold text-white">Save ZIP Portofolio</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-bold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">CIF &amp; Nama Nasabah</th>
                        <th class="px-4 py-3">No Loan</th>
                        <th class="px-4 py-3">Segmen &amp; Produk</th>
                        <th class="px-4 py-3">Cabang Pengelola</th>
                        <th class="px-4 py-3">Kolektibilitas</th>
                        <th class="px-4 py-3">OS Pokok</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($debiturs as $i => $d)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">{{ $debiturs->firstItem() + $i }}</td>
                            <td class="px-4 py-3">
                                <p class="font-semibold">{{ $d->nama }}</p>
                                <p class="font-mono text-xs text-slate-500">CIF {{ $d->cif }}</p>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $d->no_loan }}</td>
                            <td class="px-4 py-3">
                                <p>{{ $d->segmen }}</p>
                                <p class="text-xs text-slate-500">{{ $d->produk }}</p>
                            </td>
                            <td class="px-4 py-3">{{ $d->cabang_pengelola }}</td>
                            <td class="px-4 py-3">
                                <span class="whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold {{ $d->is_npf ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-700' }}">
                                    Kol {{ $d->kolektibilitas }} &middot; {{ $d->is_npf ? 'NPF' : 'Non NPF' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-bold">Rp {{ number_format($d->os_pokok, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-nowrap items-center gap-1">
                                    <a href="{{ route('admin.master.show', $d) }}" title="Lihat"
                                       class="flex items-center gap-1 whitespace-nowrap rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-bold text-slate-700">👁️ Lihat</a>
                                    <a href="{{ route('admin.master.edit', $d) }}" title="Edit"
                                       class="flex items-center gap-1 whitespace-nowrap rounded-lg bg-teal-50 px-2.5 py-1.5 text-xs font-bold text-teal-700">✏️ Edit</a>
                                    <form method="POST" action="{{ route('admin.master.destroy', $d) }}" onsubmit="return confirm('Hapus data debitur ini?')">
                                        @csrf @method('DELETE')
                                        <button title="Hapus"
                                                class="flex items-center gap-1 whitespace-nowrap rounded-lg bg-red-50 px-2.5 py-1.5 text-xs font-bold text-red-600">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-8 text-center text-slate-500">Belum ada data portofolio.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $debiturs->links() }}</div>
    </section>
@endsection