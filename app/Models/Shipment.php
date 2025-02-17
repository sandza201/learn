<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight',
        'type',
        'delivery_id'
    ];

    public function parentShipment(): BelongsTo
    {
        return $this->belongsTo(\self::class, 'parent_shipment_id');
    }

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    public function parcels(): hasMany
    {
        return $this->hasMany(self::class, 'parent_shipment_id');
    }

    public function pallet(): belongsTo
    {
        return $this->belongsTo(self::class, 'parent_shipment_id');
    }
}
