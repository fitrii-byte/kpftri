<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Katalog Aset') &middot; BSI Aset</title>
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
    <style>body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">
<header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-3 px-4 py-3">
        <a href="{{ route('landing') }}" class="flex items-center gap-2">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-600 text-base font-bold text-white">B</span>
            <span class="leading-tight">
                <span class="block text-sm font-extrabold">BSI Aset</span>
                <span class="block text-[11px] text-slate-500">Portal Digital Aset</span>
            </span>
        </a>
        <nav class="flex items-center gap-2 text-sm font-semibold">
            @auth
                <a href="{{ route('katalog') }}" class="rounded-lg px-3 py-2 hover:bg-slate-100">Katalog</a>
                <a href="{{ route('katalog.favorit') }}" class="rounded-lg px-3 py-2 hover:bg-slate-100">Favorit</a>
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 text-teal-700 hover:bg-teal-50">Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="rounded-lg bg-slate-900 px-3 py-2 text-white">Keluar</button>
                </form>
            @else
               <a href="{{ route('register.pilih') }}" class="rounded-lg bg-teal-600 px-3 py-2 text-white">Daftar</a>
            @endauth
        </nav>
    </div>
</header>

<main class="mx-auto max-w-6xl px-4 py-6">
    @if (session('status'))
        <div class="mb-4 rounded-xl border border-teal-200 bg-teal-50 px-4 py-3 text-sm font-semibold text-teal-800">{{ session('status') }}</div>
    @endif
    @yield('content')
</main>

<footer class="mt-12 border-t border-slate-200 bg-white py-6 text-center text-xs text-slate-500">
    &copy; {{ date('Y') }} BSI Aset — Portal Digital Aset. Data aset bersifat indikatif.
</footer>
</body>
</html>