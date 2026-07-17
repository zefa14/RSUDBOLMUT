<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'ward_id',
        'building',
        'floor',
        'name',
        'room_class',
        'total_beds',
        'occupied_beds'
    ];

    /**
     * Relasi: Kamar milik 1 Bangsal
     */
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    /**
     * Accessor untuk mendapatkan sisa kasur kosong
     */
    public function getAvailableBedsAttribute()
    {
        return $this->total_beds - $this->occupied_beds;
    }
}
