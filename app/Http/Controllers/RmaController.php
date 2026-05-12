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

    public function history()
    {
        $history = TransaksiRma::with('asset')->where('status_proses', 'Completed')->latest()->get();
        return view('rma.history', compact('history'));
    }

    public function create()
    {
        return view('rma.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'serial_number'  => 'required|unique:assets,serial_number,' . $request->asset_id,
            'id_pa'          => 'required',
            'nama_perangkat' => 'required',
            'type'           => 'required',
        ], [
            'serial_number.unique' => 'S/N ini sudah ada di database!',
        ]);

        $asset = Asset::updateOrCreate(
            ['serial_number' => $request->serial_number],
            [
                'nama_perangkat'  => $request->nama_perangkat,
                'merk'            => $request->merk,
                'type'            => $request->type,
                'material_number' => $request->material_number,
                'sumber'          => 'retur',
                'status'          => 'Standby',
                'id_pa'           => $request->id_pa,
                'customer_name'   => $request->customer_name,
                'lokasi_asal'     => $request->lokasi_asal,
                'valuation_type'  => $request->valuation_type,
                'tanggal_masuk'   => $request->tanggal_masuk,
            ]
        );

        TransaksiRma::updateOrCreate(
            ['asset_id' => $asset->id, 'status_proses' => 'Pending'],
            [
                'serial_number'   => $asset->serial_number,
                'material_number' => $asset->material_number,
                'nama_perangkat'  => $asset->nama_perangkat,
                'merk'            => $asset->merk,
                'type'            => $asset->type,
                'id_pa'           => $asset->id_pa,
                'tanggal_masuk'   => $asset->tanggal_masuk,
                'lokasi_asal'     => $asset->lokasi_asal,
                'customer_name'   => $asset->customer_name,
                'valuation_type'  => $asset->valuation_type,
            ]
        );

        ActivityLog::catat('create_retur', "Barang S/N {$asset->serial_number} didata sebagai Standby Masuk", 'Asset', $asset->id, null, $asset->toArray());

        return redirect()->route('rma.index')->with('success', 'Data retur berhasil diproses!');
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
        $rma = TransaksiRma::where('asset_id', $assetId)->where('status_proses', 'Pending')->first();
        
        $dataLama = $asset->toArray();

        // Update status Asset jadi Ready & Gudang
        $asset->update([
            'status' => 'Ready',
            'lokasi' => 'Gudang'
        ]);

        // Update transaksi RMA jadi Completed & simpan detail cetak
        if ($rma) {
            $rma->update([
                'status_proses' => 'Completed',
                'no_rma'        => $request->no_rma,
                'tanggal_rma'   => $request->tanggal_rma,
            ]);
        }

        ActivityLog::catat('generate_rma', "RMA dicetak untuk S/N {$asset->serial_number}. Barang masuk Gudang.", 'Asset', $asset->id, $dataLama, $asset->fresh()->toArray());

        // Pastikan variabel $asset punya data yang lengkap untuk dikirim ke PDF
        $pdf = Pdf::loadView('pdf.rma', compact('asset', 'request'));
        return $pdf->download('RMA_' . $asset->serial_number . '.pdf');
    }

    public function searchUsed(Request $request)
    {
        $search = $request->get('q');
        $assets = Asset::used()
            ->where(function($query) use ($search) {
                $query->where('serial_number', 'LIKE', "%$search%")
                      ->orWhere('lokasi', 'LIKE', "%$search%");
            })
            ->limit(10)->get();

        return response()->json($assets); 
    }

    public function downloadPdfHistory($id)
    {
        $rma = TransaksiRma::findOrFail($id);
        
        // Kita gunakan data dari tabel TransaksiRma agar data 'type' dan 'material_number' 
        // tetap sesuai dengan saat dokumen itu dicetak meskipun data Asset berubah.
        $asset = (object) [
            'id_pa'           => $rma->id_pa,
            'valuation_type'  => $rma->valuation_type,
            'lokasi_asal'     => $rma->lokasi_asal,
            'customer_name'   => $rma->customer_name,
            'merk'            => $rma->merk,
            'type'            => $rma->type,
            'serial_number'   => $rma->serial_number,
            'material_number' => $rma->material_number,
        ];
        
        $request = (object) [
            'no_rma'      => $rma->no_rma,
            'tanggal_rma' => $rma->tanggal_rma
        ];

        $pdf = Pdf::loadView('pdf.rma', compact('asset', 'request'));
        return $pdf->download('RMA_REPRINT_' . ($rma->serial_number ?? $id) . '.pdf');
    }
}