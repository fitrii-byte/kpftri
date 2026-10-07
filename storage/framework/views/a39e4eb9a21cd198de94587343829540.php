<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk &middot; BSI Aset</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', system-ui, sans-serif; }</style>
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-teal-900 via-teal-800 to-emerald-700 px-4 py-10">
<div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl">
    <div class="mb-6 flex items-center gap-3">
        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-600 text-lg font-bold text-white">B</span>
        <div>
            <p class="text-lg font-extrabold leading-tight">BSI Aset</p>
            <p class="text-xs text-slate-500">Portal Digital Aset</p>
        </div>
    </div>

    <h1 class="text-2xl font-extrabold text-slate-900">Masuk ke akun</h1>
    <p class="mt-1 text-sm text-slate-500">Masukkan email dan password Anda.</p>

    <?php if($errors->any()): ?>
        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="mt-6 space-y-4">
        <?php echo csrf_field(); ?>
        <div>
            <label class="block text-sm font-semibold text-slate-700">Email</label>
            <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                   class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-200"
                   placeholder="nama@email.com">
        </div>
        <div>
            <label class="block text-sm font-semibold text-slate-700">Password</label>
            <input type="password" name="password" required
                   class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-200"
                   placeholder="••••••••">
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember" class="rounded border-slate-300"> Ingat saya
        </label>
        <button class="w-full rounded-xl bg-teal-700 px-4 py-3 text-sm font-bold text-white hover:bg-teal-800">Masuk</button>
    </form>

    <p class="mt-5 text-center text-sm text-slate-600">
        Belum punya akun?
        <a href="<?php echo e(route('register.pilih')); ?>" class="font-bold text-teal-700 hover:underline">Daftar sekarang</a>
    </p>
</div>
</body>
</html><?php /**PATH C:\xampp\htdocs\bsi-aset\resources\views/auth/login.blade.php ENDPATH**/ ?>