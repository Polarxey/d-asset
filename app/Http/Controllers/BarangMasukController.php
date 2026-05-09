<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    // Form input barang baru dari pusat
    public function create()
    {
        return view('barang_masuk.create');
    }

    // Simpan barang baru — langsung Ready
    public function store(Request $request)
    {
        $request->validate([
            'serial_number'  => 'required|string|unique:assets,serial_number',
            'nama_perangkat' => 'required|string',
            'merk'           => 'nullable|string',
            'tanggal_masuk'  => 'required|date',
        ]);

        $asset = Asset::create([
            'serial_number'  => $request->serial_number,
            'nama_perangkat' => $request->nama_perangkat,
            'merk'           => $request->merk,
            'sumber'         => Asset::SUMBER_BARU,
            'status'         => Asset::STATUS_READY,
            'lokasi'         => 'Gudang',
            'tanggal_masuk'  => $request->tanggal_masuk,
        ]);

        ActivityLog::catat(
            'create_baru',
            "Barang baru S/N {$asset->serial_number} ({$asset->nama_perangkat}) ditambahkan langsung ke Ready (Gudang)",
            'Asset', $asset->id,
            null,
            $asset->toArray()
        );

        return redirect()->route('assets.index')
            ->with('success', "Barang baru S/N {$asset->serial_number} berhasil ditambahkan ke Gudang (Ready)!");
    }
}
