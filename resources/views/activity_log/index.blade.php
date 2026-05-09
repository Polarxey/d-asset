@extends('welcome')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-activity me-2" style="color:#8b949e;"></i>Log Activity</h4>
        <p class="mb-0" style="color:#8b949e; font-size:.85rem;">Seluruh aktivitas sistem — siapa, kapan, dan apa yang diubah.</p>
    </div>
    <span style="font-size:.78rem; color:#484f58; background:#161b22; border:1px solid #21262d; border-radius:6px; padding:4px 10px;">
        Total: {{ $logs->total() }} record
    </span>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-dark table-hover mb-0" style="font-size:.8rem;">
            <thead>
                <tr style="color:#8b949e; border-bottom:1px solid #21262d;">
                    <th class="ps-4 py-3" style="width:140px;">Waktu</th>
                    <th style="width:130px;">Aksi</th>
                    <th>Deskripsi</th>
                    <th style="width:140px;">Model</th>
                    <th style="width:100px;">Actor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="ps-4" style="color:#484f58; white-space:nowrap; font-family:monospace; font-size:.75rem;">
                        {{ $log->created_at->format('d/m/y') }}<br>
                        <span style="color:#8b949e;">{{ $log->created_at->format('H:i:s') }}</span>
                    </td>
                    <td>
                        @php
                            $badgeMap = [
                                'create_retur'  => ['bg:#3a2a1a; color:#e3b341', 'Retur Masuk'],
                                'create_baru'   => ['bg:#1a2a1a; color:#3fb950', 'Barang Baru'],
                                'edit_asset'    => ['bg:#1f2a3a; color:#58a6ff', 'Edit Aset'],
                                'delete_asset'  => ['bg:#3a1a1a; color:#f85149', 'Hapus Aset'],
                                'create_bundle' => ['bg:#1f2a3a; color:#58a6ff', 'Buat Paket'],
                                'delete_bundle' => ['bg:#3a1a1a; color:#f85149', 'Batalkan Paket'],
                                'generate_rma'  => ['bg:#2a1a2a; color:#d2a8ff', 'Generate RMA'],
                                'generate_bstp' => ['bg:#1a2a1a; color:#3fb950', 'Generate BSTP'],
                            ];
                            $badge = $badgeMap[$log->aksi] ?? ['bg:#21262d; color:#8b949e', $log->aksi];
                        @endphp
                        <span class="badge" style="{{ $badge[0] }}; font-size:.7rem; font-weight:500;">{{ $badge[1] }}</span>
                    </td>
                    <td style="color:#c9d1d9;">{{ $log->deskripsi }}</td>
                    <td style="color:#484f58; font-size:.75rem;">
                        @if($log->model_type)
                        <span style="font-family:monospace; color:#8b949e;">{{ $log->model_type }}</span>
                        @if($log->model_id)
                        <span style="color:#484f58;"> #{{ $log->model_id }}</span>
                        @endif
                        @else
                        -
                        @endif
                    </td>
                    <td style="color:#8b949e; font-size:.78rem;">{{ $log->actor }}</td>
                </tr>
                {{-- Expandable: data lama/baru jika ada --}}
                @if($log->data_lama || $log->data_baru)
                <tr style="border-bottom:1px solid #21262d;">
                    <td colspan="5" class="ps-4 pb-2 pt-0" style="background:#0e1117;">
                        <details style="font-size:.72rem;">
                            <summary style="color:#484f58; cursor:pointer; user-select:none;">Lihat perubahan data</summary>
                            <div class="row g-2 mt-1">
                                @if($log->data_lama)
                                <div class="col-md-6">
                                    <div style="color:#f85149; margin-bottom:3px; font-weight:600;">Sebelum:</div>
                                    <pre style="background:#1c0e0e; border:1px solid #3a1a1a; border-radius:4px; padding:8px; color:#f85149; font-size:.7rem; margin:0; overflow-x:auto;">{{ json_encode($log->data_lama, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                                @endif
                                @if($log->data_baru)
                                <div class="col-md-6">
                                    <div style="color:#3fb950; margin-bottom:3px; font-weight:600;">Sesudah:</div>
                                    <pre style="background:#0e1c0e; border:1px solid #1a3a1a; border-radius:4px; padding:8px; color:#3fb950; font-size:.7rem; margin:0; overflow-x:auto;">{{ json_encode($log->data_baru, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                                @endif
                            </div>
                        </details>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5" style="color:#484f58;">
                        <i class="ti ti-activity" style="font-size:2rem; display:block; margin-bottom:8px; opacity:.3;"></i>
                        Belum ada aktivitas yang dicatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-3 d-flex justify-content-end">
    {{ $logs->links() }}
</div>

<style>
.pagination .page-link { background:#161b22; border-color:#21262d; color:#8b949e; font-size:.8rem; }
.pagination .page-item.active .page-link { background:#1f6feb; border-color:#1f6feb; color:#fff; }
.pagination .page-link:hover { background:#21262d; color:#c9d1d9; }
</style>
@endsection
