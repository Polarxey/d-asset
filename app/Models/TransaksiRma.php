<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiRma extends Model
{
    use HasFactory;

    protected $table = 'transaksi_rma';
    
    protected $fillable = [
        'id_pa', 'tanggal_masuk', 'lokasi_asal',
        'customer_name', 'merk', 'type', 'serial_number', 'material_number', 'nama_perangkat',
        'valuation_type', 'asset_id', 'no_rma', 'tanggal_rma', 'status_proses',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_rma'   => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}