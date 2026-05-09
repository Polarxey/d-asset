<?php

namespace App\Http\Controllers;

use App\Models\Asset;
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
            'nama_perangkat' => 'required',
        ], [
            'serial_number.unique' => 'S/N ini sudah ada di database!',
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

        ActivityLog::catat(
            'create_retur',
            "Barang retur S/N {$asset->serial_number} didata sebagai Standby Masuk",
            'Asset', $asset->id, null, $asset->toArray()
        );

        return redirect()->route('rma.index')->with('success', 'Data retur berhasil disimpan!');
    }

    public function generateForm($assetId)
    {
        $asset = Asset::findOrFail($assetId);
        $autoNoRma = 'RMA-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        return view('rma.generate', compact('asset', 'autoNoRma'));
    }

    public function generatePdf(Request $request, $assetId)
    {
        $asset = Asset::findOrFail($assetId);
        
        $dataLama = $asset->toArray();

        $asset->update([
            'status' => 'Ready',
            'lokasi' => 'Gudang'
        ]);

        ActivityLog::catat(
            'generate_rma',
            "RMA diterbitkan untuk S/N {$asset->serial_number}. Barang masuk Gudang.",
            'Asset', $asset->id, $dataLama, $asset->fresh()->toArray()
        );

        $pdf = Pdf::loadView('pdf.rma', compact('asset', 'request'));
        
        return $pdf->download('RMA_' . $asset->serial_number . '.pdf');
    }
}