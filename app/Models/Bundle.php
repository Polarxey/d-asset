<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    const STATUS_DRAFT     = 'draft';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_SELESAI   = 'bstp_generated';

    protected $fillable = [
        'nama_paket',
        'status',
        'keterangan',
        'confirmed_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(BundleItem::class);
    }

    public function assets()
    {
        return $this->hasManyThrough(Asset::class, BundleItem::class, 'bundle_id', 'id', 'id', 'asset_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT     => 'Draft',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_SELESAI   => 'BSTP Generated',
            default                => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            self::STATUS_DRAFT     => 'bg-secondary',
            self::STATUS_CONFIRMED => 'bg-info text-dark',
            self::STATUS_SELESAI   => 'bg-success',
            default                => 'bg-secondary',
        };
    }
}
