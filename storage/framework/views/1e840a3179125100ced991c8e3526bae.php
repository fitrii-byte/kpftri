<?php $__env->startSection('title', 'Aset Favorit'); ?>

<?php $__env->startSection('content'); ?>
    <h1 class="text-2xl font-extrabold">Aset favorit saya</h1>
    <p class="mt-1 text-sm text-slate-500">Aset yang Anda sukai.</p>

    <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <?php $__empty_1 = true; $__currentLoopData = $asets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php echo $__env->make('user.partials.kartu-aset', ['aset' => $aset, 'liked' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="rounded-2xl border border-dashed border-slate-300 p-8 text-center text-sm text-slate-500 sm:col-span-2 lg:col-span-3">
                Belum ada aset favorit. <a href="<?php echo e(route('katalog')); ?>" class="font-bold text-teal-700">Lihat katalog</a>
            </p>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bsi-aset\resources\views/user/favorit.blade.php ENDPATH**/ ?>