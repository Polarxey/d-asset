<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\TransaksiRma;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RmaController extends Controller
{
    public function index()
    {
        // Menampilkan barang yang menunggu di-RMA (Standby Masuk)
        $assets = Asset::standbyMasuk()->latest()->get();
        return view('rma.index', compact('assets'));
    }

    public function history()
    {
        // Menampilkan riwayat RMA yang sudah SELESAI (Completed)
        $history = TransaksiRma::with('asset')->where('status_proses', 'Completed')->latest()->get();
        return view('rma.history', compact('history'));
    }

    // INI FUNGSI YANG TADI HILANG BUAT BUKA FORM INPUT
    public function create()
    {
        return view('rma.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|unique:assets,serial_number',
            'id_pa'         => 'required',
            'nama_perangkat' => 'required',
            'type'          => 'required',
        ], [
            'serial_number.unique' => 'S/N ini sudah ada di database!',
        ]);

        // 1. Simpan ke tabel Assets
        $asset = Asset::create([
            'serial_number'  => $request->serial_number,
            'nama_perangkat' => $request->nama_perangkat,
            'merk'           => $request->merk,
            'type'           => $request->type,
            'sumber'         => 'retur',
            'status'         => 'Standby',
            'id_pa'          => $request->id_pa,
            'customer_name'  => $request->customer_name,
            'lokasi_asal'    => $request->lokasi_asal,
            'valuation_type' => $request->valuation_type,
            'tanggal_masuk'  => $request->tanggal_masuk,
        ]);

        // 2. Buat record awal di tabel Transaksi RMA (Status Pending)
        TransaksiRma::create([
            'asset_id'       => $asset->id,
            'id_pa'          => $asset->id_pa,
            'tanggal_masuk'  => $asset->tanggal_masuk,
            'lokasi_asal'    => $asset->lokasi_asal,
            'customer_name'  => $asset->customer_name,
            'valuation_type' => $asset->valuation_type,
            'status_proses'  => 'Pending'
        ]);

        ActivityLog::catat(
            'create_retur',
            "Barang retur S/N {$asset->serial_number} didata sebagai Standby Masuk",
            'Asset', $asset->id, null, $asset->toArray()
        );

        return redirect()->route('rma.index')->with('success', 'Data retur berhasil disimpan!');
    }

    // INI FUNGSI YANG TADI HILANG BUAT BUKA FORM GENERATE NOMOR RMA
    public function generateForm($assetId)
    {
        $asset = Asset::findOrFail($assetId);
        $autoNoRma = 'RMA-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        
        return view('rma.generate', compact('asset', 'autoNoRma'));
    }

    public function generatePdf(Request $request, $assetId)
    {
        $asset = Asset::findOrFail($assetId);
        $rma = TransaksiRma::where('asset_id', $assetId)->first();
        
        $dataLama = $asset->toArray();

        // 1. Update status Asset jadi Ready & Gudang
        $asset->update([
            'status' => 'Ready',
            'lokasi' => 'Gudang'
        ]);

        // 2. Update status Transaksi RMA jadi Completed & simpan No RMA
        if ($rma) {
            $rma->update([
                'status_proses' => 'Completed',
                'no_rma'        => $request->no_rma,
                'tanggal_rma'   => $request->tanggal_rma,
            ]);
        }

        ActivityLog::catat(
            'generate_rma',
            "RMA dicetak untuk S/N {$asset->serial_number}. Barang masuk Gudang.",
            'Asset', $asset->id, $dataLama, $asset->fresh()->toArray()
        );

        $pdf = Pdf::loadView('pdf.rma', compact('asset', 'request'));
        return $pdf->download('RMA_' . $asset->serial_number . '.pdf');
    }
}