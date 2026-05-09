@extends('welcome')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#c9d1d9;">Master Asset(s)</h4>
        <p class="mb-0" style="color:#8b949e; font-size:.85rem;">Pusat informasi seluruh perangkat</p>
    </div>
</div>

{{-- Tab Navigation --}}
<ul class="nav mb-3" id="assetTab" role="tablist" style="gap:4px; border-bottom:1px solid #21262d; padding-bottom:0;">
    <li class="nav-item">
        <button class="nav-link active px-3 py-2" id="standby-masuk-tab" data-bs-toggle="tab" data-bs-target="#standby-masuk" type="button"
            style="font-size:.82rem; border:none; border-bottom:2px solid #e3b341; background:transparent; color:#e3b341; border-radius:0; font-weight:600;">
            <i class="ti ti-arrow-back-up me-1"></i>Standby Masuk
            <span class="badge ms-1" style="background:#e3b34120; color:#e3b341; font-size:.7rem;">{{ $totalStandbyMasuk }}</span>
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link px-3 py-2" id="ready-tab" data-bs-toggle="tab" data-bs-target="#ready" type="button"
            style="font-size:.82rem; border:none; background:transparent; color:#8b949e; border-radius:0; border-bottom:2px solid transparent;">
            <i class="ti ti-package me-1"></i>Ready (Gudang)
            <span class="badge ms-1" style="background:#3fb95020; color:#3fb950; font-size:.7rem;">{{ $totalReady }}</span>
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link px-3 py-2" id="standby-keluar-tab" data-bs-toggle="tab" data-bs-target="#standby-keluar" type="button"
            style="font-size:.82rem; border:none; background:transparent; color:#8b949e; border-radius:0; border-bottom:2px solid transparent;">
            <i class="ti ti-packages me-1"></i>Standby Keluar
            <span class="badge ms-1" style="background:#58a6ff20; color:#58a6ff; font-size:.7rem;">{{ $totalStandbyKeluar }}</span>
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link px-3 py-2" id="used-tab" data-bs-toggle="tab" data-bs-target="#used" type="button"
            style="font-size:.82rem; border:none; background:transparent; color:#8b949e; border-radius:0; border-bottom:2px solid transparent;">
            <i class="ti ti-map-pin me-1"></i>Terpasang (Used)
            <span class="badge ms-1" style="background:#8b949e20; color:#8b949e; font-size:.7rem;">{{ $totalUsed }}</span>
        </button>
    </li>
</ul>

