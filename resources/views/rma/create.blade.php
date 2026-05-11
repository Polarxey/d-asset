@extends('welcome')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-arrow-back-up me-2" style="color:#e3b341;"></i>Input Barang Retur</h4>
</div>

<div class="card mb-4" style="border: 1px dashed #30363d; background:#0e1117;">
    <div class="card-body p-3">
        <label class="form-label" style="font-size:.78rem; color:#58a6ff; font-weight:600;">CARI DARI BARANG TERPASANG (USED)</label>
        <div class="position-relative">
            <input type="text" id="searchUsed" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Ketik S/N atau Lokasi barang untuk mencari...">
            <div id="searchResult" class="list-group position-absolute w-100 mt-1 d-none" style="z-index: 1000; max-height: 200px; overflow-y: auto; background: #161b22; border: 1px solid #30363d;">
                </div>
        </div>
        <div style="font-size:.72rem; color:#8b949e; margin-top:6px;">*Opsional. Kosongkan bagian ini jika barang belum pernah terdata dan ingin input manual.</div>
    </div>
</div>

<div class="card">
    <div class="card-body p-4" style="background:#0e1117;">
        <form action="{{ route('rma.store') }}" method="POST">
            @csrf
            <input type="hidden" name="asset_id" id="asset_id">

            @if ($errors->any())
            <div class="alert alert-danger mb-3" style="background:#3a1a1a; border:1px solid #da3633; color:#f85149; font-size:.82rem;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">ID PA <span style="color:#f85149;">*</span></label>
                    <input type="text" name="id_pa" id="id_pa" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"required value="{{ old('id_pa') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Tanggal Masuk <span style="color:#f85149;">*</span></label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Lokasi Asal <span style="color:#f85149;">*</span></label>
                    <input type="text" name="lokasi_asal" id="lokasi_asal" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"required value="{{ old('lokasi_asal') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Customer Name <span style="color:#f85149;">*</span></label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" required value="{{ old('customer_name') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Valuation Type <span style="color:#f85149;">*</span></label>
                    <select name="valuation_type" id="valuation_type" class="form-select form-select-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" required>
                        <option value="" disabled selected>-- Pilih --</option>
                        <option value="Ex-Project" {{ old('valuation_type') == 'Ex-Project' ? 'selected' : '' }}>Ex-Project</option>
                        <option value="Dismantle" {{ old('valuation_type') == 'Dismantle' ? 'selected' : '' }}>Dismantle</option>
                        <option value="Rusak-L" {{ old('valuation_type') == 'Rusak-L' ? 'selected' : '' }}>Rusak-L</option>
                        <option value="Rusak-TL" {{ old('valuation_type') == 'Rusak-TL' ? 'selected' : '' }}>Rusak-TL</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Nama Perangkat <span style="color:#f85149;">*</span></label>
                    <input type="text" name="nama_perangkat" id="nama_perangkat" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"required value="{{ old('nama_perangkat') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Merk</label>
                    <input type="text" name="merk" id="merk" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"value="{{ old('merk') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Tipe Perangkat <span style="color:#f85149;">*</span></label>
                    <input type="text" name="type" id="type" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"required value="{{ old('type') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Serial Number (S/N) <span style="color:#f85149;">*</span></label>
                    <input type="text" name="serial_number" id="serial_number" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;"required value="{{ old('serial_number') }}">
                </div>
            </div>

            <div class="mt-4 pt-3 d-flex gap-2" style="border-top:1px solid #21262d;">
                <button type="submit" class="btn btn-sm px-4" style="background:#9a6700; color:#fff; border:none; border-radius:6px;">
                    <i class="ti ti-device-floppy me-1"></i>Simpan Data Retur
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('searchUsed').addEventListener('input', function() {
    let query = this.value;
    let resultDiv = document.getElementById('searchResult');

    if (query.length < 2) {
        resultDiv.classList.add('d-none');
        return;
    }

    fetch(`{{ route('rma.search_used') }}?q=${query}`)
        .then(response => response.json())
        .then(data => {
            resultDiv.innerHTML = '';
            if (data.length > 0) {
                resultDiv.classList.remove('d-none');
                data.forEach(asset => {
                    let btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'list-group-item list-group-item-action bg-dark text-white border-secondary p-2 small';
                    btn.innerHTML = `<div class="fw-bold">${asset.serial_number}</div><div class="text-muted" style="font-size:10px">${asset.nama_perangkat} - Lokasi: ${asset.lokasi ?? '-'}</div>`;
                    
                    btn.onclick = (e) => {
                        e.preventDefault();
                        
                        // Sistem akan mengisi form otomatis di sini
                        document.getElementById('asset_id').value = asset.id;
                        document.getElementById('serial_number').value = asset.serial_number;
                        document.getElementById('nama_perangkat').value = asset.nama_perangkat;
                        
                        if(asset.merk) document.getElementById('merk').value = asset.merk;
                        if(asset.type) document.getElementById('type').value = asset.type;
                        if(asset.id_pa) document.getElementById('id_pa').value = asset.id_pa;
                        if(asset.customer_name) document.getElementById('customer_name').value = asset.customer_name;
                        if(asset.lokasi) document.getElementById('lokasi_asal').value = asset.lokasi;
                        
                        resultDiv.classList.add('d-none');
                        document.getElementById('searchUsed').value = asset.serial_number;
                    };
                    resultDiv.appendChild(btn);
                });
            } else {
                resultDiv.classList.add('d-none');
            }
        });
});

// Sembunyikan hasil pencarian kalau klik di luar area
document.addEventListener('click', function(e) {
    if (!document.getElementById('searchUsed').contains(e.target) && !document.getElementById('searchResult').contains(e.target)) {
        document.getElementById('searchResult').classList.add('d-none');
    }
});
</script>
@endsection