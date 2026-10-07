<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Admin &middot; BSI Aset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }</style>
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 px-4 py-10">
<div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl">
    <span class="inline-block rounded-full bg-amber-100 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-amber-700">Khusus Staf BSI</span>
    <h1 class="mt-3 text-2xl font-extrabold text-slate-900">Daftar akun admin</h1>
    <p class="mt-1 text-sm text-slate-500">Isi data diri dan kode undangan admin yang diberikan oleh pengelola sistem.</p>

    @if ($errors->any())
        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-inside list-disc">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.admin') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-slate-700">Nama lengkap</label>
            <input name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700">No. HP</label>
            <input name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx" class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700">Password</label>
            <input type="password" name="password" required class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700">Ulangi password</label>
            <input type="password" name="password_confirmation" required class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-slate-500 focus:outline-none">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700">Kode Undangan Admin</label>
            <input name="kode_undangan" required placeholder="Minta ke pengelola sistem" class="mt-1 w-full rounded-xl border border-amber-300 bg-amber-50 px-4 py-3 text-sm focus:border-amber-500 focus:outline-none">
        </div>
        <button class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white hover:bg-slate-800">Daftar sebagai Admin</button>
    </form>

    <p class="mt-5 text-center text-sm text-slate-600">
        Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-slate-900 hover:underline">Masuk</a>
    </p>
</div>
</body>
</html>