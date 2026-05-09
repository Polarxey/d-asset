<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-file-invoice me-2" style="color:#3fb950;"></i>Generate BSTP</h4>
</div>

<?php if($bundles->isEmpty()): ?>
<div class="card">
    <div class="card-body text-center py-5" style="background:#0e1117;">
        <i class="ti ti-packages" style="font-size:2.5rem; color:#484f58; display:block; margin-bottom:12px;"></i>
        <div style="color:#8b949e; font-size:.9rem;">Tidak ada paket yang siap di-BSTP-kan.</div>
        <a href="<?php echo e(route('bundle.create')); ?>" class="btn btn-sm mt-3 px-4" style="background:#1f6feb; color:#fff; border:none; border-radius:6px; font-size:.82rem;">
            <i class="ti ti-plus me-1"></i>Buat Paket Baru
        </a>
    </div>
</div>
<?php else: ?>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body p-4" style="background:#0e1117;">
                <form action="<?php echo e(route('transactions.store')); ?>" method="POST" id="bstpForm">
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Pilih Paket <span style="color:#f85149;">*</span></label>
                    <select name="bundle_id" id="bundleSelect" class="form-select form-select-sm"
                        style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" required>
                        <option value="">-- Pilih Paket --</option>
                        <?php $__currentLoopData = $bundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bundle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($bundle->id); ?>"
                            data-items="<?php echo e($bundle->items->map(fn($i) => ($i->asset->nama_perangkat ?? '?') . ' (' . ($i->asset->serial_number ?? '-') . ')')->join(', ')); ?>"
                            data-count="<?php echo e($bundle->items->count()); ?>"
                            <?php echo e(request('bundle_id') == $bundle->id ? 'selected' : ''); ?>>
                            <?php echo e($bundle->nama_paket); ?> — <?php echo e($bundle->items->count()); ?> unit
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div id="bundlePreview" class="mb-4 p-3 rounded" style="background:#161b22; border:1px solid #21262d; display:none;">
                    <div style="font-size:.75rem; color:#484f58; margin-bottom:6px; text-transform:uppercase; letter-spacing:.5px;">Isi Paket:</div>
                    <div id="bundleItemsList" style="font-size:.8rem; color:#8b949e; line-height:1.8;"></div>
                </div>

                <hr style="border-color:#21262d; margin: 20px 0;">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Nomor BSTP <span style="color:#f85149;">*</span></label>
                        <input type="text" name="no_bstp" class="form-control form-control-sm"
                            style="background:#161b22; border:1px solid #30363d; color:#c9d1d9; font-family:monospace;"
                            placeholder="001/BSTP/ICON+/2026" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Tanggal Serah Terima <span style="color:#f85149;">*</span></label>
                        <input type="date" name="tanggal_serah" class="form-control form-control-sm"
                            style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"
                            value="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Mitra / Penerima <span style="color:#f85149;">*</span></label>
                        <input type="text" name="penerima" class="form-control form-control-sm"
                            style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"
                            placeholder="Contoh: PT TUNAS ZETA UTAMA" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Lokasi / Site Tujuan <span style="color:#f85149;">*</span></label>
                        <input type="text" name="lokasi_tujuan" class="form-control form-control-sm"
                            style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"
                            placeholder="Contoh: Disdukcapil Pabuaran" required>
                    </div>
                </div>

                <div class="mt-4 pt-3 d-flex gap-2" style="border-top:1px solid #21262d;">
                    <button type="submit" class="btn btn-sm px-4" style="background:#238636; color:#fff; border:none; border-radius:6px;">
                        <i class="ti ti-file-download me-1"></i>Simpan & Generate BSTP
                    </button>
                    <a href="<?php echo e(route('bundle.index')); ?>" class="btn btn-sm px-3" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; border-radius:6px;">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-body p-0">
                <div class="px-4 py-3" style="border-bottom:1px solid #21262d;">
                    <span style="font-size:.82rem; font-weight:600; color:#c9d1d9;"><i class="ti ti-history me-2" style="color:#8b949e;"></i>Riwayat BSTP</span>
                </div>
                <table class="table table-dark table-hover mb-0" style="font-size:.78rem;">
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4">
                                <div style="color:#58a6ff; font-weight:600; font-family:monospace;"><?php echo e($rt->no_bstp); ?></div>
                                <div style="color:#8b949e; font-size:.72rem;"><?php echo e($rt->penerima); ?></div>
                                <div style="color:#484f58; font-size:.72rem;"><?php echo e($rt->tanggal_serah->format('d/m/Y')); ?></div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="<?php echo e(route('transactions.pdf', $rt->id)); ?>"
                                   class="btn btn-sm" style="background:#1a2a1a; color:#3fb950; border:1px solid #238636; font-size:.72rem; border-radius:6px;">
                                    <i class="ti ti-download me-1"></i>PDF
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td class="text-center py-4" style="color:#484f58;">Belum ada BSTP.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="p-3 text-center" style="border-top:1px solid #21262d;">
                    <a href="<?php echo e(route('transactions.index')); ?>" class="btn btn-sm w-100" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; font-size:.75rem; border-radius:6px;">
                        Lihat Semua Riwayat BSTP
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
document.getElementById('bundleSelect')?.addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    const preview = document.getElementById('bundlePreview');
    const list = document.getElementById('bundleItemsList');
    if (this.value) {
        const items = opt.dataset.items || '-';
        list.innerHTML = items.split(', ').map(i => `<span style="display:inline-block; background:#1c2128; border:1px solid #21262d; border-radius:4px; padding:2px 8px; margin:2px; font-size:.75rem;">${i}</span>`).join('');
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});
if (document.getElementById('bundleSelect')?.value) {
    document.getElementById('bundleSelect').dispatchEvent(new Event('change'));
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('welcome', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/transactions/create.blade.php ENDPATH**/ ?>