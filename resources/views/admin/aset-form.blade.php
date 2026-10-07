@extends('layouts.admin')
@section('title', $aset->exists ? 'Ubah Data Aset' : 'Tambah Data Aset')

@section('content')
    <form method="POST" enctype="multipart/form-data"
          action="{{ $aset->exists ? route('admin.aset.update', $aset) : route('admin.aset.store') }}"
          class="max-w-3xl rounded-2xl border border-slate-200 bg-white p-6">
        @csrf
        @if ($aset->exists) @method('PUT') @endif

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="block text-sm font-semibold">Kode aset</label>
                <input name="kode" value="{{ old('kode', $aset->kode) }}" required class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold">Jenis aset</label>
                <select name="jenis" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    @foreach ($jenisList as $j)
                        <option value="{{ $j }}" @selected(old('jenis', $aset->jenis) === $j)>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold">Nama aset</label>
                <input name="nama" value="{{ old('nama', $aset->nama) }}" required class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold">Alamat</label>
                <input name="alamat" value="{{ old('alamat', $aset->alamat) }}" required class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold">Kota</label>
                <input name="kota" value="{{ old('kota', $aset->kota) }}" required class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold">Debitur</label>
                <select name="debitur_id" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                    <option value="">— tidak dikaitkan —</option>
                    @foreach ($debiturs as $d)
                        <option value="{{ $d->id }}" @selected((int) old('debitur_id', $aset->debitur_id) === $d->id)>{{ $d->nama }} ({{ $d->no_loan }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold">Luas tanah (m²)</label>
                <input type="number" name="luas_tanah" value="{{ old('luas_tanah', $aset->luas_tanah ?? 0) }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold">Luas bangunan (m²)</label>
                <input type="number" name="luas_bangunan" value="{{ old('luas_bangunan', $aset->luas_bangunan ?? 0) }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold">Jenis sertifikat</label>
                <input name="sertifikat" value="{{ old('sertifikat', $aset->sertifikat) }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold">Estimasi harga (Rp)</label>
                <input type="number" step="0.01" name="harga_estimasi" value="{{ old('harga_estimasi', $aset->harga_estimasi ?? 0) }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold">Spesifikasi teknis</label>
                <textarea name="spesifikasi" rows="4" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">{{ old('spesifikasi', $aset->spesifikasi) }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold">Legalitas</label>
                <textarea name="legalitas" rows="3" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">{{ old('legalitas', $aset->legalitas) }}</textarea>
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-semibold">Foto aset</label>
                <input type="file" name="gambar_file" accept="image/*" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                @if ($aset->gambar)
                    <img src="{{ asset($aset->gambar) }}" class="mt-2 h-28 rounded-xl object-cover" alt="foto aset">
                @endif
            </div>
            <label class="flex items-center gap-2 text-sm sm:col-span-2">
                <input type="checkbox" name="booklet_ready" value="1" @checked(old('booklet_ready', $aset->booklet_ready ?? true))>
                Tampilkan pada daftar Booklet Aset
            </label>
        </div>

        <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5">
            <h3 class="text-sm font-extrabold text-slate-800">Kalkulator Biaya Lelang (hanya admin)</h3>
            <p class="mt-1 text-xs text-slate-500">Isi data ini supaya pembeli bisa lihat rincian estimasi biaya di halaman detail aset. Kalau NJOP dikosongkan, rincian tidak akan ditampilkan ke user.</p>

            <div class="mt-4 grid gap-4 sm:grid-cols-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500">NJOP (Rp)</label>
                    <input type="number" step="0.01" id="njop" name="njop" value="{{ old('njop', $aset->njop) }}"
                           class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500">Biaya Iklan Koran (Rp)</label>
                    <input type="number" step="0.01" id="biaya_koran" name="biaya_koran" value="{{ old('biaya_koran', $aset->biaya_koran) }}"
                           class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500">Biaya KJPP (Rp)</label>
                    <input type="number" step="0.01" id="biaya_kjpp" name="biaya_kjpp" value="{{ old('biaya_kjpp', $aset->biaya_kjpp) }}"
                           class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>
            </div>

            <label class="mt-3 flex items-center gap-2 text-sm">
                <input type="checkbox" name="pajak_lunas" value="1" @checked(old('pajak_lunas', $aset->pajak_lunas ?? false))>
                Pajak PBB sudah lunas 5 tahun ke belakang
            </label>

            <div class="mt-4 rounded-xl border border-teal-200 bg-white p-4 text-sm">
                <p class="text-xs font-bold uppercase tracking-wide text-teal-700">Pratinjau Rincian untuk Pembeli</p>
                <dl class="mt-2 space-y-1">
                    <div class="flex justify-between"><dt class="text-slate-500">Dasar pengenaan BPHTB</dt><dd id="pvDasar" class="font-bold">-</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">BPHTB (5%)</dt><dd id="pvBphtb" class="font-bold">-</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Biaya Pendaftaran Lelang</dt><dd class="font-bold">Rp 150.000</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Biaya Koran</dt><dd id="pvKoran" class="font-bold">-</dd></div>
                    <div class="flex justify-between"><dt class="text-slate-500">Biaya KJPP</dt><dd id="pvKjpp" class="font-bold">-</dd></div>
                    <div class="flex justify-between border-t border-slate-200 pt-1 text-teal-700"><dt class="font-extrabold">Total Estimasi</dt><dd id="pvTotal" class="font-extrabold">-</dd></div>
                </dl>
            </div>
        </div>

        <div class="mt-6 flex gap-2">
            <button class="rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white">Simpan</button>
            <a href="{{ route('admin.dashboard') }}" class="rounded-xl bg-slate-100 px-5 py-2.5 text-sm font-bold">Batal</a>
        </div>
    </form>

    <script>
        function rupiahAdmin(n) { return 'Rp ' + Math.round(n || 0).toLocaleString('id-ID'); }

        function pratinjauBiaya() {
            const harga = parseFloat(document.querySelector('input[name="harga_estimasi"]').value) || 0;
            const njop = parseFloat(document.getElementById('njop').value) || 0;
            const koran = parseFloat(document.getElementById('biaya_koran').value) || 0;
            const kjpp = parseFloat(document.getElementById('biaya_kjpp').value) || 0;
            const pendaftaran = 150000;

            const dasar = Math.max(harga, njop);
            const bphtb = dasar * 0.05;
            const total = bphtb + pendaftaran + koran + kjpp;

            document.getElementById('pvDasar').textContent = rupiahAdmin(dasar);
            document.getElementById('pvBphtb').textContent = rupiahAdmin(bphtb);
            document.getElementById('pvKoran').textContent = rupiahAdmin(koran);
            document.getElementById('pvKjpp').textContent = rupiahAdmin(kjpp);
            document.getElementById('pvTotal').textContent = rupiahAdmin(total);
        }

        document.querySelector('input[name="harga_estimasi"]').addEventListener('input', pratinjauBiaya);
        document.getElementById('njop').addEventListener('input', pratinjauBiaya);
        document.getElementById('biaya_koran').addEventListener('input', pratinjauBiaya);
        document.getElementById('biaya_kjpp').addEventListener('input', pratinjauBiaya);
        pratinjauBiaya();
    </script>
@endsection