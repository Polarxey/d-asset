<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('material_number')->nullable()->after('serial_number');
        });

        Schema::table('transaksi_rma', function (Blueprint $table) {
            $table->string('material_number')->nullable()->after('serial_number');
        });
    }
};
