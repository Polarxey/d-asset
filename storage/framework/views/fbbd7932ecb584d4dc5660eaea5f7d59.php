<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-file-text me-2" style="color:#3fb950;"></i>Generate Dokumen RMA</h4>
    <p class="mb-0" style="color:#8b949e; font-size:.85rem;">Terbitkan RMA untuk S/N <code style="color:#58a6ff;"><?php echo e($asset->serial_number); ?></code>. Status akan otomatis berubah ke <span style="color:#3fb950;">Ready (Gudang)</span>.</p>
</div>

<div class="row g-3">
    
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-body p-4" style="background:#0e1117;">
                <div class="mb-3" style="font-size:.8rem; color:#8b949e; font-weight:600; text-transform:uppercase; letter-spacing:.8px; border-bottom:1px solid #21262d; padding-bottom:8px;">
                    Data Perangkat (Otomatis)
                </div>
                <div class="row g-2" style="font-size:.82rem;">
                    <div class="col-5" style="color:#8b949e;">ID PA</div>
                    <div class="col-7" style="color:#e3b341; font-weight:600;"><?php echo e($asset->id_pa ?? '-'); ?></div>
                    <div class="col-5" style="color:#8b949e;">S/N</div>
                    <div class="col-7"><code style="color:#58a6ff;"><?php echo e($asset->serial_number); ?></code></div>
                    <div class="col-5" style="color:#8b949e;">Nama Perangkat</div>
                    <div class="col-7" style="color:#c9d1d9;"><?php echo e($asset->nama_perangkat); ?></div>
                    <div class="col-5" style="color:#8b949e;">Merk</div>
                    <div class="col-7" style="color:#c9d1d9;"><?php echo e($asset->merk ?? '-'); ?></div>
                    <div class="col-5" style="color:#8b949e;">Tanggal Masuk</div>
                    <div class="col-7" style="color:#c9d1d9;"><?php echo e($asset->tanggal_masuk?->format('d/m/Y') ?? '-'); ?></div>
                    <div class="col-5" style="color:#8b949e;">Lokasi Asal</div>
                    <div class="col-7" style="color:#c9d1d9;"><?php echo e($asset->lokasi_asal ?? '-'); ?></div>
                    <div class="col-5" style="color:#8b949e;">Customer (CPE)</div>
                    <div class="col-7" style="color:#c9d1d9;"><?php echo e($asset->customer_name ?? '-'); ?></div>
                    <div class="col-5" style="color:#8b949e;">Valuation Type</div>
                    <div class="col-7">
                        <span class="badge" style="background:#3a1a1a; color:#f85149; font-size:.7rem;"><?php echo e($asset->valuation_type ?? '-'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-md-7">
        <div class="card">
            <div class="card-body p-4" style="background:#0e1117;">
                <div class="mb-3" style="font-size:.8rem; color:#8b949e; font-weight:600; text-transform:uppercase; letter-spacing:.8px; border-bottom:1px solid #21262d; padding-bottom:8px;">
                    Penerbitan Dokumen RMA
                </div>
                <form action="<?php echo e(route('rma.generate.pdf', $asset->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label" style="font-size:.78rem; color:#8b949e;">Nomor RMA</label>
                            <input type="text" name="no_rma" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9; font-family:monospace;" value="<?php echo e($autoNoRma); ?>" required>
                            <div style="font-size:.72rem; color:#484f58; margin-top:4px;">Auto-generated. Bisa diubah jika perlu.</div>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label" style="font-size:.78rem; color:#8b949e;">Tanggal RMA</label>
                            <input type="date" name="tanggal_rma" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="<?php echo e(date('Y-m-d')); ?>" required>
                        </div>
                    </div>

                    <div class="mt-4 p-3 rounded" style="background:#1a2a1a; border:1px solid #238636;">
                        <div style="font-size:.8rem; color:#3fb950; font-weight:600; margin-bottom:6px;"><i class="ti ti-alert-circle me-1"></i>Konfirmasi Perubahan Status</div>
                        <div style="font-size:.78rem; color:#8b949e; line-height:1.6;">
                            Setelah PDF diterbitkan, status perangkat akan otomatis berubah:<br>
                            <span style="color:#e3b341;">Standby Masuk</span> → <span style="color:#3fb950;">Ready (Gudang)</span>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-sm px-4" style="background:#238636; color:#fff; border:none; border-radius:6px;">
                            <i class="ti ti-file-download me-1"></i>Terbitkan RMA & Download PDF
                        </button>
                        <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-sm px-3" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; border-radius:6px;">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('welcome', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/rma/generate.blade.php ENDPATH**/ ?>