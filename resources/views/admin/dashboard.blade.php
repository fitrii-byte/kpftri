@extends('layouts.admin')
@section('title', 'Dashboard Lelang')

@section('content')
    @php
        $warnaJenis = [
            'Rumah' => 'bg-indigo-50 text-indigo-700',
            'Tanah' => 'bg-lime-50 text-lime-700',
            'Ruko' => 'bg-amber-50 text-amber-700',
            'Gudang' => 'bg-slate-100 text-slate-700',
            'Apartemen' => 'bg-sky-50 text-sky-700',
            'Pabrik' => 'bg-orange-50 text-orange-700',
            'Kendaraan' => 'bg-teal-50 text-teal-700',
        ];
        $cards = [
            ['total_aset', 'Total Aset Terdaftar', number_format($stats['total_aset'], 0, ',', '.').' aset'],
            ['total_debitur', 'Total Debitur Terdaftar', number_format($stats['total_debitur'], 0, ',', '.').' debitur'],
            ['nilai_market', 'Akumulasi Nilai Market Aset', 'Rp '.number_format($stats['nilai_market'], 0, ',', '.')],
            ['total_npf', 'Debitur NPF', number_format($stats['total_npf'], 0, ',', '.').' debitur'],
        ];
    @endphp

    {{-- Kartu statistik ala dashboard properti --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($cards as [$key, $label, $value])
            <div class="rounded-2xl border border-slate-200 bg-white p-5">
                <p class="text-xs font-semibold text-slate-400">{{ $label }}</p>
                <div class="mt-2 flex items-end justify-between gap-2">
                    <p class="text-xl font-extrabold text-slate-900">{{ $value }}</p>
                    @if ($trends[$key])
                        <span class="flex items-center gap-0.5 whitespace-nowrap rounded-full px-2 py-0.5 text-[11px] font-bold {{ $trends[$key]['up'] ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                            {{ $trends[$key]['up'] ? '▲' : '▼' }} {{ $trends[$key]['pct'] }}%
                        </span>
                    @endif
                </div>
                <p class="mt-1 text-[11px] text-slate-400">dibanding bulan lalu</p>
            </div>
        @endforeach
    </div>

    {{-- Grafik tren + aset favorit --}}
    <div class="mt-4 grid gap-4 lg:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-slate-800">Tren Aset Ditambahkan</h3>
                <span class="text-xs text-slate-400">6 bulan terakhir</span>
            </div>
            <canvas id="chartAset" height="90" class="mt-2"></canvas>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-extrabold text-slate-800">Aset Favorit</h3>
                @if ($topAset)
                    <a href="{{ route('katalog.show', $topAset) }}" target="_blank" class="text-xs font-bold text-teal-700">Lihat</a>
                @endif
            </div>
            @if ($topAset)
                <img src="{{ $topAset->gambar_url }}" alt="{{ $topAset->nama }}" class="mt-3 h-28 w-full rounded-xl object-cover">
                <p class="mt-3 text-sm font-extrabold text-slate-800">{{ $topAset->nama }}</p>
                <p class="text-xs text-slate-500">📍 {{ $topAset->kota }}</p>
                <div class="mt-2 flex items-center justify-between">
                    <span class="text-sm font-extrabold text-teal-700">Rp {{ number_format($topAset->harga_estimasi, 0, ',', '.') }}</span>
                    <span class="flex items-center gap-1 text-xs font-bold text-rose-500">♥ {{ $topAset->likes_count }}</span>
                </div>
            @else
                <p class="mt-4 text-sm text-slate-400">Belum ada data aset.</p>
            @endif
        </div>
    </div>

    {{-- Tabel data aset (nama halaman & judul tetap sama) --}}
    <section class="mt-4 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 bg-slate-900 px-5 py-4">
            <div>
                <h2 class="text-base font-extrabold text-white">Manajemen Data Aset Agunan</h2>
                <p class="text-xs text-slate-300">Tambah, ubah, dan hapus data aset agunan.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <form action="{{ route('admin.dashboard') }}" class="flex gap-2">
                    <input name="q" value="{{ $q }}" placeholder="Cari nama / CIF / kota..."
                           class="rounded-xl border-0 bg-white/10 px-3 py-2 text-sm text-white placeholder-slate-400 focus:bg-white focus:text-slate-800">
                    <select name="jenis" class="rounded-xl border-0 bg-white/10 px-3 py-2 text-sm text-white [&>option]:text-slate-800">
                        <option value="">Semua Jenis</option>
                        @foreach (\App\Http\Controllers\Admin\AsetAdminController::JENIS as $j)
                            <option value="{{ $j }}" @selected($jenis === $j)>{{ $j }}</option>
                        @endforeach
                    </select>
                    <button class="rounded-xl bg-amber-500 px-4 py-2 text-sm font-bold text-slate-900 hover:bg-amber-400">Cari</button>
                </form>
                <a href="{{ route('admin.aset.create') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-bold text-slate-900 hover:bg-slate-100">+ Tambah Aset</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-fixed text-sm">
                <colgroup>
                    <col style="width:4%">
                    <col style="width:10%">
                    <col style="width:9%">
                    <col style="width:19%">
                    <col style="width:10%">
                    <col style="width:15%">
                    <col style="width:17%">
                    <col style="width:16%">
                </colgroup>
                <thead class="bg-slate-100 text-left text-[11px] font-bold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-4 py-3.5">No</th>
                        <th class="px-4 py-3.5">CIF</th>
                        <th class="px-4 py-3.5">Jenis</th>
                        <th class="px-4 py-3.5">Nama Aset</th>
                        <th class="px-4 py-3.5">Lokasi</th>
                        <th class="px-4 py-3.5">Debitur</th>
                        <th class="px-4 py-3.5">Estimasi Harga</th>
                        <th class="px-4 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($asets as $i => $aset)
                        <tr class="border-b border-slate-100 odd:bg-white even:bg-slate-50/70 hover:bg-amber-50/60">
                            <td class="px-4 py-3.5 align-top text-slate-400">{{ $asets->firstItem() + $i }}</td>
                            <td class="px-4 py-3.5 align-top font-mono text-xs text-slate-600">{{ $aset->debitur->cif ?? '-' }}</td>
                            <td class="px-4 py-3.5 align-top">
                                <span class="inline-block whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold {{ $warnaJenis[$aset->jenis] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $aset->jenis }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 align-top">
                                <p class="font-semibold leading-snug text-slate-800">{{ $aset->nama }}</p>
                                <p class="mt-0.5 font-mono text-[11px] text-slate-400">{{ $aset->kode }}</p>
                            </td>
                            <td class="px-4 py-3.5 align-top whitespace-nowrap font-extrabold text-emerald-700">📍 {{ $aset->kota }}</td>
                            <td class="px-4 py-3.5 align-top">
                                @if ($aset->debitur)
                                    <div class="flex items-center gap-2">
                                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-[11px] font-bold text-indigo-700">
                                            {{ strtoupper(substr($aset->debitur->nama, 0, 1)) }}
                                        </span>
                                        <span class="truncate text-slate-700">{{ $aset->debitur->nama }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 align-top whitespace-nowrap font-extrabold text-emerald-700">Rp {{ number_format($aset->harga_estimasi, 0, ',', '.') }}</td>
                            <td class="px-4 py-3.5 align-top">
                                <div class="flex flex-nowrap items-center justify-center gap-1.5">
                                    <a href="{{ route('katalog.show', $aset) }}" target="_blank" title="Lihat"
                                       class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-sm hover:bg-slate-200">👁️</a>
                                    <a href="{{ route('admin.aset.edit', $aset) }}" title="Ubah"
                                       class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-sm hover:bg-indigo-200">✏️</a>
                                    <form method="POST" action="{{ route('admin.aset.destroy', $aset) }}" onsubmit="return confirm('Hapus aset ini?')">
                                        @csrf @method('DELETE')
                                        <button title="Hapus" class="flex h-8 w-8 items-center justify-center rounded-full bg-rose-100 text-sm hover:bg-rose-200">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-10 text-center text-slate-400">Belum ada data aset.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 p-4">{{ $asets->links() }}</div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('chartAset'), {
            type: 'line',
            data: {
                labels: @json($chart['labels']),
                datasets: [{
                    label: 'Aset baru',
                    data: @json($chart['values']),
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30,58,138,0.08)',
                    tension: 0.35,
                    fill: true,
                    pointBackgroundColor: '#1e3a8a',
                    pointRadius: 4,
                }],
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } },
                    x: { grid: { display: false } },
                },
            },
        });
    </script>
@endsection