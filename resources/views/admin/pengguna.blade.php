@extends('layouts.admin')
@section('title', 'Daftar User')

@section('content')
    <section class="rounded-2xl border border-slate-200 bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 p-5">
            <div>
                <h2 class="text-base font-extrabold">Daftar User Terdaftar</h2>
                <p class="text-sm text-slate-500">User publik yang mendaftar lewat halaman Register, beserta waktu login terakhir.</p>
            </div>
            <form action="{{ route('admin.user.index') }}" class="flex gap-2">
                <input name="q" value="{{ $q }}" placeholder="Cari nama atau email..." class="rounded-xl border border-slate-300 px-3 py-2 text-sm">
                <button class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-bold text-white">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-bold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">No HP</th>
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Terdaftar</th>
                        <th class="px-4 py-3">Login Terakhir</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $i => $u)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">{{ $users->firstItem() + $i }}</td>
                            <td class="px-4 py-3 font-semibold">{{ $u->name }}</td>
                            <td class="px-4 py-3">{{ $u->email }}</td>
                            <td class="px-4 py-3">{{ $u->no_hp ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $u->isAdmin() ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-600' }}">{{ $u->role }}</span>
                            </td>
                            <td class="px-4 py-3">{{ $u->created_at?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ $u->last_login_at ? $u->last_login_at->format('d/m/Y H:i') : 'Belum pernah' }}</td>
                            <td class="px-4 py-3">
                                @if ($u->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.user.destroy', $u) }}" onsubmit="return confirm('Hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">Akun Anda</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $users->links() }}</div>
    </section>
@endsection
