@extends('welcome')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0" style="color:#c9d1d9;"><i class="ti ti-list-details me-2" style="color:#58a6ff;"></i>Daftar Paket</h4>
        
    </div>
    <a href="{{ route('bundle.create') }}" class="btn btn-sm px-3" style="background:#1f6feb; color:#fff; border:none; border-radius:6px; font-size:.82rem;">
        <i class="ti ti-plus me-1"></i>Buat Paket Baru
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-dark table-hover mb-0" style="font-size:.82rem;">
            <thead>
                <tr style="color:#8b949e; border-bottom:1px solid #21262d;">
                    <th class="ps-4 py-3">Nama Paket</th>
                    <th>Jumlah Perangkat</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th class="text-center pe-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bundles as $bundle)
                <tr>
                    <td class="ps-4 fw-bold" style="color:#c9d1d9;">{{ $bundle->nama_paket }}</td>
                    <td>
                        <span style="color:#58a6ff; font-weight:600;">{{ $bundle->items->count() }}</span>
                        <span style="color:#484f58;"> unit</span>
                    </td>
                    <td style="color:#8b949e;">{{ $bundle->keterangan ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $bundle->status_badge_class }}" style="font-size:.72rem;">
                            {{ $bundle->status_label }}
                        </span>
                    </td>
                    <td style="color:#8b949e;">{{ $bundle->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center pe-4">
                        @if($bundle->status !== 'bstp_generated')
                        <a href="{{ route('transactions.create') }}?bundle_id={{ $bundle->id }}"
                           class="btn btn-sm" style="background:#1a2a1a; color:#3fb950; border:1px solid #238636; font-size:.73rem; border-radius:6px;">
                            <i class="ti ti-file-invoice me-1"></i>Generate BSTP
                        </a>
                        <form action="{{ route('bundle.destroy', $bundle->id) }}" method="POST" class="d-inline ms-1"
                              onsubmit="return confirm('Batalkan paket ini? Semua aset dikembalikan ke Ready.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm"
                                style="background:#1c2128; color:#f85149; border:1px solid #30363d; font-size:.73rem; border-radius:6px;">
                                Batalkan
                            </button>
                        </form>
                        @else
                        <span style="font-size:.75rem; color:#484f58;"><i class="ti ti-check me-1"></i>Selesai</span>
                        @endif
                    </td>
                </tr>
                {{-- Detail items accordion-like --}}
                @if($bundle->items->count() > 0)
                <tr style="border-bottom:1px solid #21262d;">
                    <td colspan="6" class="ps-4 pb-3 pt-0" style="background:#0e1117;">
                        <div style="font-size:.75rem; color:#484f58; margin-bottom:4px;">Isi paket:</div>
                        <div class="d-flex flex-wrap gap-1">
                        @foreach($bundle->items as $item)
                            @if($item->asset)
                            <span style="background:#1c2128; border:1px solid #21262d; border-radius:4px; padding:2px 8px; font-size:.73rem; color:#8b949e;">
                                <code style="color:#58a6ff; font-size:.7rem;">{{ $item->asset->serial_number }}</code>
                                · {{ $item->asset->nama_perangkat }}
                            </span>
                            @endif
                        @endforeach
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#484f58;">
                        <i class="ti ti-packages" style="font-size:2rem; display:block; margin-bottom:8px; opacity:.3;"></i>
                        Belum ada paket yang dibuat.<br>
                        <a href="{{ route('bundle.create') }}" style="color:#58a6ff; font-size:.82rem;">Buat paket pertama →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
