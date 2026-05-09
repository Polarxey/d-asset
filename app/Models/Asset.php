<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    // Status Constants
    const STATUS_STANDBY        = 'Standby';
    const STATUS_READY          = 'Ready';
    const STATUS_STANDBY_KELUAR = 'Standby-Keluar';
    const STATUS_USED           = 'Used';

    const SUMBER_RETUR = 'retur';
    const SUMBER_BARU  = 'baru';

    protected $fillable = [
        'serial_number', 'nama_perangkat', 'merk',
        'id_pa', 'customer_name', 'lokasi_asal', 'valuation_type', 'sumber',
        'status', 'lokasi', 'penerima',
        'tanggal_masuk', 'tanggal_keluar',
    ];

    protected $casts = [
        'tanggal_masuk'  => 'date',
        'tanggal_keluar' => 'date',
    ];

    public function bundleItems()
    {
        return $this->hasMany(BundleItem::class);
    }

    public function rmaRecords()
    {
        return $this->hasMany(TransaksiRma::class, 'asset_id');
    }

    // Scopes
    public function scopeStandbyMasuk($query)
    {
        return $query->where('status', self::STATUS_STANDBY)->where('sumber', self::SUMBER_RETUR);
    }

    public function scopeReady($query)
    {
        return $query->where('status', self::STATUS_READY);
    }

    public function scopeStandbyKeluar($query)
    {
        return $query->where('status', self::STATUS_STANDBY_KELUAR);
    }

    public function scopeUsed($query)
    {
        return $query->where('status', self::STATUS_USED);
    }

    // Helpers
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            self::STATUS_STANDBY        => 'bg-warning text-dark',
            self::STATUS_READY          => 'bg-success',
            self::STATUS_STANDBY_KELUAR => 'bg-info text-dark',
            self::STATUS_USED           => 'bg-secondary',
            default                     => 'bg-secondary',
        };
    }

    public function getLokasDisplayAttribute(): string
    {
        if ($this->status === self::STATUS_READY) {
            return 'Gudang';
        }
        return $this->lokasi ?? '-';
    }
}