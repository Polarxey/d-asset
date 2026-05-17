<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        $query = Asset::query();

        // Filter logic
        if ($request->filled('sn')) {
            $query->where('serial_number', 'LIKE', '%' . $request->sn . '%');
        }
        if ($request->filled('material_number')) {
            $query->where('material_number', 'LIKE', '%' . $request->material_number . '%');
        }
        if ($request->filled('merk')) {
            $query->where('merk', 'LIKE', '%' . $request->merk . '%');
        }
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'LIKE', '%' . $request->lokasi . '%');
        }

        // Ambil data untuk tiap tab
        $standbyMasukAssets  = (clone $query)->standbyMasuk()->latest()->get();
        $standbyKeluarAssets = (clone $query)->standbyKeluar()->latest()->get();
        $readyAssets         = (clone $query)->ready()->latest()->get();
        $usedAssets          = (clone $query)->used()->latest()->get();

        // LOGIKA BARU: Mode Simplified dengan tambahan 'type'
        $readySimplified = (clone $query)->ready()
            ->select('material_number', 'type', 'merk') // Tambah 'type' disini
            ->selectRaw("COUNT(CASE WHEN sumber = 'baru' THEN 1 END) as new_count")
            ->selectRaw("COUNT(CASE WHEN sumber = 'retur' THEN 1 END) as used_count")
            ->groupBy('material_number', 'type', 'merk') // Tambah 'type' disini juga
            ->get();

        $totalStandbyMasuk  = $standbyMasukAssets->count();
        $totalStandbyKeluar = $standbyKeluarAssets->count();
        $totalReady         = $readyAssets->count();
        $totalUsed          = $usedAssets->count();

        return view('assets.index', compact(
            'standbyMasukAssets', 'standbyKeluarAssets',
            'readyAssets', 'usedAssets', 'readySimplified',
            'totalStandbyMasuk', 'totalStandbyKeluar', 'totalReady', 'totalUsed'
        ));
    }

    public function dashboard()
    {
        $totalStandby = Asset::where('status', Asset::STATUS_STANDBY)->count();
        $totalReady   = Asset::where('status', Asset::STATUS_READY)->count();
        $totalUsed    = Asset::where('status', Asset::STATUS_USED)->count();
        $totalPaket   = Asset::where('status', Asset::STATUS_STANDBY_KELUAR)->count();

        $recentLogs = ActivityLog::latest()->take(8)->get();

        return view('dashboard', compact('totalStandby', 'totalReady', 'totalUsed', 'totalPaket', 'recentLogs'));
    }

    public function update(Request $request, $id)
    {
        $asset    = Asset::findOrFail($id);
        $dataLama = $asset->toArray();

        $data = $request->except(['tipe', '_token', '_method']);
        $asset->update($data);

        ActivityLog::catat('edit_asset', "Asset S/N {$asset->serial_number} diedit", 'Asset', $asset->id, $dataLama, $asset->fresh()->toArray());

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $sn    = $asset->serial_number;

        ActivityLog::catat('delete_asset', "Asset S/N {$sn} dihapus dari sistem", 'Asset', $id, $asset->toArray());
        $asset->delete();

        return redirect()->route('assets.index')->with('success', "Aset S/N {$sn} berhasil dihapus!");
    }
}