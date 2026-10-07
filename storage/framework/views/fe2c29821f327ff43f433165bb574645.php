<?php $__env->startSection('title', 'Katalog Aset'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="text-2xl font-extrabold">Mau cari aset apa?</h1>
    <p class="mt-1 text-sm text-slate-500">Pilih kategori atau gunakan pencarian.</p>

    <?php if($hargaMax > 0): ?>
        <div class="mt-3 flex flex-wrap items-center gap-2 rounded-xl border border-teal-200 bg-teal-50 px-4 py-2.5 text-sm text-teal-800">
            <span>Menampilkan aset dengan harga maksimal <strong>Rp <?php echo e(number_format($hargaMax, 0, ',', '.')); ?></strong> (sesuai simulasi KPR kamu)</span>
            <a href="<?php echo e(route('katalog')); ?>" class="ml-auto text-xs font-bold underline">Hapus filter</a>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('katalog')); ?>" class="mt-4 grid gap-2 sm:grid-cols-[1fr_auto_auto_auto]">
        <?php if($hargaMax > 0): ?>
            <input type="hidden" name="harga_max" value="<?php echo e($hargaMax); ?>">
        <?php endif; ?>
        <input name="q" value="<?php echo e($q); ?>" placeholder="Cari nama aset, alamat, kota..." class="rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-teal-500 focus:outline-none">
        <select name="jenis" class="rounded-xl border border-slate-300 px-3 py-3 text-sm">
            <option value="">Semua jenis</option>
            <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k); ?>" <?php if($jenis === $k): echo 'selected'; endif; ?>><?php echo e($k); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="kota" class="rounded-xl border border-slate-300 px-3 py-3 text-sm">
            <option value="">Semua kota</option>
            <?php $__currentLoopData = $kotaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k); ?>" <?php if($kota === $k): echo 'selected'; endif; ?>><?php echo e($k); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="rounded-xl bg-teal-700 px-6 py-3 text-sm font-bold text-white">Cari</button>
    </form>

    <div class="mt-4 flex flex-wrap gap-2">
        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('katalog', ['jenis' => $k])); ?>"
               class="rounded-full px-4 py-1.5 text-xs font-bold <?php echo e($jenis === $k ? 'bg-teal-700 text-white' : 'bg-white text-slate-600 border border-slate-200'); ?>"><?php echo e($k); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <p class="mt-6 text-sm text-slate-500">Ditemukan <b><?php echo e($asets->total()); ?></b> aset.</p>

    <div class="mt-3 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $asets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php echo $__env->make('user.partials.kartu-aset', ['aset' => $aset, 'liked' => in_array($aset->id, $likedIds, true)], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500 sm:col-span-2 lg:col-span-3">Belum ada aset yang cocok.</p>
        <?php endif; ?>
    </div>

    <div class="mt-6"><?php echo e($asets->links()); ?></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bsi-aset\resources\views/user/katalog.blade.php ENDPATH**/ ?>