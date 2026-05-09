<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-start mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#c9d1d9;">Dashboard Monitoring</h4>
        <p class="mb-0" style="color:#8b949e; font-size:.85rem;">Asset summary · PLN ICON+ Bandung</p>
    </div>
    <span style="font-size:.78rem; color:#484f58;"><?php echo e(now()->translatedFormat('l, d F Y')); ?></span>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span style="font-size:.75rem; color:#e3b341; text-transform:uppercase; letter-spacing:.8px; font-weight:600;">Standby Masuk</span>
                <i class="ti ti-arrow-back-up" style="color:#e3b341; font-size:1.1rem;"></i>
            </div>
            <div style="font-size:2rem; font-weight:700; color:#c9d1d9; line-height:1;"><?php echo e($totalStandby); ?></div>
            <div style="font-size:.75rem; color:#8b949e; margin-top:4px;">Menunggu proses RMA</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span style="font-size:.75rem; color:#3fb950; text-transform:uppercase; letter-spacing:.8px; font-weight:600;">Ready (Gudang)</span>
                <i class="ti ti-package" style="color:#3fb950; font-size:1.1rem;"></i>
            </div>
            <div style="font-size:2rem; font-weight:700; color:#c9d1d9; line-height:1;"><?php echo e($totalReady); ?></div>
            <div style="font-size:.75rem; color:#8b949e; margin-top:4px;">Siap dipasang / dikeluarkan</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span style="font-size:.75rem; color:#58a6ff; text-transform:uppercase; letter-spacing:.8px; font-weight:600;">Dalam Paket</span>
                <i class="ti ti-packages" style="color:#58a6ff; font-size:1.1rem;"></i>
            </div>
            <div style="font-size:2rem; font-weight:700; color:#c9d1d9; line-height:1;"><?php echo e($totalPaket); ?></div>
            <div style="font-size:.75rem; color:#8b949e; margin-top:4px;">Standby keluar / menunggu BSTP</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span style="font-size:.75rem; color:#8b949e; text-transform:uppercase; letter-spacing:.8px; font-weight:600;">Terpasang</span>
                <i class="ti ti-map-pin" style="color:#8b949e; font-size:1.1rem;"></i>
            </div>
            <div style="font-size:2rem; font-weight:700; color:#c9d1d9; line-height:1;"><?php echo e($totalUsed); ?></div>
            <div style="font-size:.75rem; color:#8b949e; margin-top:4px;">Sudah di lokasi pelanggan</div>
        </div>
    </div>
</div>


<div class="row g-3 mb-4">
    <div class="col-12">
        <div class="card p-3">
            <div class="d-flex gap-2 flex-wrap">
                <span style="font-size:.8rem; color:#8b949e; align-self:center; margin-right:4px;">Quick action:</span>
                <a href="<?php echo e(route('rma.create')); ?>" class="btn btn-sm btn-outline-warning" style="font-size:.8rem; border-radius:6px;">
                    <i class="ti ti-arrow-back-up me-1"></i>Input Retur
                </a>
                <a href="<?php echo e(route('barang_masuk.create')); ?>" class="btn btn-sm btn-outline-success" style="font-size:.8rem; border-radius:6px;">
                    <i class="ti ti-package-import me-1"></i>Barang Masuk Baru
                </a>
                <a href="<?php echo e(route('bundle.create')); ?>" class="btn btn-sm btn-outline-info" style="font-size:.8rem; border-radius:6px;">
                    <i class="ti ti-packages me-1"></i>Buat Paket Keluar
                </a>
                <a href="<?php echo e(route('transactions.create')); ?>" class="btn btn-sm btn-outline-primary" style="font-size:.8rem; border-radius:6px;">
                    <i class="ti ti-file-invoice me-1"></i>Generate BSTP
                </a>
            </div>
        </div>
    </div>
</div>


<div class="card">
    <div class="card-body p-0">
        <div class="px-4 py-3 d-flex justify-content-between align-items-center" style="border-bottom:1px solid #21262d;">
            <span style="font-size:.85rem; font-weight:600; color:#c9d1d9;"><i class="ti ti-activity me-2" style="color:#8b949e;"></i>Aktivitas Terbaru</span>
            <a href="<?php echo e(route('activity_log.index')); ?>" style="font-size:.78rem; color:#58a6ff; text-decoration:none;">Lihat semua →</a>
        </div>
        <table class="table table-dark table-hover mb-0" style="font-size:.82rem;">
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $recentLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4" style="color:#8b949e; white-space:nowrap; width:150px;"><?php echo e($log->created_at->format('d/m/y H:i')); ?></td>
                    <td>
                        <span class="badge bg-secondary me-2" style="font-size:.7rem;"><?php echo e($log->aksi); ?></span>
                        <?php echo e($log->deskripsi); ?>

                    </td>
                    <td style="color:#8b949e;"><?php echo e($log->actor); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="3" class="text-center py-4" style="color:#484f58;">Belum ada aktivitas tercatat.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('welcome', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/dashboard.blade.php ENDPATH**/ ?>