@extends('welcome')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-packages me-2" style="color:#58a6ff;"></i>Buat Transaksi Keluar</h4>
</div>

<form action="{{ route('bundle.store') }}" method="POST" id="bundleForm">
@csrf
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

                <div style="max-height: 400px; overflow-y: auto; padding-right:5px;">
                    
                    @php
                        $groupedAssets = $readyAssets->groupBy(function($item) {
                            return $item->nama_perangkat . '|||' . ($item->merk ?? '-');
                        });
                        $gIdx = 0;
                    @endphp

                    @forelse($groupedAssets as $key => $assets)
                        @php
                            $parts = explode('|||', $key);
                            $nama_perangkat = $parts[0];
                            $merk = $parts[1];
                            $gIdx++;
                            $stok = $assets->count();
                        @endphp

                        <div class="item-row mb-3 p-3 rounded" style="background:#161b22; border:1px solid #21262d;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div style="flex:1;">
                                    <div style="font-size:.85rem; color:#58a6ff; font-weight:600;">{{ $nama_perangkat }}</div>
                                    <div style="font-size:.73rem; color:#8b949e;">Merk: {{ $merk }} &middot; Stok: <span style="color:#3fb950; font-weight:600;">{{ $stok }}</span></div>
                                </div>
                                
                                <button type="button" class="btn btn-sm py-1 px-2" onclick="toggleSN({{ $gIdx }})" style="background:#0e1117; color:#8b949e; border:1px solid #30363d; font-size:.7rem;">
                                    <i class="ti ti-list-details me-1"></i>Pilih Manual
                                </button>

                                <div style="width:70px;">
                                    <input type="number" id="qty-{{ $gIdx }}" class="form-control form-control-sm text-center" style="background:#0e1117; border:1px solid #30363d; color:#c9d1d9; font-weight:bold;" value="0" min="0" max="{{ $stok }}" oninput="updateCheckboxes({{ $gIdx }})">
                                </div>
                            </div>

                            <div id="sn-list-{{ $gIdx }}" style="display:none; border-top:1px dashed #30363d; padding-top:10px; margin-top:5px;">
                                <div class="row g-2">
                                    @foreach($assets as $asset)
                                    <div class="col-md-6">
                                        <label class="d-flex align-items-center gap-2 p-2 rounded" style="background:#0e1117; border:1px solid #21262d; cursor:pointer;">
                                            <input type="checkbox" name="asset_ids[]" value="{{ $asset->id }}" class="form-check-input group-{{ $gIdx }} mt-0" style="background:#161b22; border-color:#30363d;" onchange="updateQtyInput({{ $gIdx }})">
                                            <div style="font-size:.75rem; color:#c9d1d9; font-family:monospace;">{{ $asset->serial_number }}</div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="text-center py-4" style="color:#484f58;">Tidak ada stok Ready di gudang.</div>
                    @endforelse

                </div>

                <div class="mt-4 pt-3 d-flex gap-2" style="border-top:1px solid #21262d;">
                    <button type="submit" class="btn btn-sm px-4" style="background:#1f6feb; color:#fff; border:none; border-radius:6px;">
                        <i class="ti ti-check me-1"></i>Proses Transaksi Keluar
                    </button>
                    <a href="{{ route('bundle.index') }}" class="btn btn-sm px-3" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; border-radius:6px;">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script>

    function toggleSN(groupId) {
        let list = document.getElementById('sn-list-' + groupId);
        if (list.style.display === 'none') {
            list.style.display = 'block';
        } else {
            list.style.display = 'none';
        }
    }


    function updateCheckboxes(groupId) {
        let input = document.getElementById('qty-' + groupId);
        let checkboxes = document.querySelectorAll('.group-' + groupId);
        let qty = parseInt(input.value) || 0;
        let max = checkboxes.length;


        if (qty > max) { qty = max; input.value = max; }
        if (qty < 0) { qty = 0; input.value = 0; }

        checkboxes.forEach((cb, index) => {
            cb.checked = (index < qty);
        });
    }


    function updateQtyInput(groupId) {
        let checkedCount = document.querySelectorAll('.group-' + groupId + ':checked').length;
        let input = document.getElementById('qty-' + groupId);
        input.value = checkedCount;
    }
</script>
@endsection