<div class="tab-content" id="assetTabContent">

    {{-- TAB 1: Standby Masuk (dari retur) --}}
    <div class="tab-pane fade show active" id="standby-masuk">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-dark table-hover mb-0" style="font-size:.82rem;">
                    <thead>
                        <tr style="color:#8b949e; border-bottom:1px solid #21262d;">
                            <th class="ps-4 py-3">S/N</th>
                            <th>Nama Perangkat</th>
                            <th>Merk</th>
                            <th>ID PA</th>
                            <th>Customer (CPE)</th>
                            <th>Lokasi Asal</th>
                            <th>Tgl Masuk</th>
                            <th>Valuation</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($standbyMasukAssets as $item)
                        <tr>
                            <td class="ps-4 fw-bold" style="color:#58a6ff;">{{ $item->serial_number }}</td>
                            <td>{{ $item->nama_perangkat }}</td>
                            <td style="color:#8b949e;">{{ $item->merk ?? '-' }}</td>
                            <td><code style="color:#e3b341; font-size:.78rem;">{{ $item->id_pa ?? '-' }}</code></td>
                            <td>{{ $item->customer_name ?? '-' }}</td>
                            <td style="color:#8b949e;">{{ $item->lokasi_asal ?? '-' }}</td>
                            <td style="color:#8b949e;">{{ $item->tanggal_masuk?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                @if($item->valuation_type)
                                <span class="badge" style="background:#3a1a1a; color:#f85149; font-size:.7rem;">{{ $item->valuation_type }}</span>
                                @else
                                <span style="color:#484f58;">-</span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('rma.generate.form', $item->id) }}"
                                   class="btn btn-sm" style="background:#1f3a2a; color:#3fb950; border:1px solid #238636; font-size:.75rem; border-radius:6px;">
                                    <i class="ti ti-file-text me-1"></i>Generate RMA
                                </a>
                                <button class="btn btn-sm ms-1" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; font-size:.75rem; border-radius:6px;"
                                    data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">Edit</button>
                                <form action="{{ route('assets.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus aset S/N {{ $item->serial_number }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm ms-1"
                                        style="background:#1c2128; color:#f85149; border:1px solid #30363d; font-size:.75rem; border-radius:6px;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center py-5" style="color:#484f58;">Tidak ada barang retur yang menunggu proses.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TAB 2: Ready (Gudang) --}}
    <div class="tab-pane fade" id="ready">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-dark table-hover mb-0" style="font-size:.82rem;">
                    <thead>
                        <tr style="color:#8b949e; border-bottom:1px solid #21262d;">
                            <th class="ps-4 py-3">S/N</th>
                            <th>Nama Perangkat</th>
                            <th>Merk</th>
                            <th>Sumber</th>
                            <th>Lokasi</th>
                            <th>Tgl Masuk</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($readyAssets as $item)
                        <tr>
                            <td class="ps-4 fw-bold" style="color:#58a6ff;">{{ $item->serial_number }}</td>
                            <td>{{ $item->nama_perangkat }}</td>
                            <td style="color:#8b949e;">{{ $item->merk ?? '-' }}</td>
                            <td>
                                <span class="badge" style="background:{{ $item->sumber === 'retur' ? '#3a2a1a' : '#1a2a1a' }}; color:{{ $item->sumber === 'retur' ? '#e3b341' : '#3fb950' }}; font-size:.7rem;">
                                    {{ $item->sumber === 'retur' ? 'Retur' : 'Baru' }}
                                </span>
                            </td>
                            <td><em style="color:#484f58; font-style:italic; opacity:.7;">Gudang</em></td>
                            <td style="color:#8b949e;">{{ $item->tanggal_masuk?->format('d/m/Y') ?? '-' }}</td>
                            <td class="text-center pe-4">
                                <button class="btn btn-sm" style="background:#1c2128; color:#8b949e; border:1px solid #30363d; font-size:.75rem; border-radius:6px;"
                                    data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">Edit</button>
                                <form action="{{ route('assets.destroy', $item->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus aset S/N {{ $item->serial_number }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm ms-1"
                                        style="background:#1c2128; color:#f85149; border:1px solid #30363d; font-size:.75rem; border-radius:6px;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-5" style="color:#484f58;">Gudang kosong. Belum ada barang Ready.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TAB 3: Standby Keluar (sudah masuk paket) --}}
    <div class="tab-pane fade" id="standby-keluar">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-dark table-hover mb-0" style="font-size:.82rem;">
                    <thead>
                        <tr style="color:#8b949e; border-bottom:1px solid #21262d;">
                            <th class="ps-4 py-3">S/N</th>
                            <th>Nama Perangkat</th>
                            <th>Merk</th>
                            <th>Tgl Masuk</th>
                            <th class="text-center pe-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($standbyKeluarAssets as $item)
                        <tr>
                            <td class="ps-4 fw-bold" style="color:#58a6ff;">{{ $item->serial_number }}</td>
                            <td>{{ $item->nama_perangkat }}</td>
                            <td style="color:#8b949e;">{{ $item->merk ?? '-' }}</td>
                            <td style="color:#8b949e;">{{ $item->tanggal_masuk?->format('d/m/Y') ?? '-' }}</td>
                            <td class="text-center pe-4">
                                <span class="badge" style="background:#1f2a3a; color:#58a6ff; font-size:.7rem;">Dalam Paket</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-5" style="color:#484f58;">Tidak ada barang dalam status Standby Keluar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TAB 4: Used / Terpasang --}}
    <div class="tab-pane fade" id="used">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-dark table-hover mb-0" style="font-size:.82rem;">
                    <thead>
                        <tr style="color:#8b949e; border-bottom:1px solid #21262d;">
                            <th class="ps-4 py-3">S/N</th>
                            <th>Nama Perangkat</th>
                            <th>Merk</th>
                            <th>Penerima</th>
                            <th>Lokasi Terpasang</th>
                            <th>Tgl Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usedAssets as $item)
                        <tr>
                            <td class="ps-4 fw-bold" style="color:#58a6ff;">{{ $item->serial_number }}</td>
                            <td>{{ $item->nama_perangkat }}</td>
                            <td style="color:#8b949e;">{{ $item->merk ?? '-' }}</td>
                            <td>{{ $item->penerima ?? '-' }}</td>
                            <td>{{ $item->lokasi ?? '-' }}</td>
                            <td style="color:#8b949e;">{{ $item->tanggal_keluar?->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-5" style="color:#484f58;">Belum ada perangkat terpasang.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- EDIT MODALS --}}
@foreach(array_merge($standbyMasukAssets->all(), $readyAssets->all()) as $item)
<div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background:#161b22; border:1px solid #30363d;">
            <div class="modal-header" style="border-bottom:1px solid #21262d;">
                <h6 class="modal-title" style="color:#c9d1d9;">Edit Aset: <code style="color:#58a6ff;">{{ $item->serial_number }}</code></h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('assets.update', $item->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body" style="background:#0e1117;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:.78rem; color:#8b949e;">Serial Number</label>
                            <input type="text" name="serial_number" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="{{ $item->serial_number }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:.78rem; color:#8b949e;">Nama Perangkat</label>
                            <input type="text" name="nama_perangkat" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="{{ $item->nama_perangkat }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:.78rem; color:#8b949e;">Merk</label>
                            <input type="text" name="merk" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="{{ $item->merk }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:.78rem; color:#8b949e;">Status</label>
                            <select name="status" class="form-select form-select-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;">
                                <option value="Standby" {{ $item->status == 'Standby' ? 'selected' : '' }}>Standby (Masuk)</option>
                                <option value="Ready" {{ $item->status == 'Ready' ? 'selected' : '' }}>Ready (Gudang)</option>
                                <option value="Used" {{ $item->status == 'Used' ? 'selected' : '' }}>Used (Terpasang)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:.78rem; color:#8b949e;">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="{{ $item->tanggal_masuk?->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" style="font-size:.78rem; color:#8b949e;">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control form-control-sm" style="background:#161b22; border:1px solid #30363d; color:#c9d1d9;" value="{{ $item->lokasi }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #21262d; background:#161b22;">
                    <button type="submit" class="btn btn-sm" style="background:#238636; color:#fff; border:none; border-radius:6px; padding:6px 16px;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
// Tab styling — active state
document.querySelectorAll('#assetTab button').forEach(btn => {
    btn.addEventListener('shown.bs.tab', function() {
        document.querySelectorAll('#assetTab button').forEach(b => {
            b.style.color = '#8b949e';
            b.style.borderBottom = '2px solid transparent';
            b.style.fontWeight = 'normal';
        });
        this.style.borderBottom = '2px solid ' + this.dataset.color;
        this.style.fontWeight = '600';
    });
});
document.querySelectorAll('#assetTab button')[0].dataset.color = '#e3b341';
document.querySelectorAll('#assetTab button')[1].dataset.color = '#3fb950';
document.querySelectorAll('#assetTab button')[2].dataset.color = '#58a6ff';
document.querySelectorAll('#assetTab button')[3].dataset.color = '#8b949e';
</script>
@endsection
