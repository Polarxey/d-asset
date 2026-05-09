<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-file-certificate me-2" style="color:#e3b341;"></i>Finalisasi Dokumen RMA</h4>
</div>

<div class="row g-3">
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-body p-4" style="background:#0e1117;">
                <div class="mb-3" style="font-size:.8rem; color:#8b949e; font-weight:600; text-transform:uppercase; border-bottom:1px solid #21262d; padding-bottom:8px;">Data Perangkat</div>
                <table class="table table-sm table-borderless mt-2" style="font-size:.82rem; color:#c9d1d9;">
                    <tr><td style="color:#8b949e; width:40%;">S/N</td><td>: <strong><?php echo e($asset->serial_number); ?></strong></td></tr>
                    <tr><td style="color:#8b949e;">Perangkat</td><td>: <?php echo e($asset->nama_perangkat); ?></td></tr>
                    <tr><td style="color:#8b949e;">ID PA</td><td>: <span style="color:#e3b341;"><?php echo e($asset->id_pa); ?></span></td></tr>
                    <tr><td style="color:#8b949e;">Valuation</td><td>: <?php echo e($asset->valuation_type); ?></td></tr>
                    <tr><td style="color:#8b949e;">Customer</td><td>: <?php echo e($asset->customer_name); ?></td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-body p-4" style="background:#0e1117;">
                <form action="<?php echo e(route('rma.generate.pdf', $asset->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label" style="font-size:.78rem; color:#8b949e;">Nomor RMA</label>
                            <input type="text" name="no_rma" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9; font-family:monospace;" value="<?php echo e($autoNoRma); ?>" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label" style="font-size:.78rem; color:#8b949e;">Tanggal RMA</label>
                            <input type="date" name="tanggal_rma" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="<?php echo e(date('Y-m-d')); ?>" required>
                        </div>
                    </div>

                    <div class="mt-4 p-3 rounded" style="background:#1a2a1a; border:1px solid #238636;">
                        <div style="font-size:.8rem; color:#3fb950; font-weight:600; margin-bottom:6px;"><i class="ti ti-alert-circle me-1"></i>Konfirmasi Perubahan Status</div>
                        <div style="font-size:.78rem; color:#8b949e; line-height:1.6;">
                            Dengan menekan tombol di bawah, status perangkat akan berubah menjadi <strong>Ready</strong> dan lokasi diatur ke <strong>Gudang</strong> secara otomatis.
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-sm px-4" style="background:#238636; color:#fff; border:none; border-radius:6px;">
                            <i class="ti ti-file-download me-1"></i>Cetak PDF & Selesaikan
                        </button>
                        <a href="<?php echo e(route('rma.index')); ?>" class="btn btn-sm px-3" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; border-radius:6px;">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('welcome', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/rma/generate.blade.php ENDPATH**/ ?>