<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $standbyMasukAssets  = Asset::standbyMasuk()->latest()->get();
        $standbyKeluarAssets = Asset::standbyKeluar()->latest()->get();
        $readyAssets         = Asset::ready()->latest()->get();
        $usedAssets          = Asset::used()->latest()->get();

        $totalStandbyMasuk  = $standbyMasukAssets->count();
        $totalStandbyKeluar = $standbyKeluarAssets->count();
        $totalReady         = $readyAssets->count();
        $totalUsed          = $usedAssets->count();

        return view('assets.index', compact(
            'standbyMasukAssets', 'standbyKeluarAssets',
            'readyAssets', 'usedAssets',
            'totalStandbyMasuk', 'totalStandbyKeluar', 'totalReady', 'totalUsed'
        ));
    }

    public function dashboard()
    {
        $totalStandby = Asset::where('status', Asset::STATUS_STANDBY)->count();
        $totalReady   = Asset::where('status', Asset::STATUS_READY)->count();
        $totalUsed    = Asset::where('status', Asset::STATUS_USED)->count();
        $totalPaket   = Asset::where('status', Asset::STATUS_STANDBY_KELUAR)->count();

        $recentLogs = \App\Models\ActivityLog::latest()->take(8)->get();

        return view('dashboard', compact('totalStandby', 'totalReady', 'totalUsed', 'totalPaket', 'recentLogs'));
    }

    public function update(Request $request, $id)
    {
        $asset   = Asset::findOrFail($id);
        $dataLama = $asset->toArray();

        // Jangan izinkan update 'tipe' (sudah dihapus dari sistem)
        $data = $request->except(['tipe', '_token', '_method']);
        $asset->update($data);

        ActivityLog::catat(
            'edit_asset',
            "Asset S/N {$asset->serial_number} diedit",
            'Asset', $asset->id,
            $dataLama,
            $asset->fresh()->toArray()
        );

        return redirect()->route('assets.index')->with('success', 'Data aset berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $sn    = $asset->serial_number;

        ActivityLog::catat(
            'delete_asset',
            "Asset S/N {$sn} dihapus dari sistem",
            'Asset', $id,
            $asset->toArray()
        );

        $asset->delete();

        return redirect()->route('assets.index')->with('success', "Aset S/N {$sn} berhasil dihapus!");
    }
}
