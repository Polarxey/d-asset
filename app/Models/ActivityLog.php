<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'actor',
        'aksi',
        'model_type',
        'model_id',
        'deskripsi',
        'data_lama',
        'data_baru',
        'ip_address',
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    // Shortcut statis untuk mencatat log dari mana saja
    public static function catat(
        string $aksi,
        string $deskripsi,
        string $modelType = null,
        int    $modelId = null,
        array  $dataLama = null,
        array  $dataBaru = null,
        string $actor = 'Dzaki MH'
    ): void {
        static::create([
            'actor'      => $actor,
            'aksi'       => $aksi,
            'model_type' => $modelType,
            'model_id'   => $modelId,
            'deskripsi'  => $deskripsi,
            'data_lama'  => $dataLama,
            'data_baru'  => $dataBaru,
            'ip_address' => request()->ip(),
        ]);
    }
}
