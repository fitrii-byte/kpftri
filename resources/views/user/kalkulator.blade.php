@extends('layouts.admin')
@section('title', 'Kalkulator Biaya Lelang')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h1 class="text-xl font-extrabold text-slate-800">Kalkulator Biaya Lelang</h1>
        <p class="mt-1 text-sm text-slate-500">Perkiraan biaya yang perlu disiapkan pembeli sebelum mengikuti lelang. Hasil ini perkiraan, bukan angka final — biaya resmi mengikuti ketentuan KPKNL/Ditjen Pajak saat lelang berlangsung.</p>

        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6">
            <h2 class="text-sm font-extrabold text-slate-800">1. Data Lelang</h2>
            <div class="mt-3 grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-xs font-bold text-slate-500">Harga/Nilai Lelang (Rp)</label>
                    <input type="number" id="hargaLelang" value="{{ $hargaAwal ?: '' }}" placeholder="0"
                           class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500">NJOP (Rp)</label>
                    <input type="number" id="njop" placeholder="0"
                           class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    <p class="mt-1 text-[11px] text-slate-400">BPHTB dihitung dari nilai yang lebih tinggi antara Harga Lelang dan NJOP.</p>
                </div>
            </div>

            <h2 class="mt-6 text-sm font-extrabold text-slate-800">2. Biaya Tambahan (opsional, bervariasi)</h2>
            <div class="mt-3 grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="text-xs font-bold text-slate-500">Biaya Iklan Koran (Rp)</label>
                    <input type="number" id="biayaKoran" placeholder="0"
                           class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    <p class="mt-1 text-[11px] text-slate-400">Tergantung media (Tribun, Pikiran Rakyat, dll). Isi sesuai info KPKNL/cabang.</p>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-500">Biaya KJPP / Appraisal (Rp)</label>
                    <input type="number" id="biayaKjpp" placeholder="0"
                           class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    <p class="mt-1 text-[11px] text-slate-400">Tergantung KJPP dan lokasi aset.</p>
                </div>
            </div>

            <label class="mt-4 flex items-center gap-2 text-sm">
                <input type="checkbox" id="pajakLunas">
                Pajak PBB sudah lunas 5 tahun ke belakang
            </label>
            <p id="warnPajak" class="mt-1 hidden text-xs font-semibold text-red-600">
                ⚠️ BPHTB baru bisa dibayar setelah PBB lunas 5 tahun ke belakang. Lunasi dulu tunggakan PBB sebelum proses BPHTB.
            </p>

            <button type="button" onclick="hitung()" class="mt-6 w-full rounded-xl bg-teal-700 py-3 text-sm font-bold text-white hover:bg-teal-800">
                Hitung Estimasi Biaya
            </button>
        </div>

        <div id="hasil" class="mt-6 hidden rounded-2xl border border-teal-200 bg-teal-50 p-6">
            <h2 class="text-sm font-extrabold text-teal-900">Estimasi Biaya Pembeli</h2>
            <dl class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-slate-600">Dasar pengenaan BPHTB</dt><dd id="outDasar" class="font-bold">-</dd></div>
                <div class="flex justify-between"><dt class="text-slate-600">BPHTB (5%)</dt><dd id="outBphtb" class="font-bold">-</dd></div>
                <div class="flex justify-between"><dt class="text-slate-600">Biaya Pendaftaran Lelang</dt><dd class="font-bold">Rp 150.000</dd></div>
                <div class="flex justify-between"><dt class="text-slate-600">Biaya Iklan Koran</dt><dd id="outKoran" class="font-bold">-</dd></div>
                <div class="flex justify-between"><dt class="text-slate-600">Biaya KJPP</dt><dd id="outKjpp" class="font-bold">-</dd></div>
                <div class="mt-2 flex justify-between border-t border-teal-200 pt-2 text-base">
                    <dt class="font-extrabold text-teal-900">Total Estimasi</dt>
                    <dd id="outTotal" class="font-extrabold text-teal-900">-</dd>
                </div>
            </dl>
        </div>

        <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-900">
            <h3 class="font-extrabold">Catatan Biaya Lain (ditanggung nasabah/debitur, bukan pembeli)</h3>
            <ul class="mt-2 list-inside list-disc space-y-1">
                <li>Biaya pembatalan lelang: Rp 250.000</li>
                <li>Biaya KJPP dan koran bisa dibebankan ke nasabah tergantung kebijakan cabang</li>
            </ul>
        </div>
    </div>

    <script>
        function rupiah(angka) {
            return 'Rp ' + Math.round(angka).toLocaleString('id-ID');
        }

        function hitung() {
            const harga = parseFloat(document.getElementById('hargaLelang').value) || 0;
            const njop = parseFloat(document.getElementById('njop').value) || 0;
            const koran = parseFloat(document.getElementById('biayaKoran').value) || 0;
            const kjpp = parseFloat(document.getElementById('biayaKjpp').value) || 0;
            const pendaftaran = 150000;

            const dasar = Math.max(harga, njop);
            const bphtb = dasar * 0.05;
            const total = bphtb + pendaftaran + koran + kjpp;

            document.getElementById('outDasar').textContent = rupiah(dasar);
            document.getElementById('outBphtb').textContent = rupiah(bphtb);
            document.getElementById('outKoran').textContent = rupiah(koran);
            document.getElementById('outKjpp').textContent = rupiah(kjpp);
            document.getElementById('outTotal').textContent = rupiah(total);
            document.getElementById('hasil').classList.remove('hidden');

            document.getElementById('warnPajak').classList.toggle('hidden', document.getElementById('pajakLunas').checked);
        }

        @if ($hargaAwal)
            hitung();
        @endif
    </script>
@endsection