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
        // PERUBAHAN: Tarik semua data secara mentah tanpa selectRaw/groupBy. 
        // Grouping berdasarkan merk/tipe sekarang diurus otomatis di file Blade view.
        $readyAssets = Asset::where('status', 'Ready')->get();

        return view('bundle.create', compact('readyAssets'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_paket' => 'required',
            // Kita validasi asset_ids (kumpulan ID S/N yang dicentang di form)
            'asset_ids'  => 'required|array|min:1', 
        ], [
            'asset_ids.required' => 'Belum ada barang yang dipilih. Silakan isi Qty atau centang S/N manual minimal satu.',
        ]);

        // 2. Keamanan: Pastikan semua S/N yang ditarik masih berstatus 'Ready'
        // Ini untuk mencegah bentrok kalau ada user lain yang kebetulan narik barang yang sama di detik yang sama
        $validAssets = Asset::whereIn('id', $request->asset_ids)
                            ->where('status', 'Ready')
                            ->get();

        if ($validAssets->count() < count($request->asset_ids)) {
            return redirect()->back()->withErrors("Gagal! Beberapa S/N yang dipilih ternyata sudah tidak 'Ready' (mungkin baru saja ditarik user lain).");
        }

        // 3. Buat Paket (Bundle)
        $bundle = Bundle::create([
            'nama_paket' => $request->nama_paket,
            'status'     => 'draft',
            'keterangan' => $request->keterangan,
        ]);

        // 4. Masukkan item ke Bundle dan update status Asset menjadi Standby-Keluar
        foreach ($validAssets as $asset) {
            BundleItem::create([
                'bundle_id' => $bundle->id,
                'asset_id'  => $asset->id,
                'qty'       => 1, // Tetap 1 karena ini dihitung per S/N fisik
            ]);

            $asset->update([
                'status' => 'Standby-Keluar',
            ]);
        }

        // 5. Catat ke Log Activity
        ActivityLog::catat(
            'create_transaksi_keluar',
            "Membuat transaksi keluar '{$bundle->nama_paket}' sejumlah {$validAssets->count()} unit",
            'Bundle', $bundle->id, null, $bundle->toArray()
        );

        return redirect()->route('transactions.create', ['bundle_id' => $bundle->id])
                         ->with('success', 'Paket barang berhasil disiapkan!');
    }

    public function destroy($id)
    {
        $bundle = Bundle::findOrFail($id);

        // Kembalikan status barang jadi Ready lagi kalau paket dibatalkan
        foreach ($bundle->items as $item) {
            if ($item->asset) {
                $item->asset->update([
                    'status' => 'Ready',
                ]);
            }
        }

        ActivityLog::catat(
            'delete_paket',
            "Menghapus paket '{$bundle->nama_paket}'",
            'Bundle', $bundle->id, $bundle->toArray(), null
        );

        $bundle->delete();

        return redirect()->route('bundle.index')->with('success', 'Paket dibatalkan, status barang kembali menjadi Ready.');
    }
}