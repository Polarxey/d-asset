<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-package-import me-2" style="color:#3fb950;"></i>Input Barang Masuk Baru</h4>
    
</div>

<div class="card" style="max-width:680px;">
    <div class="card-body p-4" style="background:#0e1117;">
        <form action="<?php echo e(route('barang_masuk.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php if($errors->any()): ?>
            <div class="mb-3 p-3 rounded" style="background:#3a1a1a; border:1px solid #da3633; font-size:.82rem; color:#f85149;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($err); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>

            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Serial Number (S/N) <span style="color:#f85149;">*</span></label>
                    <input type="text" name="serial_number" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9; font-family:monospace;" placeholder="Nomor seri perangkat" required value="<?php echo e(old('serial_number')); ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Nama Perangkat <span style="color:#f85149;">*</span></label>
                    <input type="text" name="nama_perangkat" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Contoh: ONU GPON / Switch L2" required value="<?php echo e(old('nama_perangkat')); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Merk</label>
                    <input type="text" name="merk" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Huawei / ZTE / Nokia" value="<?php echo e(old('merk')); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Tanggal Masuk <span style="color:#f85149;">*</span></label>
                    <input type="date" name="tanggal_masuk" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="<?php echo e(old('tanggal_masuk', date('Y-m-d'))); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Lokasi</label>
                    <input type="text" class="form-control form-control-sm" style="background:#0e1117; border:1px solid #21262d; color:#484f58; font-style:italic;" value="Gudang" disabled>
                    <div style="font-size:.72rem; color:#484f58; margin-top:4px;">Otomatis diisi sebagai Gudang</div>
                </div>
            </div>

            <div class="mt-4 pt-3 d-flex gap-2" style="border-top:1px solid #21262d;">
                <button type="submit" class="btn btn-sm px-4" style="background:#238636; color:#fff; border:none; border-radius:6px;">
                    <i class="ti ti-device-floppy me-1"></i>Simpan & Masuk ke Gudang
                </button>
                <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-sm px-3" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; border-radius:6px;">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('welcome', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/barang_masuk/create.blade.php ENDPATH**/ ?>