<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun &middot; BSI Aset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }</style>
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-teal-800 to-blue-900 px-4 py-10">
<div class="w-full max-w-lg rounded-3xl bg-white p-8 shadow-2xl">
    <h1 class="text-2xl font-extrabold text-slate-900">Daftar akun</h1>
    <p class="mt-1 text-sm text-slate-500">Pilih jenis akun yang ingin kamu buat.</p>

    <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <a href="{{ route('register') }}"
           class="group rounded-2xl border-2 border-slate-200 p-5 text-left transition hover:border-teal-600 hover:bg-teal-50">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-100 text-xl">🏠</span>
            <h2 class="mt-3 font-extrabold text-slate-900">Saya Pembeli</h2>
            <p class="mt-1 text-xs text-slate-500">Lihat katalog aset, simpan favorit, dan ikuti info lelang.</p>
            <span class="mt-3 inline-block text-xs font-bold text-teal-700 group-hover:underline">Daftar sebagai Pembeli →</span>
        </a>

        <a href="{{ route('register.admin') }}"
           class="group rounded-2xl border-2 border-slate-200 p-5 text-left transition hover:border-slate-700 hover:bg-slate-50">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-200 text-xl">🛡️</span>
            <h2 class="mt-3 font-extrabold text-slate-900">Saya Staf BSI</h2>
            <p class="mt-1 text-xs text-slate-500">Kelola data aset, nasabah, dan sistem. Butuh kode undangan admin.</p>
            <span class="mt-3 inline-block text-xs font-bold text-slate-700 group-hover:underline">Daftar sebagai Admin →</span>
        </a>
    </div>

    <p class="mt-6 text-center text-sm text-slate-600">
        Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-teal-700 hover:underline">Masuk</a>
    </p>
</div>
</body>
</html>