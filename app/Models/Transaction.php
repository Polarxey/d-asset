<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'bundle_id',
        'no_bstp',
        'penerima',
        'lokasi_tujuan',
        'tanggal_serah',
    ];

    protected $casts = [
        'tanggal_serah' => 'date',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }
}
