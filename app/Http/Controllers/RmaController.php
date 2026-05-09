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
        $assets = Asset::standbyMasuk()->latest()->get();
        return view('rma.index', compact('assets'));
    }

    public function create()
    {
        return view('rma.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|unique:assets,serial_number',
            'id_pa'         => 'required',
        ]);

        $asset = Asset::create([
            'serial_number'  => $request->serial_number,
            'nama_perangkat' => $request->nama_perangkat,
            'merk'           => $request->merk,
            'sumber'         => 'retur',
            'status'         => 'Standby',
            'id_pa'          => $request->id_pa,
            'customer_name'  => $request->customer_name,
            'lokasi_asal'    => $request->lokasi_asal,
            'valuation_type' => $request->valuation_type,
            'tanggal_masuk'  => $request->tanggal_masuk,
        ]);

        $rma = TransaksiRma::create(array_merge(
            $request->all(),
            ['asset_id' => $asset->id, 'status_proses' => 'Pending']
        ));

        ActivityLog::catat(
            'create_retur',
            "Barang retur S/N {$asset->serial_number} didata sebagai Standby Masuk",
            'Asset', $asset->id, null, $asset->toArray()
        );

        return redirect()->route('rma.index')->with('success', 'Data retur berhasil disimpan.');
    }

    public function generateForm($assetId)
    {
        $asset = Asset::findOrFail($assetId);
        $rma = TransaksiRma::where('asset_id', $assetId)->firstOrFail();
        
        return view('rma.generate', compact('asset', 'rma'));
    }

    public function generatePdf(Request $request, $assetId)
    {
        $asset = Asset::findOrFail($assetId);
        $rma = TransaksiRma::where('asset_id', $assetId)->firstOrFail();
        $dataLama = $asset->toArray();

        $asset->update([
            'status' => 'Ready',
            'lokasi' => 'Gudang'
        ]);

        $rma->update([
            'status_proses' => 'Completed',
            'no_rma'        => $request->no_rma ?? 'RMA-'.time(),
            'tanggal_rma'   => now(),
        ]);

        ActivityLog::catat(
            'generate_rma',
            "RMA diterbitkan untuk S/N {$asset->serial_number}. Status berubah jadi Ready.",
            'Asset', $asset->id, $dataLama, $asset->fresh()->toArray()
        );

        $safeFileName = str_replace(['/', '\\'], '_', $asset->serial_number);
        $pdf = Pdf::loadView('pdf.rma', compact('asset', 'rma', 'request'));
        
        return $pdf->download('RMA_' . $safeFileName . '.pdf');
    }
}