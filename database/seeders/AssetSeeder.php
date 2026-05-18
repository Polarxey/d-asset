<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Asset;
use Carbon\Carbon;

class AssetSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            // ==========================================
            // TAB 1: STANDBY MASUK (Barang Retur/Dismantle)
            // ==========================================
            [
                'serial_number'   => 'FHTT9829F150',
                'material_number' => '10001002',
                'nama_perangkat'  => 'Router',
                'merk'            => 'Fiberhome',
                'type'            => 'HG6243C',
                'sumber'          => 'retur',
                'status'          => 'Standby',
                'id_pa'           => 'PA-ICON-001',
                'customer_name'   => 'KCP Jabar',
                'lokasi_asal'     => 'GI Majalaya',
                'valuation_type'  => 'Dismantle',
                'tanggal_masuk'   => $now->subDays(2),
                'created_at'      => $now, 'updated_at' => $now
            ],
            [
                'serial_number'   => 'NYGGWIC01849',
                'material_number' => '10001003',
                'nama_perangkat'  => 'Switch',
                'merk'            => 'Fiberhome',
                'type'            => 'S4800',
                'sumber'          => 'retur',
                'status'          => 'Standby',
                'id_pa'           => 'PA-ICON-002',
                'customer_name'   => 'Corporate Lite Jabar',
                'lokasi_asal'     => 'GI Cikasungka',
                'valuation_type'  => 'Rusak-L',
                'tanggal_masuk'   => $now->subDays(1),
                'created_at'      => $now, 'updated_at' => $now
            ],
            [
                'serial_number'   => 'RSCM99887766',
                'material_number' => '10001004',
                'nama_perangkat'  => 'Switch SD-WAN',
                'merk'            => 'Raisecom',
                'type'            => 'ISCOM2924G',
                'sumber'          => 'retur',
                'status'          => 'Standby',
                'id_pa'           => 'PA-ICON-003',
                'customer_name'   => 'PT. Teladan',
                'lokasi_asal'     => 'GI Cibadak',
                'valuation_type'  => 'Ex-Project',
                'tanggal_masuk'   => $now,
                'created_at'      => $now, 'updated_at' => $now
            ],

            // ==========================================
            // TAB 2: READY (GUDANG) - Campur Baru & Retur
            // ==========================================
            [
                'serial_number'   => 'G1S096V004330',
                'material_number' => '10001001',
                'nama_perangkat'  => 'Access Point (Kecil)',
                'merk'            => 'Ruijie',
                'type'            => 'RG-SAP820-SP',
                'sumber'          => 'baru',
                'status'          => 'Ready',
                'lokasi'          => 'Gudang',
                'tanggal_masuk'   => $now->subDays(10),
                'created_at'      => $now, 'updated_at' => $now
            ],
            [
                'serial_number'   => 'G1SKATX003363',
                'material_number' => '10001001',
                'nama_perangkat'  => 'Access Point (Besar)',
                'merk'            => 'Ruijie',
                'type'            => 'RG-SAP820-SP',
                'sumber'          => 'retur', // Bekas yang udah ready
                'status'          => 'Ready',
                'lokasi'          => 'Gudang',
                'tanggal_masuk'   => $now->subDays(5),
                'created_at'      => $now, 'updated_at' => $now
            ],
            [
                'serial_number'   => 'FHTT11223344',
                'material_number' => '10001002',
                'nama_perangkat'  => 'Router',
                'merk'            => 'Fiberhome',
                'type'            => 'HG6243C',
                'sumber'          => 'baru',
                'status'          => 'Ready',
                'lokasi'          => 'Gudang',
                'tanggal_masuk'   => $now->subDays(7),
                'created_at'      => $now, 'updated_at' => $now
            ],
            [
                'serial_number'   => 'FHTT55667788',
                'material_number' => '10001002', // Mat number sama dengan router atas
                'nama_perangkat'  => 'Router',
                'merk'            => 'Fiberhome',
                'type'            => 'HG6243C',
                'sumber'          => 'retur',
                'status'          => 'Ready',
                'lokasi'          => 'Gudang',
                'tanggal_masuk'   => $now->subDays(3),
                'created_at'      => $now, 'updated_at' => $now
            ],
            [
                'serial_number'   => 'ZTE90909090',
                'material_number' => '10001005',
                'nama_perangkat'  => 'Router', // Perangkat sama (Router) tapi Merek/Tipe beda
                'merk'            => 'ZTE',
                'type'            => 'F609',
                'sumber'          => 'baru',
                'status'          => 'Ready',
                'lokasi'          => 'Gudang',
                'tanggal_masuk'   => $now->subDays(1),
                'created_at'      => $now, 'updated_at' => $now
            ],
            [
                'serial_number'   => 'HW12345678',
                'material_number' => '10001006',
                'nama_perangkat'  => 'Microwave Link ODU',
                'merk'            => 'Huawei',
                'type'            => 'RTN 900',
                'sumber'          => 'baru',
                'status'          => 'Ready',
                'lokasi'          => 'Gudang',
                'tanggal_masuk'   => $now->subDays(15),
                'created_at'      => $now, 'updated_at' => $now
            ],

            // ==========================================
            // TAB 3: STANDBY KELUAR (Masuk ke keranjang/paket)
            // ==========================================
            [
                'serial_number'   => 'G1S11223344',
                'material_number' => '10001001',
                'nama_perangkat'  => 'Access Point',
                'merk'            => 'Ruijie',
                'type'            => 'RG-SAP820-SP',
                'sumber'          => 'baru',
                'status'          => 'Standby-Keluar',
                'lokasi'          => 'Gudang',
                'tanggal_masuk'   => $now->subDays(20),
                'created_at'      => $now, 'updated_at' => $now
            ],
            [
                'serial_number'   => 'RSCM11112222',
                'material_number' => '10001004',
                'nama_perangkat'  => 'Switch SD-WAN',
                'merk'            => 'Raisecom',
                'type'            => 'ISCOM2924G',
                'sumber'          => 'retur',
                'status'          => 'Standby-Keluar',
                'lokasi'          => 'Gudang',
                'tanggal_masuk'   => $now->subDays(14),
                'created_at'      => $now, 'updated_at' => $now
            ],

            // ==========================================
            // TAB 4: USED (Terpasang di Lapangan)
            // ==========================================
            [
                'serial_number'   => 'HW87654321',
                'material_number' => '10001006',
                'nama_perangkat'  => 'Microwave Link IDU',
                'merk'            => 'Huawei',
                'type'            => 'RTN 900',
                'sumber'          => 'baru',
                'status'          => 'Used',
                'lokasi'          => 'GI Ubrug',
                'penerima'        => 'Kang Yayan (Teknisi)',
                'tanggal_masuk'   => $now->subDays(30),
                'tanggal_keluar'  => $now->subDays(5),
                'created_at'      => $now, 'updated_at' => $now
            ],
            [
                'serial_number'   => 'FHTT44332211',
                'material_number' => '10001002',
                'nama_perangkat'  => 'Router',
                'merk'            => 'Fiberhome',
                'type'            => 'HG6243C',
                'sumber'          => 'baru',
                'status'          => 'Used',
                'lokasi'          => 'Kantor Pusat PLN',
                'penerima'        => 'Tim IT Support',
                'tanggal_masuk'   => $now->subDays(40),
                'tanggal_keluar'  => $now->subDays(12),
                'created_at'      => $now, 'updated_at' => $now
            ]
        ];

        Asset::insert($data);
    }
}