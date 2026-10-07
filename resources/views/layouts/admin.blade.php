<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') &middot; BSI Aset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            50:  '#eef2fb',
                            100: '#dbe4f6',
                            200: '#b7c8ec',
                            300: '#8aa5de',
                            400: '#5a7ccb',
                            500: '#3a5eb5',
                            600: '#1e3a8a',
                            700: '#172e6e',
                            800: '#0f2557',
                            900: '#0a1a40',
                        },
                    },
                },
            },
        }
    </script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }
        .brand { background-color: #0f2557; }
        .brand-2 { background-color: #2f52a8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">
<div class="flex min-h-screen">
    <aside class="brand hidden w-64 shrink-0 flex-col justify-between text-white lg:flex">
        <div>
            <div class="flex items-center gap-3 px-6 py-6">
                <div class="brand-2 flex h-10 w-10 items-center justify-center rounded-xl text-lg font-bold">B</div>
                <div>
                    <p class="text-base font-extrabold leading-tight">BSI Aset</p>
                    <p class="text-xs text-white/70">Portal Digital Aset</p>
                </div>
            </div>
            <p class="px-6 pb-2 text-[11px] font-bold tracking-widest text-white/50">MENU UTAMA</p>
            @php
                $menu = [
                    ['admin.dashboard', 'Dashboard Lelang'],
                    ['admin.master.index', 'Master Data Inti'],
                    ['admin.banner.index', 'Manajemen Banner'],
                    ['admin.booklet.index', 'Booklet Aset'],
                    ['admin.admin.index', 'Manajemen Admin'],
                    ['admin.user.index', 'Daftar User'],
                    ['admin.kalkulator', 'Kalkulator Biaya'],
                ];
            @endphp
            <nav class="space-y-1 px-3">
                @foreach ($menu as [$route, $label])
                    <a href="{{ route($route) }}"
                       class="block rounded-xl px-4 py-3 text-sm font-semibold transition {{ request()->routeIs($route) || request()->routeIs(str_replace('.index', '.*', $route)) ? 'brand-2 text-white' : 'text-white/80 hover:bg-white/10' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>
        <div class="border-t border-white/10 p-5">
            <p class="text-xs text-white/60">Masuk sebagai</p>
            <p class="mb-3 text-sm font-bold">{{ auth()->user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-red-700">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1">
        <header class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 bg-white px-6 py-5">
            <h1 class="text-xl font-extrabold text-slate-900">@yield('title', 'Dashboard')</h1>
            <p class="text-sm text-slate-500">Halo, <span class="font-bold text-slate-800">{{ auth()->user()->name }}</span></p>
        </header>

        <div class="lg:hidden flex gap-2 overflow-x-auto border-b border-slate-200 bg-white px-4 py-3 text-xs font-semibold">
            @foreach ($menu as [$route, $label])
                <a href="{{ route($route) }}" class="whitespace-nowrap rounded-full px-3 py-1.5 {{ request()->routeIs($route) ? 'bg-teal-600 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $label }}</a>
            @endforeach
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="whitespace-nowrap rounded-full bg-red-600 px-3 py-1.5 text-white">Keluar</button>
            </form>
        </div>

        <div class="p-4 sm:p-6">
            @if (session('status'))
                <div class="mb-4 rounded-xl border border-teal-200 bg-teal-50 px-4 py-3 text-sm font-semibold text-teal-800">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

{{-- Kotak konfirmasi hapus --}}
<div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm">
    <div class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-50 text-2xl">🗑️</div>
        <h3 class="mt-4 text-center text-lg font-extrabold text-slate-900">Konfirmasi Hapus</h3>
        <p id="confirm-message" class="mt-1 text-center text-sm font-semibold text-slate-700"></p>
        <p class="mt-1 text-center text-xs text-slate-500">Data yang dihapus tidak dapat dikembalikan.</p>
        <div class="mt-6 flex gap-3">
            <button type="button" id="confirm-cancel"
                    class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-slate-50">Batal</button>
            <button type="button" id="confirm-ok"
                    class="flex-1 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-red-700">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = document.getElementById('confirm-modal');
        var msg = document.getElementById('confirm-message');
        var okBtn = document.getElementById('confirm-ok');
        var cancelBtn = document.getElementById('confirm-cancel');
        var pendingForm = null;

        function openModal(form, text) {
            pendingForm = form;
            msg.textContent = text;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            okBtn.focus();
        }

        function closeModal() {
            pendingForm = null;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Ambil alih semua form yang memakai onsubmit="return confirm('...')"
        document.querySelectorAll('form[onsubmit*="confirm("]').forEach(function (form) {
            var match = form.getAttribute('onsubmit').match(/confirm\((['"])(.*?)\1\)/);
            var text = match ? match[2] : 'Yakin ingin menghapus data ini?';
            form.removeAttribute('onsubmit');
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                openModal(form, text);
            });
        });

        okBtn.addEventListener('click', function () {
            var form = pendingForm;
            closeModal();
            if (form) form.submit();
        });
        cancelBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });
    });
</script>
</body>
</html>