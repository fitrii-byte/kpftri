@extends('layouts.user')
@section('title', $aset->nama)

@section('content')
    <a href="{{ route('katalog') }}" class="text-sm font-semibold text-teal-700">&larr; Kembali ke katalog</a>

    <div class="mt-4 grid gap-6 lg:grid-cols-[1.3fr_1fr]">
        <div>
            <img src="{{ $aset->gambar_url }}" alt="{{ $aset->nama }}" class="w-full rounded-3xl object-cover" style="max-height:420px">
            <div class="mt-3 flex flex-wrap items-center gap-2">
                <form method="POST" action="{{ route('katalog.like', $aset) }}">
                    @csrf
                    <button class="flex items-center gap-2 rounded-xl border px-4 py-2.5 text-sm font-bold {{ $liked ? 'border-rose-200 bg-rose-50 text-rose-600' : 'border-slate-200 text-slate-600' }}">
                        {{ $liked ? '♥ Disukai' : '♡ Suka' }} <span class="text-xs">({{ $aset->likes_count }})</span>
                    </button>
                </form>
                <button type="button" onclick="bagikanFoto()" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-600">Bagikan foto</button>
                <a href="https://wa.me/62812xxxxxxxx?text={{ urlencode($aset->nama.' - '.route('katalog.show', $aset)) }}" target="_blank" class="rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white">Kirim via WhatsApp</a>
                <a href="{{ $aset->gambar_url }}" download class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-600">Unduh foto</a>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6">
            <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-bold text-teal-700">{{ $aset->jenis }}</span>
            <h1 class="mt-3 text-2xl font-extrabold">{{ $aset->nama }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $aset->alamat }}, {{ $aset->kota }}</p>
            <p class="mt-4 text-xs font-semibold uppercase tracking-wide text-slate-400">Estimasi harga</p>
            <p class="text-2xl font-extrabold text-teal-700">Rp {{ number_format($aset->harga_estimasi, 0, ',', '.') }}</p>
            
            <p class="mt-1 text-xs text-slate-400">Kode aset: {{ $aset->kode }}</p>

            <h2 class="mt-6 text-sm font-extrabold">Spesifikasi teknis</h2>
            <dl class="mt-2 grid grid-cols-2 gap-3 text-sm">
                <div><dt class="text-xs text-slate-500">Luas tanah</dt><dd class="font-bold">{{ $aset->luas_tanah }} m²</dd></div>
                <div><dt class="text-xs text-slate-500">Luas bangunan</dt><dd class="font-bold">{{ $aset->luas_bangunan }} m²</dd></div>
            </dl>
            <p class="mt-3 whitespace-pre-line text-sm text-slate-600">{{ $aset->spesifikasi }}</p>

            <h2 class="mt-6 text-sm font-extrabold">Legalitas</h2>
            <p class="mt-1 text-sm font-bold text-slate-700">{{ $aset->sertifikat }}</p>
            <p class="mt-1 whitespace-pre-line text-sm text-slate-600">{{ $aset->legalitas }}</p>

            @if ($aset->debitur)
                <p class="mt-6 text-xs text-slate-400">Cabang pengelola: {{ $aset->debitur->cabang_pengelola }}</p>
            @endif
        </div>
    </div>

    @if ($serupa->count())
        <h2 class="mt-10 text-lg font-extrabold">Aset {{ $aset->jenis }} lainnya</h2>
        <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($serupa as $item)
                <a href="{{ route('katalog.show', $item) }}" class="overflow-hidden rounded-2xl border border-slate-200 bg-white hover:shadow-lg">
                    <img src="{{ $item->gambar_url }}" alt="{{ $item->nama }}" class="h-40 w-full object-cover" loading="lazy">
                    <div class="p-4">
                        <h3 class="font-bold">{{ $item->nama }}</h3>
                        <p class="text-xs text-slate-500">{{ $item->kota }}</p>
                        <p class="mt-1 font-extrabold text-teal-700">Rp {{ number_format($item->harga_estimasi, 0, ',', '.') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

    <script>
        async function bagikanFoto() {
            const url = @js(route('katalog.show', $aset));
            const gambar = @js($aset->gambar_url);
            const judul = @js($aset->nama);
            if (navigator.share) {
                try {
                    const res = await fetch(gambar);
                    const blob = await res.blob();
                    const file = new File([blob], 'aset.jpg', { type: blob.type });
                    if (navigator.canShare && navigator.canShare({ files: [file] })) {
                        await navigator.share({ files: [file], title: judul, text: judul + ' - ' + url });
                        return;
                    }
                    await navigator.share({ title: judul, text: judul, url: url });
                    return;
                } catch (e) {}
            }
            try { await navigator.clipboard.writeText(url); alert('Tautan aset disalin: ' + url); }
            catch (e) { prompt('Salin tautan berikut:', url); }
        }
    </script>
@endsection
