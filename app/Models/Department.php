<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'location',
        'description',
        'status',
        'consultation_fee',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}