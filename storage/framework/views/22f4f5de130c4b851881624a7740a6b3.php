<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-packages me-2" style="color:#58a6ff;"></i>Buat Transaksi Keluar</h4>
</div>

<form action="<?php echo e(route('bundle.store')); ?>" method="POST" id="bundleForm">
<?php echo csrf_field(); ?>
<div class="row g-3">
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-body p-4" style="background:#0e1117;">
                <div class="mb-3" style="font-size:.8rem; color:#8b949e; font-weight:600; text-transform:uppercase; letter-spacing:.8px; border-bottom:1px solid #21262d; padding-bottom:8px;">
                    Info Transaksi
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Nama Transaksi / Paket <span style="color:#f85149;">*</span></label>
                    <input type="text" name="nama_paket" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Contoh: Pengeluaran-001" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Keterangan</label>
                    <textarea name="keterangan" class="form-control form-control-sm" rows="3" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-body p-4" style="background:#0e1117;">
                <div class="mb-3 d-flex justify-content-between align-items-center" style="border-bottom:1px solid #21262d; padding-bottom:8px;">
                    <span style="font-size:.8rem; color:#8b949e; font-weight:600; text-transform:uppercase; letter-spacing:.8px;">Pilih Perangkat (Ready)</span>
                </div>

                <div>
                    <div style="max-height: 350px; overflow-y: auto;">
                        <?php $__empty_1 = true; $__currentLoopData = $readyAssets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="item-row mb-2 p-3 rounded" style="background:#161b22; border:1px solid #21262d;">
                            <div class="d-flex align-items-center gap-2">
                                <div style="flex:1;">
                                    <div style="font-size:.82rem; color:#c9d1d9; font-weight:500;"><?php echo e($group->nama_perangkat); ?></div>
                                    <div style="font-size:.73rem; color:#8b949e;"><?php echo e($group->merk ?? '-'); ?> &middot; Stok: <span style="color:#3fb950; font-weight:600;"><?php echo e($group->stok_tersedia); ?></span></div>
                                    <input type="hidden" name="items[<?php echo e($idx); ?>][nama_perangkat]" value="<?php echo e($group->nama_perangkat); ?>">
                                </div>
                                <div style="width:90px;">
                                    <label style="font-size:.7rem; color:#8b949e; display:block; margin-bottom:2px;">Qty</label>
                                    <input type="number" name="items[<?php echo e($idx); ?>][qty]" class="form-control form-control-sm text-center" style="background:#0e1117; border:1px solid #30363d; color:#c9d1d9;" value="0" min="0" max="<?php echo e($group->stok_tersedia); ?>">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-4" style="color:#484f58;">Tidak ada stok Ready.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4 pt-3 d-flex gap-2" style="border-top:1px solid #21262d;">
                    <button type="submit" class="btn btn-sm px-4" style="background:#1f6feb; color:#fff; border:none; border-radius:6px;">
                        <i class="ti ti-check me-1"></i>Proses Transaksi Keluar
                    </button>
                    <a href="<?php echo e(route('bundle.index')); ?>" class="btn btn-sm px-3" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; border-radius:6px;">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('welcome', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/bundle/create.blade.php ENDPATH**/ ?>