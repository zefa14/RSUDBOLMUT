<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'building',
        'floor',
        'name',
        'max_capacity',
    ];

    /**
     * Relasi: 1 Bangsal memiliki banyak Kamar (Room/Kelas)
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Total semua bed di bangsal ini (dari semua kelas/kamar)
     */
    public function getTotalBedsAttribute()
    {
        return $this->rooms->sum('total_beds');
    }

    /**
     * Total bed yang terisi di bangsal ini
     */
    public function getOccupiedBedsAttribute()
    {
        return $this->rooms->sum('occupied_beds');
    }

    /**
     * Total bed yang masih kosong di bangsal ini
     */
    public function getAvailableBedsAttribute()
    {
        return $this->total_beds - $this->occupied_beds;
    }
}
