@extends('layouts.user')
@section('title', 'Aset Favorit')

@section('content')
    <h1 class="text-2xl font-extrabold">Aset favorit saya</h1>
    <p class="mt-1 text-sm text-slate-500">Aset yang Anda sukai.</p>

    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($asets as $aset)
            @include('user.partials.kartu-aset', ['aset' => $aset, 'liked' => true])
        @empty
            <p class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500 sm:col-span-2 lg:col-span-3">
                Belum ada aset favorit. <a href="{{ route('katalog') }}" class="font-bold text-teal-700">Lihat katalog</a>
            </p>
        @endforelse
    </div>
@endsection
