@extends('welcome')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-packages me-2" style="color:#58a6ff;"></i>Buat Paket Keluar</h4>
    <p class="mb-0" style="color:#8b949e; font-size:.85rem;">Pilih perangkat dari stok <span style="color:#3fb950;">Ready</span> dan kelompokkan menjadi satu paket untuk di-BSTP-kan.</p>
</div>

<form action="{{ route('bundle.store') }}" method="POST" id="bundleForm">
@csrf
<div class="row g-3">
    {{-- Info Paket --}}
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-body p-4" style="background:#0e1117;">
                <div class="mb-3" style="font-size:.8rem; color:#8b949e; font-weight:600; text-transform:uppercase; letter-spacing:.8px; border-bottom:1px solid #21262d; padding-bottom:8px;">
                    Info Paket
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Nama Paket <span style="color:#f85149;">*</span></label>
                    <input type="text" name="nama_paket" class="form-control form-control-sm"
                        style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"
                        placeholder="Paket-Sumedang-001" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Keterangan</label>
                    <textarea name="keterangan" class="form-control form-control-sm" rows="3"
                        style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"
                        placeholder="Opsional: tujuan, proyek, dll."></textarea>
                </div>

                <div class="mt-4 p-3 rounded" style="background:#1f2a3a; border:1px solid #1f6feb;">
                    <div style="font-size:.78rem; color:#58a6ff; font-weight:600; margin-bottom:4px;">
                        <i class="ti ti-info-circle me-1"></i>Cara Kerja
                    </div>
                    <div style="font-size:.75rem; color:#8b949e; line-height:1.7;">
                        • Masukkan qty yang dibutuhkan per jenis perangkat<br>
                        • Sistem otomatis memilih unit dari stok Ready<br>
                        • Jika stok kurang, sistem pakai yang tersedia saja<br>
                        • Perangkat terpilih → status <em>Standby Keluar</em>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pilih Perangkat --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-body p-4" style="background:#0e1117;">
                <div class="mb-3 d-flex justify-content-between align-items-center" style="border-bottom:1px solid #21262d; padding-bottom:8px;">
                    <span style="font-size:.8rem; color:#8b949e; font-weight:600; text-transform:uppercase; letter-spacing:.8px;">Pilih Perangkat</span>
                    <span style="font-size:.75rem; color:#484f58;">Stok dari gudang (Ready)</span>
                </div>

                <div id="item-container">
                    @forelse($readyAssets as $idx => $group)
                    <div class="item-row mb-2 p-3 rounded" style="background:#161b22; border:1px solid #21262d;">
                        <div class="d-flex align-items-center gap-2">
                            <div style="flex:1;">
                                <div style="font-size:.82rem; color:#c9d1d9; font-weight:500;">{{ $group->nama_perangkat }}</div>
                                <div style="font-size:.73rem; color:#8b949e;">{{ $group->merk ?? 'No brand' }} &middot; Stok tersedia: <span style="color:#3fb950; font-weight:600;">{{ $group->stok_tersedia }}</span></div>
                                <input type="hidden" name="items[{{ $idx }}][nama_perangkat]" value="{{ $group->nama_perangkat }}">
                            </div>
                            <div style="width:90px;">
                                <label style="font-size:.7rem; color:#8b949e; display:block; margin-bottom:2px;">Qty</label>
                                <input type="number" name="items[{{ $idx }}][qty]"
                                    class="form-control form-control-sm text-center"
                                    style="background:#0e1117; border:1px solid #30363d; color:#c9d1d9;"
                                    value="0" min="0" max="{{ $group->stok_tersedia }}">
                            </div>
                            <div style="width:70px; text-align:center;">
                                <div style="font-size:.7rem; color:#8b949e; margin-bottom:2px;">Stok</div>
                                <div class="badge" style="background:#1a2a1a; color:#3fb950; font-size:.78rem;">{{ $group->stok_tersedia }}</div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5" style="color:#484f58;">
                        <i class="ti ti-package-off" style="font-size:2rem; display:block; margin-bottom:8px;"></i>
                        Tidak ada stok Ready di gudang.<br>
                        <a href="{{ route('barang_masuk.create') }}" style="color:#58a6ff; font-size:.82rem;">Tambah barang masuk baru →</a>
                    </div>
                    @endforelse
                </div>

                <div class="mt-4 pt-3 d-flex gap-2" style="border-top:1px solid #21262d;">
                    <button type="submit" class="btn btn-sm px-4" style="background:#1f6feb; color:#fff; border:none; border-radius:6px;">
                        <i class="ti ti-packages me-1"></i>Buat Paket
                    </button>
                    <a href="{{ route('bundle.index') }}" class="btn btn-sm px-3" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; border-radius:6px;">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script>
// Validasi: minimal 1 item qty > 0
document.getElementById('bundleForm').addEventListener('submit', function(e) {
    const qtys = document.querySelectorAll('input[type="number"]');
    const total = Array.from(qtys).reduce((sum, el) => sum + parseInt(el.value || 0), 0);
    if (total === 0) {
        e.preventDefault();
        alert('Masukkan setidaknya 1 qty untuk perangkat yang dipilih.');
    }
});
</script>
@endsection
