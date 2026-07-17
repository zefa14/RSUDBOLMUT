<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Inpatient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registration_id',
        'patient_id',
        'room_id',
        'doctor_id',
        'admission_date',
        'discharge_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'admission_date' => 'datetime',
        'discharge_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}
