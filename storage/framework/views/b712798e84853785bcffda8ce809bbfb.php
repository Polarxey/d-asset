<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-arrow-back-up me-2" style="color:#e3b341;"></i>Input Barang Retur</h4>
    <p class="mb-0" style="color:#8b949e; font-size:.85rem;">Barang ex-proyek, dismantle, atau rusak dari lapangan. Otomatis masuk <span style="color:#e3b341;">Standby Masuk</span>.</p>
</div>

<div class="card">
    <div class="card-body p-4" style="background:#0e1117;">
        <form action="<?php echo e(route('rma.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">ID PA <span style="color:#f85149;">*</span></label>
                    <input type="text" name="id_pa" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="A121303001099" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Tanggal Masuk <span style="color:#f85149;">*</span></label>
                    <input type="date" name="tanggal_masuk" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="<?php echo e(date('Y-m-d')); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Lokasi Asal <span style="color:#f85149;">*</span></label>
                    <input type="text" name="lokasi_asal" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="KAB. SUMEDANG" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Customer Name (CPE) <span style="color:#f85149;">*</span></label>
                    <input type="text" name="customer_name" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="PLN IP UBP JATIGEDE" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Valuation Type <span style="color:#f85149;">*</span></label>
                    <select name="valuation_type" class="form-select form-select-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" required>
                        <option value="" disabled selected>-- Pilih Jenis --</option>
                        <option value="Ex-Project">Ex-Project</option>
                        <option value="Dismantle">Dismantle</option>
                        <option value="Rusak-L">Rusak-L (Layanan)</option>
                        <option value="Rusak-TL">Rusak-TL (Tidak Layanan)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Nama Perangkat <span style="color:#f85149;">*</span></label>
                    <input type="text" name="nama_perangkat" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Switch FH10 / OTB" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Merk <span style="color:#f85149;">*</span></label>
                    <input type="text" name="merk" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Raisecom / Nokia / Huawei" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e; text-transform:uppercase; letter-spacing:.5px;">Serial Number (S/N) <span style="color:#f85149;">*</span></label>
                    <input type="text" name="serial_number" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9; font-family:monospace;" placeholder="NYGGWJ600271" required>
                </div>
            </div>

            <div class="mt-4 pt-3 d-flex gap-2" style="border-top:1px solid #21262d;">
                <button type="submit" class="btn btn-sm px-4" style="background:#9a6700; color:#fff; border:none; border-radius:6px;">
                    <i class="ti ti-device-floppy me-1"></i>Simpan Data Retur
                </button>
                <a href="<?php echo e(route('assets.index')); ?>" class="btn btn-sm px-3" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; border-radius:6px;">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('welcome', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\WINDOWS\XAMPP\htdocs\d-asset\resources\views/rma/create.blade.php ENDPATH**/ ?>