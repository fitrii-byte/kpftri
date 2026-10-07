@extends('layouts.user')
@section('title', 'Beranda')

@section('content')
    <section class="overflow-hidden rounded-3xl bg-gradient-to-br from-teal-800 to-emerald-700 px-6 py-10 text-white sm:px-10">
        <h1 class="max-w-2xl text-3xl font-extrabold leading-tight sm:text-4xl">Cari aset agunan BSI: tanah, rumah, ruko, gudang.</h1>
        <p class="mt-3 max-w-xl text-sm text-white/80">Lihat foto, spesifikasi teknis, legalitas, dan estimasi harga setiap aset.</p>
        <form action="{{ route('katalog') }}" class="mt-6 flex max-w-xl flex-col gap-2 sm:flex-row">
            <input name="q" placeholder="Cari aset, kota, atau jenis..." class="w-full rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none">
            <button class="rounded-xl bg-white px-6 py-3 text-sm font-bold text-teal-800">Cari Aset</button>
        </form>
        <div class="mt-4 flex flex-wrap gap-2">
            @foreach ($kategori as $k)
                <a href="{{ route('katalog', ['jenis' => $k]) }}" class="rounded-full border border-white/40 px-4 py-1.5 text-xs font-semibold hover:bg-white/10">{{ $k }}</a>
            @endforeach
        </div>
    </section>

    <section class="mt-8 rounded-3xl border border-slate-200 bg-white p-6 sm:p-8">
        <h2 class="text-xl font-extrabold text-slate-900">Cek Kemampuan KPR Anda</h2>
        <p class="mt-1 text-sm text-slate-500">Cari tahu kisaran harga properti yang sesuai dengan budget Anda.</p>
        <div class="mt-4 border-t border-teal-700"></div>

        <div class="mt-6 grid gap-6 sm:grid-cols-2">
            <div>
                <label class="text-sm font-semibold text-slate-700">Berapa penghasilan bersih kamu per bulan? <span class="text-red-500">*</span></label>
                <div class="mt-2 flex items-center gap-2 rounded-xl border border-slate-300 px-3 py-2.5">
                    <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-bold text-slate-500">Rp</span>
                    <input type="text" id="penghasilanTxt" value="5.000.000" class="w-full text-sm font-semibold text-slate-800 focus:outline-none">
                </div>
                <input type="range" id="penghasilanRange" min="1000000" max="100000000" step="500000" value="5000000" class="mt-3 w-full accent-teal-700">
                <div class="mt-1 flex justify-between text-[11px] text-slate-400"><span>1 Jt</span><span>100 Jt</span></div>
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Berapa DP yang disiapkan? <span class="text-red-500">*</span></label>
                <div class="mt-2 flex items-center gap-2 rounded-xl border border-slate-300 px-3 py-2.5">
                    <span class="rounded-md bg-slate-100 px-2 py-1 text-xs font-bold text-slate-500">Rp</span>
                    <input type="text" id="dpTxt" value="50.000.000" class="w-full text-sm font-semibold text-slate-800 focus:outline-none">
                </div>
                <input type="range" id="dpRange" min="0" max="1000000000" step="5000000" value="50000000" class="mt-3 w-full accent-teal-700">
                <div class="mt-1 flex justify-between text-[11px] text-slate-400"><span>0</span><span>1 M</span></div>
            </div>
        </div>

        <button type="button" onclick="simulasiKpr()" class="mt-6 w-full rounded-xl bg-teal-800 py-3.5 text-sm font-bold text-white hover:bg-teal-900">
            Coba Simulasi
        </button>

        <div id="hasilKpr" class="mt-6 hidden rounded-2xl border border-teal-200 bg-teal-50 p-5">
            <p class="text-xs font-bold uppercase tracking-wide text-teal-700">Estimasi Kemampuan KPR Anda</p>
            <div class="mt-3 grid gap-3 sm:grid-cols-3">
                <div>
                    <p class="text-xs text-slate-500">Estimasi Plafon KPR</p>
                    <p id="outPlafon" class="text-lg font-extrabold text-slate-900">-</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Cicilan per Bulan</p>
                    <p id="outCicilan" class="text-lg font-extrabold text-slate-900">-</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Perkiraan Harga Properti</p>
                    <p id="outHarga" class="text-lg font-extrabold text-teal-700">-</p>
                </div>
            </div>
            <p class="mt-3 text-[11px] text-slate-500">Simulasi memakai asumsi tenor 15 tahun &amp; bunga 9%/tahun. Angka ini perkiraan, bukan keputusan final — hasil sesungguhnya mengikuti penilaian bank.</p>
            <a id="linkKatalogBudget" href="{{ route('katalog') }}" class="mt-4 inline-block rounded-xl bg-teal-800 px-5 py-2.5 text-sm font-bold text-white hover:bg-teal-900">Lihat Aset Sesuai Budget →</a>
        </div>
    </section>

    <script>
        function formatRibuan(input) {
            let angka = input.value.replace(/\D/g, '');
            input.value = angka ? parseInt(angka).toLocaleString('id-ID') : '';
        }
        function angkaDari(teks) { return parseInt(teks.replace(/\D/g, '')) || 0; }

        const penghasilanRange = document.getElementById('penghasilanRange');
        const penghasilanTxt = document.getElementById('penghasilanTxt');
        const dpRange = document.getElementById('dpRange');
        const dpTxt = document.getElementById('dpTxt');

        penghasilanRange.addEventListener('input', () => { penghasilanTxt.value = parseInt(penghasilanRange.value).toLocaleString('id-ID'); });
        dpRange.addEventListener('input', () => { dpTxt.value = parseInt(dpRange.value).toLocaleString('id-ID'); });
        penghasilanTxt.addEventListener('input', function () { formatRibuan(this); penghasilanRange.value = angkaDari(this.value); });
        dpTxt.addEventListener('input', function () { formatRibuan(this); dpRange.value = angkaDari(this.value); });

        function rupiah(n) { return 'Rp ' + Math.round(n).toLocaleString('id-ID'); }

        function simulasiKpr() {
            const penghasilan = angkaDari(penghasilanTxt.value);
            const dp = angkaDari(dpTxt.value);

            const maxCicilan = penghasilan * 0.4; // rasio angsuran maksimal bank, umum 40% penghasilan
            const bungaTahun = 0.09;
            const tenorBulan = 15 * 12;
            const r = bungaTahun / 12;

            const plafon = maxCicilan * (1 - Math.pow(1 + r, -tenorBulan)) / r;
            const hargaProperti = plafon + dp;

            document.getElementById('outPlafon').textContent = rupiah(plafon);
            document.getElementById('outCicilan').textContent = rupiah(maxCicilan) + '/bln';
            document.getElementById('outHarga').textContent = rupiah(hargaProperti);
            document.getElementById('linkKatalogBudget').href = "{{ route('katalog') }}?harga_max=" + Math.round(hargaProperti);
            document.getElementById('hasilKpr').classList.remove('hidden');
        }
    </script>

    @if ($banners->count())
        <h2 class="mt-10 text-lg font-extrabold">Informasi &amp; Promo</h2>
        <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($banners as $b)
                <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                    @if ($b->gambar)
                        <img src="{{ asset($b->gambar) }}" alt="{{ $b->judul }}" class="h-40 w-full object-cover" loading="lazy">
                    @endif
                    <div class="p-4">
                        <h3 class="font-bold">{{ $b->judul }}</h3>
                        <p class="mt-1 text-sm text-slate-600">{{ $b->deskripsi }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    @endif

    <h2 class="mt-10 text-lg font-extrabold">Aset terbaru</h2>
    <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($terbaru as $aset)
            <a href="{{ route('katalog.show', $aset) }}" class="overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:shadow-lg">
                <img src="{{ $aset->gambar_url }}" alt="{{ $aset->nama }}" class="h-44 w-full object-cover" loading="lazy">
                <div class="p-4">
                    <span class="rounded-full bg-teal-50 px-2.5 py-1 text-[11px] font-bold text-teal-700">{{ $aset->jenis }}</span>
                    <h3 class="mt-2 font-bold">{{ $aset->nama }}</h3>
                    <p class="text-xs text-slate-500">{{ $aset->kota }}</p>
                    <p class="mt-2 font-extrabold text-teal-700">Rp {{ number_format($aset->harga_estimasi, 0, ',', '.') }}</p>
                </div>
            </a>
        @endforeach
    </div>
@endsection