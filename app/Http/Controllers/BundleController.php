<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    // Halaman buat paket baru — menampilkan stok Ready
    public function create()
    {
        // Kelompokkan asset Ready berdasarkan nama_perangkat + merk untuk ditampilkan qty-nya
        $readyAssets = Asset::ready()
            ->selectRaw('nama_perangkat, merk, COUNT(*) as stok_tersedia, GROUP_CONCAT(id) as asset_ids')
            ->groupBy('nama_perangkat', 'merk')
            ->get();

        return view('bundle.create', compact('readyAssets'));
    }

    // Simpan paket baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket'          => 'required|string',
            'keterangan'          => 'nullable|string',
            'items'               => 'required|array|min:1',
            'items.*.nama_perangkat' => 'required|string',
            'items.*.qty'         => 'required|integer|min:1',
        ]);

        $bundle = Bundle::create([
            'nama_paket'  => $request->nama_paket,
            'keterangan'  => $request->keterangan,
            'status'      => Bundle::STATUS_DRAFT,
        ]);

        $warnings  = [];
        $assetIds  = [];

        foreach ($request->items as $item) {
            // Ambil asset Ready sesuai nama_perangkat sebanyak qty yang diminta
            $availableAssets = Asset::ready()
                ->where('nama_perangkat', $item['nama_perangkat'])
                ->take($item['qty'])
                ->get();

            $actualQty = $availableAssets->count();

            if ($actualQty < $item['qty']) {
                $warnings[] = "Stok {$item['nama_perangkat']} hanya tersedia {$actualQty} unit (diminta {$item['qty']}).";
            }

            foreach ($availableAssets as $asset) {
                BundleItem::create([
                    'bundle_id' => $bundle->id,
                    'asset_id'  => $asset->id,
                    'qty'       => 1,
                ]);

                // Ubah status asset ke Standby-Keluar
                $asset->update(['status' => Asset::STATUS_STANDBY_KELUAR]);
                $assetIds[] = $asset->id;
            }
        }

        ActivityLog::catat(
            'create_bundle',
            "Paket '{$bundle->nama_paket}' dibuat dengan " . count($assetIds) . " perangkat",
            'Bundle', $bundle->id,
            null,
            ['nama_paket' => $bundle->nama_paket, 'jumlah_item' => count($assetIds)]
        );

        $message = "Paket '{$bundle->nama_paket}' berhasil dibuat!";
        if (!empty($warnings)) {
            $message .= ' Peringatan: ' . implode(' ', $warnings);
        }

        return redirect()->route('bundle.index')->with('success', $message);
    }

    // Daftar semua paket
    public function index()
    {
        $bundles = Bundle::with('items.asset')->latest()->get();
        return view('bundle.index', compact('bundles'));
    }

    // Batalkan/hapus paket — kembalikan aset ke Ready
    public function destroy($id)
    {
        $bundle = Bundle::with('items.asset')->findOrFail($id);

        foreach ($bundle->items as $item) {
            if ($item->asset) {
                $item->asset->update(['status' => Asset::STATUS_READY]);
            }
        }

        ActivityLog::catat(
            'delete_bundle',
            "Paket '{$bundle->nama_paket}' dibatalkan. Semua perangkat dikembalikan ke Ready.",
            'Bundle', $id
        );

        $bundle->delete();

        return redirect()->route('bundle.index')->with('success', "Paket dibatalkan. Aset dikembalikan ke Ready.");
    }
}
