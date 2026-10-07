<article class="overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:shadow-lg">
    <a href="{{ route('katalog.show', $aset) }}">
        <img src="{{ $aset->gambar_url }}" alt="{{ $aset->nama }}" class="h-44 w-full object-cover" loading="lazy">
    </a>
    <div class="p-4">
        <span class="rounded-full bg-teal-50 px-2.5 py-1 text-[11px] font-bold text-teal-700">{{ $aset->jenis }}</span>
        <a href="{{ route('katalog.show', $aset) }}" class="mt-2 block font-bold hover:text-teal-700">{{ $aset->nama }}</a>
        <p class="text-xs text-slate-500">{{ $aset->alamat }}, {{ $aset->kota }}</p>
        <p class="mt-1 text-xs text-slate-500">LT {{ $aset->luas_tanah }} m² &middot; LB {{ $aset->luas_bangunan }} m² &middot; {{ $aset->sertifikat }}</p>
        <p class="mt-2 font-extrabold text-teal-700">Rp {{ number_format($aset->harga_estimasi, 0, ',', '.') }}</p>

        <div class="mt-3 flex items-center gap-2">
            <form method="POST" action="{{ route('katalog.like', $aset) }}">
                @csrf
                <button class="flex items-center gap-1.5 rounded-xl border px-3 py-2 text-xs font-bold {{ $liked ? 'border-rose-200 bg-rose-50 text-rose-600' : 'border-slate-200 text-slate-600' }}">
                    {{ $liked ? '♥' : '♡' }} <span>{{ $aset->likes_count }}</span>
                </button>
            </form>
            <button type="button"
                    onclick="bagikanAset('{{ route('katalog.show', $aset) }}', @js($aset->nama))"
                    class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-bold text-slate-600">Bagikan</button>
            <a href="https://wa.me/6283179597455?text={{ urlencode($aset->nama.' - '.route('katalog.show', $aset)) }}" target="_blank"
               class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-bold text-white">WhatsApp</a>
        </div>
    </div>
</article>

@once
    @push('scripts')@endpush
    <script>
        async function bagikanAset(url, judul) {
            if (navigator.share) {
                try { await navigator.share({ title: judul, text: judul, url: url }); return; } catch (e) {}
            }
            try { await navigator.clipboard.writeText(url); alert('Tautan aset disalin: ' + url); }
            catch (e) { prompt('Salin tautan berikut:', url); }
        }
    </script>
@endonce
