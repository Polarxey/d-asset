<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 
        'nama_perangkat', 
        'jumlah', 
        'satuan', 
        'serial_numbers'
    ];

    // Hubungan: Detail ini milik sebuah Transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}