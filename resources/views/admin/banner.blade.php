@extends('layouts.admin')
@section('title', 'Manajemen Banner')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[360px_1fr]">
        <form method="POST" action="{{ route('admin.banner.store') }}" enctype="multipart/form-data"
              class="rounded-2xl border border-slate-200 bg-white p-5">
            @csrf
            <h2 class="text-base font-extrabold">Upload Banner Baru</h2>
            <div class="mt-4 space-y-3">
                <div>
                    <label class="block text-sm font-semibold">Judul banner</label>
                    <input name="judul" value="{{ old('judul') }}" required class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">{{ old('deskripsi') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold">Link tujuan (opsional)</label>
                    <input name="link" value="{{ old('link') }}" placeholder="https://..." class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold">Gambar banner</label>
                    <input type="file" name="gambar_file" accept="image/*" required class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
                </div>
                <button class="w-full rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-bold text-white">Upload Banner</button>
            </div>
        </form>

        <section class="grid gap-4 sm:grid-cols-2">
            @forelse ($banners as $b)
                <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
                    @if ($b->gambar)
                        <img src="{{ asset($b->gambar) }}" alt="{{ $b->judul }}" class="h-40 w-full object-cover">
                    @endif
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-2">
                            <h3 class="font-bold">{{ $b->judul }}</h3>
                            <span class="rounded-full px-2 py-0.5 text-[11px] font-bold {{ $b->aktif ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $b->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <p class="mt-1 text-sm text-slate-600">{{ $b->deskripsi }}</p>
                        <div class="mt-3 flex gap-2">
                            <form method="POST" action="{{ route('admin.banner.toggle', $b) }}">@csrf
                                <button class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-bold">{{ $b->aktif ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.banner.destroy', $b) }}" onsubmit="return confirm('Hapus banner ini?')">
                                @csrf @method('DELETE')
                                <button class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600">Hapus</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <p class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500 sm:col-span-2">Belum ada banner.</p>
            @endforelse
        </section>
    </div>
@endsection
