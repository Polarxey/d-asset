<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\ActivityLog;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Sample data Barang Retur (Standby Masuk) ──
        $returData = [
            [
                'serial_number'  => 'NYGGWJ600271',
                'nama_perangkat' => 'Switch FH10',
                'merk'           => 'Raisecom',
                'id_pa'          => 'A121303001099',
                'customer_name'  => 'PLN IP UBP JATIGEDE',
                'lokasi_asal'    => 'KAB. SUMEDANG',
                'valuation_type' => 'Ex-Project',
                'sumber'         => 'retur',
                'status'         => 'Standby',
                'lokasi'         => 'KAB. SUMEDANG',
                'tanggal_masuk'  => '2026-04-15',
            ],
            [
                'serial_number'  => 'MA0620Y00396',
                'nama_perangkat' => 'OTB 24 Core',
                'merk'           => 'Rosenberger',
                'id_pa'          => 'A121303001100',
                'customer_name'  => 'DISDUKCAPIL PABUARAN',
                'lokasi_asal'    => 'KAB. SUBANG',
                'valuation_type' => 'Dismantle',
                'sumber'         => 'retur',
                'status'         => 'Standby',
                'lokasi'         => 'KAB. SUBANG',
                'tanggal_masuk'  => '2026-04-20',
            ],
            [
                'serial_number'  => 'HW2024SC0091',
                'nama_perangkat' => 'ONU GPON MA5671T',
                'merk'           => 'Huawei',
                'id_pa'          => 'A121303001101',
                'customer_name'  => 'PT TELKOM AKSES',
                'lokasi_asal'    => 'KAB. BANDUNG',
                'valuation_type' => 'Rusak-L',
                'sumber'         => 'retur',
                'status'         => 'Standby',
                'lokasi'         => 'KAB. BANDUNG',
                'tanggal_masuk'  => '2026-04-28',
            ],
        ];

        foreach ($returData as $data) {
            Asset::create($data);
        }

        // ── Sample data Barang Baru (Ready / Gudang) ──
        $baruData = [
            [
                'serial_number'  => 'ZTE2026GW001',
                'nama_perangkat' => 'ZXA10 C300M',
                'merk'           => 'ZTE',
                'sumber'         => 'baru',
                'status'         => 'Ready',
                'lokasi'         => 'Gudang',
                'tanggal_masuk'  => '2026-05-01',
            ],
            [
                'serial_number'  => 'ZTE2026GW002',
                'nama_perangkat' => 'ZXA10 C300M',
                'merk'           => 'ZTE',
                'sumber'         => 'baru',
                'status'         => 'Ready',
                'lokasi'         => 'Gudang',
                'tanggal_masuk'  => '2026-05-01',
            ],
            [
                'serial_number'  => 'NK2026LTE003',
                'nama_perangkat' => 'Switch L2 24-Port',
                'merk'           => 'Nokia',
                'sumber'         => 'baru',
                'status'         => 'Ready',
                'lokasi'         => 'Gudang',
                'tanggal_masuk'  => '2026-05-03',
            ],
            [
                'serial_number'  => 'NK2026LTE004',
                'nama_perangkat' => 'Switch L2 24-Port',
                'merk'           => 'Nokia',
                'sumber'         => 'baru',
                'status'         => 'Ready',
                'lokasi'         => 'Gudang',
                'tanggal_masuk'  => '2026-05-03',
            ],
            [
                'serial_number'  => 'HW2026ODF005',
                'nama_perangkat' => 'ODF 12 Core',
                'merk'           => 'Huawei',
                'sumber'         => 'baru',
                'status'         => 'Ready',
                'lokasi'         => 'Gudang',
                'tanggal_masuk'  => '2026-05-05',
            ],
        ];

        foreach ($baruData as $data) {
            Asset::create($data);
        }

        // ── Sample data Used ──
        Asset::create([
            'serial_number'  => 'RC2025SW099',
            'nama_perangkat' => 'Switch ISCOM2924GF',
            'merk'           => 'Raisecom',
            'sumber'         => 'baru',
            'status'         => 'Used',
            'lokasi'         => 'Disdukcapil Pabuaran',
            'penerima'       => 'PT TUNAS ZETA UTAMA',
            'tanggal_masuk'  => '2026-03-10',
            'tanggal_keluar' => '2026-04-29',
        ]);

        // ── Sample Activity Logs ──
        ActivityLog::catat('create_baru', 'Seeder: 5 barang baru ditambahkan ke gudang', 'Asset', null);
        ActivityLog::catat('create_retur', 'Seeder: 3 barang retur didata sebagai Standby Masuk', 'Asset', null);
    }
}
