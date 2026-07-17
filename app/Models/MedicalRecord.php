<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'department_id',
        'record_date',
        'complaint', // Legacy
        'subjective',
        'objective',
        'blood_pressure',
        'temperature',
        'weight',
        'height',
        'assessment',
        'plan',
        'icd10_code',
        'diagnosis', // Legacy
        'treatment' // Legacy
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    // Jika ingin melacak pendaftaran asalnya (meskipun lewat id tidak terhubung langsung)
    public function registration()
    {
        // Fitur opsional, karena MedicalRecord dan Registration sama-sama memiliki patient_id & date
        return $this->belongsTo(Registration::class);
    }
}