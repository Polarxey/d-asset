@extends('welcome')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-history me-2" style="color:#8b949e;"></i>Riwayat BSTP</h4>
        
    </div>
    <a href="{{ route('transactions.create') }}" class="btn btn-sm px-3" style="background:#238636; color:#fff; border:none; border-radius:6px; font-size:.82rem;">
        <i class="ti ti-plus me-1"></i>Generate BSTP Baru
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-dark table-hover mb-0" style="font-size:.82rem;">
            <thead>
                <tr style="color:#8b949e; border-bottom:1px solid #21262d;">
                    <th class="ps-4 py-3">No. BSTP</th>
                    <th>Penerima</th>
                    <th>Lokasi Tujuan</th>
                    <th>Tanggal Serah</th>
                    <th>Jumlah Jenis</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                <tr>
                    <td class="ps-4"><code style="color:#58a6ff;">{{ $t->no_bstp }}</code></td>
                    <td>{{ $t->penerima }}</td>
                    <td style="color:#8b949e;">{{ $t->lokasi_tujuan }}</td>
                    <td style="color:#8b949e;">{{ $t->tanggal_serah->format('d/m/Y') }}</td>
                    <td>
                        <span style="color:#c9d1d9; font-weight:600;">{{ $t->details->count() }}</span>
                        <span style="color:#484f58;"> jenis perangkat</span>
                    </td>
                    <td class="text-center pe-4">
                        <a href="{{ route('transactions.pdf', $t->id) }}"
                           class="btn btn-sm" style="background:#1a2a1a; color:#3fb950; border:1px solid #238636; font-size:.75rem; border-radius:6px;">
                            <i class="ti ti-download me-1"></i>PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#484f58;">
                        <i class="ti ti-file-off" style="font-size:2rem; display:block; margin-bottom:8px; opacity:.3;"></i>
                        Belum ada BSTP yang diterbitkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
