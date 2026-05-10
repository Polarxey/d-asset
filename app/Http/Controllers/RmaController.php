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

    public function create()
    {
        // Menampilkan form input barang retur
        return view('rma.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Jika ada asset_id (dari pencarian), abaikan validasi unique untuk S/N tersebut
            'serial_number'  => 'required|unique:assets,serial_number,' . $request->asset_id,
            'id_pa'          => 'required',
            'nama_perangkat' => 'required',
            'type'           => 'required',
        ], [
            'serial_number.unique' => 'S/N ini sudah ada di database!',
        ]);

        // Gunakan updateOrCreate agar jika S/N sudah ada (status Used), datanya diperbarui jadi Standby 
        $asset = Asset::updateOrCreate(
            ['serial_number' => $request->serial_number],
            [
                'nama_perangkat' => $request->nama_perangkat,
                'merk'           => $request->merk,
                'type'           => $request->type,
                'sumber'         => 'retur',
                'status'         => 'Standby', // Menjadi Standby Masuk 
                'id_pa'          => $request->id_pa,
                'customer_name'  => $request->customer_name,
                'lokasi_asal'    => $request->lokasi_asal,
                'valuation_type' => $request->valuation_type,
                'tanggal_masuk'  => $request->tanggal_masuk,
            ]
        );

        // Record di Transaksi RMA, semua field dimasukkan biar nggak error MySQL 1364
        TransaksiRma::updateOrCreate(
            ['asset_id' => $asset->id, 'status_proses' => 'Pending'],
            [
                'serial_number'  => $asset->serial_number,
                'nama_perangkat' => $asset->nama_perangkat,
                'merk'           => $asset->merk,
                'type'           => $asset->type,
                'id_pa'          => $asset->id_pa,
                'tanggal_masuk'  => $asset->tanggal_masuk,
                'lokasi_asal'    => $asset->lokasi_asal,
                'customer_name'  => $asset->customer_name,
                'valuation_type' => $asset->valuation_type,
            ]
        );

        ActivityLog::catat(
            'create_retur', 
            "Barang S/N {$asset->serial_number} ditarik dari lapangan menjadi Standby Masuk", 
            'Asset', 
            $asset->id, 
            null, 
            $asset->toArray()
        );

        return redirect()->route('rma.index')->with('success', 'Data retur berhasil diproses!');
    }

    public function generateForm($assetId)
    {
        $asset = Asset::findOrFail($assetId);
        // Generate Auto No RMA
        $autoNoRma = 'RMA-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        
        return view('rma.generate', compact('asset', 'autoNoRma'));
    }

    public function generatePdf(Request $request, $assetId)
    {
        $asset = Asset::findOrFail($assetId);
        $rma = TransaksiRma::where('asset_id', $assetId)->first();
        
        $dataLama = $asset->toArray();

        // Update status Asset jadi Ready & Gudang
        $asset->update([
            'status' => 'Ready',
            'lokasi' => 'Gudang'
        ]);

        // Update transaksi RMA jadi Completed
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

        // Cetak PDF
        $pdf = Pdf::loadView('pdf.rma', compact('asset', 'request'));
        return $pdf->download('RMA_' . $asset->serial_number . '.pdf');
    }

    public function searchUsed(Request $request)
    {
        $search = $request->get('q');
        
        // Cari barang yang statusnya 'Used' berdasarkan S/N atau Lokasi via AJAX
        $assets = Asset::used()
            ->where(function($query) use ($search) {
                $query->where('serial_number', 'LIKE', "%$search%")
                      ->orWhere('lokasi', 'LIKE', "%$search%");
            })
            ->limit(10)
            ->get();

        return response()->json($assets);
    }
}