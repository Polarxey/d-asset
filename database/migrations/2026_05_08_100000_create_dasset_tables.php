<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ============================================================
        // 1. ASSETS — tabel utama master semua perangkat
        // ============================================================
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->unique();
            $table->string('nama_perangkat');
            $table->string('merk')->nullable();

            // Data 6 poin retur (hanya diisi jika sumber = retur)
            $table->string('id_pa')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('lokasi_asal')->nullable();
            $table->string('valuation_type')->nullable()
                  ->comment('Ex-Project | Dismantle | Rusak-L | Rusak-TL');

            // Sumber asal perangkat
            $table->string('sumber')->default('baru')
                  ->comment('baru | retur');

            // Status siklus hidup perangkat
            // Sengaja pakai string bukan enum agar lebih fleksibel di MySQL
            $table->string('status')->default('Ready')
                  ->comment('Standby | Ready | Standby-Keluar | Used');

            // Lokasi & penerima (diisi saat Used)
            $table->string('lokasi')->nullable();
            $table->string('penerima')->nullable();

            // Tanggal
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_keluar')->nullable();

            $table->timestamps();
        });

        // ============================================================
        // 2. TRANSAKSI RMA — riwayat barang yang masuk lewat jalur retur
        // ============================================================
        Schema::create('transaksi_rma', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->nullable()->constrained('assets')->nullOnDelete();

            // 6 poin data retur wajib
            $table->string('id_pa');
            $table->date('tanggal_masuk');
            $table->string('lokasi_asal');
            $table->string('customer_name');
            $table->string('merk');
            $table->string('serial_number');
            $table->string('nama_perangkat');
            $table->string('valuation_type')->nullable();

            // Dokumen RMA yang diterbitkan
            $table->string('no_rma')->nullable();
            $table->date('tanggal_rma')->nullable();

            // Status proses: Pending = belum generate RMA, Completed = sudah generate
            $table->string('status_proses')->default('Pending');

            $table->timestamps();
        });

        // ============================================================
        // 3. BUNDLES — paket kelompok perangkat untuk satu BSTP
        // ============================================================
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->string('status')->default('draft')
                  ->comment('draft | confirmed | bstp_generated');
            $table->text('keterangan')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });

        // ============================================================
        // 4. BUNDLE ITEMS — perangkat-perangkat yang masuk bundle
        // ============================================================
        Schema::create('bundle_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->constrained()->onDelete('cascade');
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->integer('qty')->default(1);
            $table->timestamps();
        });

        // ============================================================
        // 5. TRANSACTIONS — dokumen BSTP yang sudah diterbitkan
        // ============================================================
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->nullable()->constrained('bundles')->nullOnDelete();
            $table->string('no_bstp')->unique();
            $table->string('penerima');
            $table->string('lokasi_tujuan');
            $table->date('tanggal_serah');
            $table->timestamps();
        });

        // ============================================================
        // 6. TRANSACTION DETAILS — rincian per jenis perangkat di BSTP
        // ============================================================
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
            $table->string('nama_perangkat');
            $table->integer('jumlah');
            $table->string('satuan')->default('Unit');
            $table->text('serial_numbers');
            $table->timestamps();
        });

        // ============================================================
        // 7. ACTIVITY LOGS — audit trail semua perubahan data
        // ============================================================
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('actor')->default('System');
            $table->string('aksi');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('deskripsi');
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('bundle_items');
        Schema::dropIfExists('bundles');
        Schema::dropIfExists('transaksi_rma');
        Schema::dropIfExists('assets');
    }
};
