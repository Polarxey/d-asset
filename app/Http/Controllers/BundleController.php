<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index()
    {
        $bundles = Bundle::with('items.asset')->latest()->get();
        return view('bundle.index', compact('bundles'));
    }

    public function create()
    {
        $readyAssets = Asset::where('status', 'Ready')
            ->selectRaw('nama_perangkat, merk, count(*) as stok_tersedia')
            ->groupBy('nama_perangkat', 'merk')
            ->get();

        return view('bundle.create', compact('readyAssets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required',
            'items'      => 'required|array',
        ]);

        $itemsToProcess = [];
        $totalQty = 0;

        foreach ($request->items as $item) {
            if (isset($item['qty']) && $item['qty'] > 0) {
                $assets = Asset::where('status', 'Ready')
                    ->where('nama_perangkat', $item['nama_perangkat'])
                    ->take($item['qty'])
                    ->get();

                if ($assets->count() < $item['qty']) {
                    return redirect()->back()->withErrors("Stok {$item['nama_perangkat']} kurang!");
                }
                
                $itemsToProcess = array_merge($itemsToProcess, $assets->all());
                $totalQty += $item['qty'];
            }
        }

        if (empty($itemsToProcess)) {
            return redirect()->back()->withErrors("Belum ada barang yang dipilih.");
        }

        $bundle = Bundle::create([
            'nama_paket' => $request->nama_paket,
            'status'     => 'draft',
            'keterangan' => $request->keterangan,
        ]);

        foreach ($itemsToProcess as $asset) {
            BundleItem::create([
                'bundle_id' => $bundle->id,
                'asset_id'  => $asset->id,
                'qty'       => 1,
            ]);

            $asset->update([
                'status' => 'Standby-Keluar',
            ]);
        }

        ActivityLog::catat(
            'create_transaksi_keluar',
            "Membuat transaksi keluar '{$bundle->nama_paket}' sejumlah {$totalQty} unit",
            'Bundle', $bundle->id, null, $bundle->toArray()
        );

        return redirect()->route('transactions.create', ['bundle_id' => $bundle->id])
                         ->with('success', 'Barang berhasil disiapkan!');
    }

    public function destroy($id)
    {
        $bundle = Bundle::findOrFail($id);

        foreach ($bundle->items as $item) {
            $item->asset->update([
                'status' => 'Ready',
            ]);
        }

        ActivityLog::catat(
            'delete_paket',
            "Menghapus paket '{$bundle->nama_paket}'",
            'Bundle', $bundle->id, $bundle->toArray(), null
        );

        $bundle->delete();

        return redirect()->route('bundle.index')->with('success', 'Paket dibatalkan, barang kembali ke Ready.');
    }
}