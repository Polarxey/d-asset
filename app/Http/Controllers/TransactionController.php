<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Asset;
use App\Models\Bundle;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    // Halaman buat BSTP — pilih dari paket yang sudah ada
    public function create()
    {
        $bundles = Bundle::with('items.asset')
            ->whereIn('status', [Bundle::STATUS_DRAFT, Bundle::STATUS_CONFIRMED])
            ->latest()
            ->get();

        $recentTransactions = Transaction::latest()->take(10)->get();

        return view('transactions.create', compact('bundles', 'recentTransactions'));
    }

    // Simpan BSTP dari paket
    public function store(Request $request)
    {
        $request->validate([
            'bundle_id'     => 'required|exists:bundles,id',
            'no_bstp'       => 'required|string',
            'penerima'      => 'required|string',
            'lokasi_tujuan' => 'required|string',
            'tanggal_serah' => 'required|date',
        ]);

        $bundle = Bundle::with('items.asset')->findOrFail($request->bundle_id);

        $transaction = Transaction::create([
            'bundle_id'     => $bundle->id,
            'no_bstp'       => $request->no_bstp,
            'penerima'      => $request->penerima,
            'lokasi_tujuan' => $request->lokasi_tujuan,
            'tanggal_serah' => $request->tanggal_serah,
        ]);

        // Buat detail BSTP berdasarkan item di paket, dikelompokkan per nama perangkat
        $grouped = $bundle->items->groupBy(fn($item) => $item->asset->nama_perangkat ?? 'Unknown');

        foreach ($grouped as $namaPerangkat => $items) {
            $serialNumbers = $items->map(fn($i) => $i->asset->serial_number ?? '-')->join(', ');

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'nama_perangkat' => $namaPerangkat,
                'jumlah'         => $items->count(),
                'satuan'         => 'Unit',
                'serial_numbers' => $serialNumbers,
            ]);

            // Update semua aset di paket ini ke Used
            foreach ($items as $bundleItem) {
                if ($bundleItem->asset) {
                    $bundleItem->asset->update([
                        'status'         => Asset::STATUS_USED,
                        'lokasi'         => $request->lokasi_tujuan,
                        'penerima'       => $request->penerima,
                        'tanggal_keluar' => $request->tanggal_serah,
                    ]);
                }
            }
        }

        // Tandai paket sebagai selesai
        $bundle->update(['status' => Bundle::STATUS_SELESAI]);

        ActivityLog::catat(
            'generate_bstp',
            "BSTP {$request->no_bstp} diterbitkan untuk paket '{$bundle->nama_paket}' ke {$request->penerima} ({$request->lokasi_tujuan})",
            'Transaction', $transaction->id,
            null,
            ['no_bstp' => $request->no_bstp, 'penerima' => $request->penerima]
        );

        return redirect()->route('transactions.create')
            ->with('success', "BSTP {$request->no_bstp} berhasil dibuat!");
    }

    // Index semua transaksi
    public function index()
    {
        $transactions = Transaction::latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    // Download PDF BSTP
    public function downloadPDF($id)
    {
        $transaction = Transaction::with('details')->findOrFail($id);

        $logoPath   = public_path('img/logo-icon.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $pdf = Pdf::loadView('pdf.bstp', compact('transaction', 'logoBase64'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download("BSTP_{$transaction->no_bstp}.pdf");
    }
}
