

<?php $__env->startSection('content'); ?>
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-file-text me-2" style="color:#e3b341;"></i>Generate RMA</h4>
    <a href="<?php echo e(route('rma.history')); ?>" class="btn btn-sm px-3" style="background:#161b22; color:#8b949e; border:1px solid #30363d; border-radius:6px;">
        <i class="ti ti-history me-1"></i>Riwayat RMA
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-dark table-hover mb-0" style="font-size:.82rem;">
            <thead>
                <tr style="color:#8b949e; border-bottom:1px solid #21262d;">
                    <th class="ps-4 py-3">S/N</th>
                    <th>Nama Perangkat</th>
                    <th>Merk</th>
                    <th>ID PA</th>
                    <th>Customer</th>
                    <th>Tgl Masuk</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4 fw-bold" style="color:#58a6ff;"><?php echo e($item->serial_number); ?></td>
                    <td><?php echo e($item->nama_perangkat); ?></td>
                    <td style="color:#8b949e;"><?php echo e($item->merk ?? '-'); ?></td>
                    <td><code style="color:#e3b341;"><?php echo e($item->id_pa ?? '-'); ?></code></td>
                    <td><?php echo e($item->customer_name ?? '-'); ?></td>
                    <td style="color:#8b949e;"><?php echo e($item->tanggal_masuk?->format('d/m/Y') ?? '-'); ?></td>
                    <td class="text-center pe-4">
                        <a href="<?php echo e(route('rma.generate.form', $item->id)); ?>" class="btn btn-sm" style="background:#1f3a2a; color:#3fb950; border:1px solid #238636; font-size:.75rem; border-radius:6px;">
                            <i class="ti ti-file-description me-1"></i>Generate RMA
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:#484f58;">
                        <i class="ti ti-package-off d-block mb-2" style="font-size:2rem;"></i>
                        Tidak ada barang di Standby Masuk yang menunggu proses RMA.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('welcome', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/rma/index.blade.php ENDPATH**/ ?>