<?php $__env->startSection('title', 'Master Data Inti'); ?>

<?php $__env->startSection('content'); ?>
    <section class="rounded-2xl border border-slate-200 bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 p-5">
            <div>
                <h2 class="text-base font-extrabold">Data Portofolio Nasabah</h2>
                <p class="text-sm text-slate-500">Database portofolio pembiayaan NPF &amp; Non NPF.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <form action="<?php echo e(route('admin.master.index')); ?>" class="flex gap-2">
                    <input name="q" value="<?php echo e($q); ?>" placeholder="Cari nasabah, no loan, cabang..." class="rounded-xl border border-slate-300 px-3 py-2 text-sm">
                    <select name="status" class="rounded-xl border border-slate-300 px-3 py-2 text-sm">
                        <option value="">Semua</option>
                        <option value="npf" <?php if($status === 'npf'): echo 'selected'; endif; ?>>NPF</option>
                        <option value="non-npf" <?php if($status === 'non-npf'): echo 'selected'; endif; ?>>Non NPF</option>
                    </select>
                    <button class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-bold text-white">Cari</button>
                </form>
                <a href="<?php echo e(route('admin.master.create')); ?>" class="rounded-xl bg-teal-700 px-4 py-2 text-sm font-bold text-white">+ Tambah Data</a>
                <a href="<?php echo e(route('admin.master.export')); ?>" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-bold text-white">Save ZIP Portofolio</a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs font-bold uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">CIF &amp; Nama Nasabah</th>
                        <th class="px-4 py-3">No Loan</th>
                        <th class="px-4 py-3">Segmen &amp; Produk</th>
                        <th class="px-4 py-3">Cabang Pengelola</th>
                        <th class="px-4 py-3">Kolektibilitas</th>
                        <th class="px-4 py-3">OS Pokok</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $debiturs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3"><?php echo e($debiturs->firstItem() + $i); ?></td>
                            <td class="px-4 py-3">
                                <p class="font-semibold"><?php echo e($d->nama); ?></p>
                                <p class="font-mono text-xs text-slate-500">CIF <?php echo e($d->cif); ?></p>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs"><?php echo e($d->no_loan); ?></td>
                            <td class="px-4 py-3">
                                <p><?php echo e($d->segmen); ?></p>
                                <p class="text-xs text-slate-500"><?php echo e($d->produk); ?></p>
                            </td>
                            <td class="px-4 py-3"><?php echo e($d->cabang_pengelola); ?></td>
                            <td class="px-4 py-3">
                                <span class="whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold <?php echo e($d->is_npf ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-700'); ?>">
                                    Kol <?php echo e($d->kolektibilitas); ?> &middot; <?php echo e($d->is_npf ? 'NPF' : 'Non NPF'); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 font-bold">Rp <?php echo e(number_format($d->os_pokok, 0, ',', '.')); ?></td>
                            <td class="px-4 py-3">
                                <div class="flex flex-nowrap items-center gap-1">
                                    <a href="<?php echo e(route('admin.master.show', $d)); ?>" title="Lihat"
                                       class="flex items-center gap-1 whitespace-nowrap rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-bold text-slate-700">👁️ Lihat</a>
                                    <a href="<?php echo e(route('admin.master.edit', $d)); ?>" title="Edit"
                                       class="flex items-center gap-1 whitespace-nowrap rounded-lg bg-teal-50 px-2.5 py-1.5 text-xs font-bold text-teal-700">✏️ Edit</a>
                                    <form method="POST" action="<?php echo e(route('admin.master.destroy', $d)); ?>" onsubmit="return confirm('Hapus data debitur ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button title="Hapus"
                                                class="flex items-center gap-1 whitespace-nowrap rounded-lg bg-red-50 px-2.5 py-1.5 text-xs font-bold text-red-600">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="8" class="px-4 py-8 text-center text-slate-500">Belum ada data portofolio.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-4"><?php echo e($debiturs->links()); ?></div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bsi-aset\resources\views/admin/master-data.blade.php ENDPATH**/ ?>