<article class="overflow-hidden rounded-2xl border border-slate-200 bg-white transition hover:shadow-lg">
    <a href="<?php echo e(route('katalog.show', $aset)); ?>">
        <img src="<?php echo e($aset->gambar_url); ?>" alt="<?php echo e($aset->nama); ?>" class="h-44 w-full object-cover" loading="lazy">
    </a>
    <div class="p-4">
        <span class="rounded-full bg-teal-50 px-2.5 py-1 text-[11px] font-bold text-teal-700"><?php echo e($aset->jenis); ?></span>
        <a href="<?php echo e(route('katalog.show', $aset)); ?>" class="mt-2 block font-bold hover:text-teal-700"><?php echo e($aset->nama); ?></a>
        <p class="text-xs text-slate-500"><?php echo e($aset->alamat); ?>, <?php echo e($aset->kota); ?></p>
        <p class="mt-1 text-xs text-slate-500">LT <?php echo e($aset->luas_tanah); ?> m² &middot; LB <?php echo e($aset->luas_bangunan); ?> m² &middot; <?php echo e($aset->sertifikat); ?></p>
        <p class="mt-2 font-extrabold text-teal-700">Rp <?php echo e(number_format($aset->harga_estimasi, 0, ',', '.')); ?></p>

        <div class="mt-3 flex items-center gap-2">
            <form method="POST" action="<?php echo e(route('katalog.like', $aset)); ?>">
                <?php echo csrf_field(); ?>
                <button class="flex items-center gap-1.5 rounded-xl border px-3 py-2 text-xs font-bold <?php echo e($liked ? 'border-rose-200 bg-rose-50 text-rose-600' : 'border-slate-200 text-slate-600'); ?>">
                    <?php echo e($liked ? '♥' : '♡'); ?> <span><?php echo e($aset->likes_count); ?></span>
                </button>
            </form>
            <button type="button"
                    onclick="bagikanAset('<?php echo e(route('katalog.show', $aset)); ?>', <?php echo \Illuminate\Support\Js::from($aset->nama)->toHtml() ?>)"
                    class="rounded-xl border border-slate-200 px-3 py-2 text-xs font-bold text-slate-600">Bagikan</button>
            <a href="https://wa.me/6283179597455?text=<?php echo e(urlencode($aset->nama.' - '.route('katalog.show', $aset))); ?>" target="_blank"
               class="rounded-xl bg-emerald-600 px-3 py-2 text-xs font-bold text-white">WhatsApp</a>
        </div>
    </div>
</article>

<?php if (! $__env->hasRenderedOnce('0684d7b5-2dcd-4ca7-a9a4-9509043af3b7')): $__env->markAsRenderedOnce('0684d7b5-2dcd-4ca7-a9a4-9509043af3b7'); ?>
    <?php $__env->startPush('scripts'); ?><?php $__env->stopPush(); ?>
    <script>
        async function bagikanAset(url, judul) {
            if (navigator.share) {
                try { await navigator.share({ title: judul, text: judul, url: url }); return; } catch (e) {}
            }
            try { await navigator.clipboard.writeText(url); alert('Tautan aset disalin: ' + url); }
            catch (e) { prompt('Salin tautan berikut:', url); }
        }
    </script>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\bsi-aset\resources\views/user/partials/kartu-aset.blade.php ENDPATH**/ ?>