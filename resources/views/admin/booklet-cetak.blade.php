<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Booklet {{ $aset->kode }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body class="bg-slate-100 p-6">
<div class="no-print mx-auto mb-4 flex max-w-3xl justify-end gap-2">
    <button onclick="window.print()" class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-bold text-white">Cetak / Simpan PDF</button>
</div>

<article class="mx-auto max-w-3xl bg-white p-8 shadow">
    <header class="flex items-center justify-between border-b-4 border-teal-700 pb-4">
        <div>
            <p class="text-xl font-extrabold text-teal-800">BSI Aset</p>
            <p class="text-xs text-slate-500">Booklet Promosi Aset Agunan</p>
        </div>
        <p class="font-mono text-xs text-slate-500">{{ $aset->kode }}</p>
    </header>

    <img src="{{ $aset->gambar_url }}" alt="{{ $aset->nama }}" class="mt-5 h-72 w-full rounded-2xl object-cover">

    <h1 class="mt-5 text-2xl font-extrabold">{{ $aset->nama }}</h1>
    <p class="text-sm text-slate-600">{{ $aset->alamat }}, {{ $aset->kota }}</p>
    <p class="mt-3 text-2xl font-extrabold text-teal-700">Rp {{ number_format($aset->harga_estimasi, 0, ',', '.') }}</p>

    <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <div>
            <h2 class="text-sm font-extrabold uppercase tracking-wide text-slate-500">Spesifikasi Teknis</h2>
            <ul class="mt-2 space-y-1 text-sm">
                <li>Jenis aset: <b>{{ $aset->jenis }}</b></li>
                <li>Luas tanah: <b>{{ $aset->luas_tanah }} m²</b></li>
                <li>Luas bangunan: <b>{{ $aset->luas_bangunan }} m²</b></li>
            </ul>
            <p class="mt-2 whitespace-pre-line text-sm text-slate-600">{{ $aset->spesifikasi }}</p>
        </div>
        <div>
            <h2 class="text-sm font-extrabold uppercase tracking-wide text-slate-500">Legalitas</h2>
            <p class="mt-2 text-sm">Sertifikat: <b>{{ $aset->sertifikat }}</b></p>
            <p class="mt-1 whitespace-pre-line text-sm text-slate-600">{{ $aset->legalitas }}</p>
            @if ($aset->debitur)
                <h2 class="mt-4 text-sm font-extrabold uppercase tracking-wide text-slate-500">Data Pengelola</h2>
                <p class="mt-1 text-sm">Cabang: <b>{{ $aset->debitur->cabang_pengelola }}</b></p>
                <p class="text-sm">No loan: <b>{{ $aset->debitur->no_loan }}</b></p>
            @endif
        </div>
    </div>

    <footer class="mt-8 border-t border-slate-200 pt-4 text-xs text-slate-500">
        Dicetak {{ now()->format('d/m/Y H:i') }} — harga bersifat indikatif dan dapat berubah.
    </footer>
</article>
</body>
</html