<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\TransaksiRma;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class RmaController extends Controller
{
    // Form input barang retur
    public function create()
    {
        return view('rma.create');
    }

    // Simpan barang retur
    public function store(Request $request)
    {
        $request->validate([
            'id_pa'          => 'required|string',
            'tanggal_masuk'  => 'required|date',
            'lokasi_asal'    => 'required|string',
            'customer_name'  => 'required|string',
            'merk'           => 'required|string',
            'serial_number'  => 'required|string',
            'nama_perangkat' => 'required|string',
            'valuation_type' => 'required|string',
        ]);

        // 1. Upsert ke tabel Master Assets — status Standby, sumber retur
        $asset = Asset::updateOrCreate(
            ['serial_number' => $request->serial_number],
            [
                'nama_perangkat' => $request->nama_perangkat,
                'merk'           => $request->merk,
                'id_pa'          => $request->id_pa,
                'customer_name'  => $request->customer_name,
                'lokasi_asal'    => $request->lokasi_asal,
                'lokasi'         => $request->lokasi_asal,
                'valuation_type' => $request->valuation_type,
                'sumber'         => Asset::SUMBER_RETUR,
                'status'         => Asset::STATUS_STANDBY,
                'tanggal_masuk'  => $request->tanggal_masuk,
            ]
        );

        // 2. Simpan ke riwayat transaksi RMA
        TransaksiRma::create([
            'id_pa'          => $request->id_pa,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'lokasi_asal'    => $request->lokasi_asal,
            'customer_name'  => $request->customer_name,
            'merk'           => $request->merk,
            'serial_number'  => $request->serial_number,
            'nama_perangkat' => $request->nama_perangkat,
            'valuation_type' => $request->valuation_type,
            'asset_id'       => $asset->id,
            'status_proses'  => 'Pending',
        ]);

        // 3. Log activity
        ActivityLog::catat(
            'create_retur',
            "Barang retur S/N {$request->serial_number} ({$request->nama_perangkat}) ditambahkan sebagai Standby Masuk",
            'Asset', $asset->id,
            null,
            $asset->toArray()
        );

        return redirect()->route('assets.index')
            ->with('success', "Barang retur S/N {$request->serial_number} berhasil didata dan masuk Standby Masuk!");
    }

    // Form generate RMA — pilih dari Standby Masuk
    public function generateForm($assetId)
    {
        $asset = Asset::standbyMasuk()->findOrFail($assetId);
        $rmaRecord = TransaksiRma::where('asset_id', $assetId)->latest()->first();

        // Auto-generate nomor RMA
        $lastRma = TransaksiRma::whereNotNull('no_rma')->latest()->first();
        $nextNum = $lastRma
            ? (intval(substr($lastRma->no_rma, -3)) + 1)
            : 1;
        $autoNoRma = 'RMA/' . date('Y') . '/' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        return view('rma.generate', compact('asset', 'rmaRecord', 'autoNoRma'));
    }

    // Generate PDF dan ubah status ke Ready
    public function generatePdf(Request $request, $assetId)
    {
        $asset = Asset::findOrFail($assetId);
        $rmaRecord = TransaksiRma::where('asset_id', $assetId)->latest()->firstOrFail();

        $noRma      = $request->no_rma ?? 'RMA/' . date('Y') . '/001';
        $tanggalRma = $request->tanggal_rma ?? date('Y-m-d');

        // Update record RMA
        $rmaRecord->update([
            'no_rma'       => $noRma,
            'tanggal_rma'  => $tanggalRma,
            'status_proses'=> 'Completed',
        ]);

        // Status asset pindah: Standby Masuk → Ready (masuk gudang)
        $asset->update([
            'status' => Asset::STATUS_READY,
            'lokasi' => 'Gudang',
        ]);

        ActivityLog::catat(
            'generate_rma',
            "RMA {$noRma} diterbitkan untuk S/N {$asset->serial_number}. Status berubah: Standby Masuk → Ready (Gudang)",
            'TransaksiRma', $rmaRecord->id,
            ['status' => Asset::STATUS_STANDBY],
            ['status' => Asset::STATUS_READY, 'no_rma' => $noRma]
        );

        // Load logo ke base64
        $logoPath   = public_path('img/logo-icon.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $pdf = Pdf::loadView('pdf.rma', compact('asset', 'rmaRecord', 'noRma', 'tanggalRma', 'logoBase64'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download("RMA_{$asset->serial_number}.pdf");
    }
}
