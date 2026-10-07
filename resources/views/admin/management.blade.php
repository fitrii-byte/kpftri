@extends('layouts.admin')
@section('title', 'Manajemen Admin')

@section('content')
    <section class="rounded-2xl border border-slate-200 bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 p-5">
            <div>
                <h2 class="text-base font-extrabold">Akun Admin</h2>
                <p class="text-sm text-slate-500">Kelola akun yang memiliki akses login sebagai admin.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <form action="{{ route('admin.admin.index') }}" class="flex gap-2">
                    <input name="q" value="{{ $q }}" placeholder="Cari nama atau email..." class="rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    <button class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-bold text-white">Cari</button>
                </form>
                <a href="{{ route('admin.admin.create') }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-bold text-white">+ Tambah Admin</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-bold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">No HP</th>
                        <th class="px-4 py-3">Terdaftar</th>
                        <th class="px-4 py-3">Login Terakhir</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($admins as $i => $a)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">{{ $admins->firstItem() + $i }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $a->name }}</td>
                            <td class="px-4 py-3">{{ $a->email }}</td>
                            <td class="px-4 py-3">{{ $a->no_hp ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $a->created_at?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ $a->last_login_at ? $a->last_login_at->format('d/m/Y H:i') : 'Belum pernah' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-nowrap items-center gap-1">
                                    <a href="{{ route('admin.admin.edit', $a) }}" title="Ubah"
                                       class="flex items-center gap-1 whitespace-nowrap rounded-lg bg-teal-50 px-2.5 py-1.5 text-xs font-bold text-teal-700">✏️ Ubah</a>
                                    @if ($a->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.admin.destroy', $a) }}" onsubmit="return confirm('Hapus akun admin ini?')">
                                            @csrf @method('DELETE')
                                            <button title="Hapus"
                                                    class="flex items-center gap-1 whitespace-nowrap rounded-lg bg-red-50 px-2.5 py-1.5 text-xs font-bold text-red-600">🗑️ Hapus</button>
                                        </form>
                                    @else
                                        <span class="whitespace-nowrap text-xs text-slate-400">Akun Anda</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-slate-500">Belum ada akun admin lain.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $admins->links() }}</div>
    </section>
@endsection