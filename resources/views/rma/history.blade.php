@extends('welcome')

@section('content')
<div class="mb-4 d-flex align-items-center gap-3">
    <a href="{{ route('rma.index') }}" class="btn btn-sm" style="background:#161b22; color:#8b949e; border:1px solid #30363d;"><i class="ti ti-arrow-left"></i></a>
    <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-history me-2" style="color:#58a6ff;"></i>Riwayat RMA</h4>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-dark table-hover mb-0" style="font-size:.82rem;">
            <thead>
                <tr style="color:#8b949e; border-bottom:1px solid #21262d;">
                    <th class="ps-4 py-3">No RMA</th>
                    <th>S/N</th>
                    <th>Nama Perangkat</th>
                    <th>ID PA</th>
                    <th>Customer</th>
                    <th>Tgl Cetak</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                <tr>
                    <td class="ps-4 fw-bold" style="color:#58a6ff;">{{ $item->no_rma ?? '-' }}</td>
                    
                    <td>{{ $item->asset?->serial_number ?? $item->serial_number ?? '-' }}</td>
                    <td>{{ $item->asset?->nama_perangkat ?? $item->nama_perangkat ?? '-' }}</td>
                    
                    <td><code style="color:#e3b341;">{{ $item->id_pa }}</code></td>
                    <td>{{ $item->customer_name }}</td>
                    <td style="color:#8b949e;">{{ $item->tanggal_rma ? \Carbon\Carbon::parse($item->tanggal_rma)->format('d/m/Y') : '-' }}</td>
                    <td class="text-center pe-4">
                        <div class="d-flex justify-content-center gap-2">
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 d-flex align-items-center">Completed</span>
                            
                            <a href="{{ route('rma.download_pdf', $item->id) }}" class="btn btn-sm py-1 px-2" style="background:#1a2a1a; color:#3fb950; border:1px solid #238636; font-size:.7rem;">
                                <i class="ti ti-download me-1"></i>PDF
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:#484f58;">
                        <i class="ti ti-clipboard-x d-block mb-2" style="font-size:2rem;"></i>
                        Belum ada riwayat cetak RMA.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection