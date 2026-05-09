<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-list-details me-2" style="color:#58a6ff;"></i>Daftar Paket</h4>
        <p class="mb-0" style="color:#8b949e; font-size:.85rem;">Semua paket keluar yang dibuat. Pilih paket untuk di-generate BSTP-nya.</p>
    </div>
    <a href="<?php echo e(route('bundle.create')); ?>" class="btn btn-sm px-3" style="background:#1f6feb; color:#fff; border:none; border-radius:6px; font-size:.82rem;">
        <i class="ti ti-plus me-1"></i>Buat Paket Baru
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-dark table-hover mb-0" style="font-size:.82rem;">
            <thead>
                <tr style="color:#8b949e; border-bottom:1px solid #21262d;">
                    <th class="ps-4 py-3">Nama Paket</th>
                    <th>Jumlah Perangkat</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $bundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bundle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4 fw-bold" style="color:#c9d1d9;"><?php echo e($bundle->nama_paket); ?></td>
                    <td>
                        <span style="color:#58a6ff; font-weight:600;"><?php echo e($bundle->items->count()); ?></span>
                        <span style="color:#484f58;"> unit</span>
                    </td>
                    <td style="color:#8b949e;"><?php echo e($bundle->keterangan ?? '-'); ?></td>
                    <td>
                        <span class="badge <?php echo e($bundle->status_badge_class); ?>" style="font-size:.72rem;">
                            <?php echo e($bundle->status_label); ?>

                        </span>
                    </td>
                    <td style="color:#8b949e;"><?php echo e($bundle->created_at->format('d/m/Y H:i')); ?></td>
                    <td class="text-center pe-4">
                        <?php if($bundle->status !== 'bstp_generated'): ?>
                        <a href="<?php echo e(route('transactions.create')); ?>?bundle_id=<?php echo e($bundle->id); ?>"
                           class="btn btn-sm" style="background:#1a2a1a; color:#3fb950; border:1px solid #238636; font-size:.73rem; border-radius:6px;">
                            <i class="ti ti-file-invoice me-1"></i>Generate BSTP
                        </a>
                        <form action="<?php echo e(route('bundle.destroy', $bundle->id)); ?>" method="POST" class="d-inline ms-1"
                              onsubmit="return confirm('Batalkan paket ini? Semua aset dikembalikan ke Ready.')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm"
                                style="background:#1c2128; color:#f85149; border:1px solid #30363d; font-size:.73rem; border-radius:6px;">
                                Batalkan
                            </button>
                        </form>
                        <?php else: ?>
                        <span style="font-size:.75rem; color:#484f58;"><i class="ti ti-check me-1"></i>Selesai</span>
                        <?php endif; ?>
                    </td>
                </tr>
                
                <?php if($bundle->items->count() > 0): ?>
                <tr style="border-bottom:1px solid #21262d;">
                    <td colspan="6" class="ps-4 pb-3 pt-0" style="background:#0e1117;">
                        <div style="font-size:.75rem; color:#484f58; margin-bottom:4px;">Isi paket:</div>
                        <div class="d-flex flex-wrap gap-1">
                        <?php $__currentLoopData = $bundle->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($item->asset): ?>
                            <span style="background:#1c2128; border:1px solid #21262d; border-radius:4px; padding:2px 8px; font-size:.73rem; color:#8b949e;">
                                <code style="color:#58a6ff; font-size:.7rem;"><?php echo e($item->asset->serial_number); ?></code>
                                · <?php echo e($item->asset->nama_perangkat); ?>

                            </span>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#484f58;">
                        <i class="ti ti-packages" style="font-size:2rem; display:block; margin-bottom:8px; opacity:.3;"></i>
                        Belum ada paket yang dibuat.<br>
                        <a href="<?php echo e(route('bundle.create')); ?>" style="color:#58a6ff; font-size:.82rem;">Buat paket pertama →</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('welcome', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/bundle/index.blade.php ENDPATH**/ ?>