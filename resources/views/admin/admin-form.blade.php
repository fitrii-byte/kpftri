@extends('layouts.admin')
@section('title', $admin->exists ? 'Ubah Akun Admin' : 'Tambah Akun Admin')

@section('content')
    <a href="{{ route('admin.admin.index') }}" class="text-sm font-semibold text-teal-700">&larr; Kembali ke Manajemen Admin</a>

    <section class="mt-4 max-w-xl rounded-2xl border border-slate-200 bg-white p-6">
        <h2 class="text-base font-extrabold">{{ $admin->exists ? 'Ubah Akun Admin' : 'Tambah Akun Admin' }}</h2>

        <form method="POST"
              action="{{ $admin->exists ? route('admin.admin.update', $admin) : route('admin.admin.store') }}"
              class="mt-4 grid gap-4">
            @csrf
            @if ($admin->exists) @method('PUT') @endif

            <div>
                <label class="text-xs font-bold text-slate-500">Nama</label>
                <input name="name" value="{{ old('name', $admin->name) }}" required
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500">Email</label>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500">No HP</label>
                <input name="no_hp" value="{{ old('no_hp', $admin->no_hp) }}"
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-slate-500">
                    Password {{ $admin->exists ? '(kosongkan jika tidak diubah)' : '' }}
                </label>
                <input type="password" name="password" {{ $admin->exists ? '' : 'required' }}
                       class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm">
            </div>

            <div class="mt-2 flex gap-2">
                <button class="rounded-xl bg-teal-700 px-6 py-2.5 text-sm font-bold text-white">
                    {{ $admin->exists ? 'Simpan Perubahan' : 'Simpan Admin' }}
                </button>
                <a href="{{ route('admin.admin.index') }}" class="rounded-xl border border-slate-300 px-6 py-2.5 text-sm font-bold text-slate-600">Batal</a>
            </div>
        </form>
    </section>
@endsection