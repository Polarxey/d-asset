@extends('welcome')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-arrow-back-up me-2" style="color:#e3b341;"></i>Input Barang Retur</h4>
</div>

<div class="card">
    <div class="card-body p-4" style="background:#0e1117;">
        <form action="{{ route('rma.store') }}" method="POST">
            @csrf

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
                    <input type="text" name="id_pa" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="A1213..." required value="{{ old('id_pa') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Tanggal Masuk <span style="color:#f85149;">*</span></label>
                    <input type="date" name="tanggal_masuk" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Lokasi Asal <span style="color:#f85149;">*</span></label>
                    <input type="text" name="lokasi_asal" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Site Asal" required value="{{ old('lokasi_asal') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Customer Name <span style="color:#f85149;">*</span></label>
                    <input type="text" name="customer_name" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Nama Pelanggan" required value="{{ old('customer_name') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Valuation Type <span style="color:#f85149;">*</span></label>
                    <select name="valuation_type" class="form-select form-select-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" required>
                        <option value="" disabled selected>-- Pilih --</option>
                        <option value="Ex-Project" {{ old('valuation_type') == 'Ex-Project' ? 'selected' : '' }}>Ex-Project</option>
                        <option value="Dismantle" {{ old('valuation_type') == 'Dismantle' ? 'selected' : '' }}>Dismantle</option>
                        <option value="Rusak-L" {{ old('valuation_type') == 'Rusak-L' ? 'selected' : '' }}>Rusak-L</option>
                        <option value="Rusak-TL" {{ old('valuation_type') == 'Rusak-TL' ? 'selected' : '' }}>Rusak-TL</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Nama Perangkat <span style="color:#f85149;">*</span></label>
                    <input type="text" name="nama_perangkat" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Contoh: Switch" required value="{{ old('nama_perangkat') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Merk</label>
                    <input type="text" name="merk" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Contoh: Raisecom" value="{{ old('merk') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Tipe Perangkat <span style="color:#f85149;">*</span></label>
                    <input type="text" name="type" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="Contoh: ISCOM2600" required value="{{ old('type') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-size:.78rem; color:#8b949e;">Serial Number (S/N) <span style="color:#f85149;">*</span></label>
                    <input type="text" name="serial_number" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" placeholder="SN Perangkat" required value="{{ old('serial_number') }}">
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
@endsection