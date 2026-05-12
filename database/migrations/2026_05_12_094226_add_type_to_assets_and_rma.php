<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'type')) {
                $table->string('type')->nullable()->after('merk');
            }
        });

        Schema::table('transaksi_rma', function (Blueprint $table) {
            if (!Schema::hasColumn('transaksi_rma', 'type')) {
                $table->string('type')->nullable()->after('merk');
            }
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('transaksi_rma', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};