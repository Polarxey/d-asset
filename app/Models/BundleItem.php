<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BundleItem extends Model
{
    protected $fillable = [
        'bundle_id',
        'asset_id',
        'qty',
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
