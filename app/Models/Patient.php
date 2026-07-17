<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_code',
        'user_id',
        'name',
        'nik',
        'birth_date',
        'birth_place',
        'gender',
        'religion',
        'marital_status',
        'education',
        'occupation',
        'blood_type',
        'phone',
        'email',
        'address',
        'rt_rw',
        'kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'postal_code',
        'bpjs_number',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relation',
        'photo',
        'is_active',
        'notes',
        'allergy_notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active'  => 'boolean',
    ];

    // ─── Boot: Auto-generate patient_code ──────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            if (empty($patient->patient_code)) {
                $year  = now()->year;
                $count = static::whereYear('created_at', $year)->count() + 1;
                $patient->patient_code = 'RSU-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // ─── Accessors ──────────────────────────────────────────────────────

    /** URL foto pasien (fallback ke avatar generator) */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(storage_path('app/public/' . $this->photo))) {
            return asset('storage/' . $this->photo);
        }
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&background=0d6efd&color=ffffff&size=128&bold=true";
    }

    /** Umur pasien berdasarkan birth_date */
    public function getAgeAttribute(): string
    {
        if (!$this->birth_date) return '-';
        return $this->birth_date->age . ' tahun';
    }

    /** Label gender */
    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'L', 'male'   => 'Laki-laki',
            'P', 'female' => 'Perempuan',
            default       => $this->gender ?? '-',
        };
    }

    /** Warna badge gender */
    public function getGenderColorAttribute(): string
    {
        return in_array($this->gender, ['L', 'male']) ? 'info' : 'pink';
    }

    // ─── Relationships ──────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Registration::class);
    }

    // ─── Scopes ────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('patient_code', 'like', "%{$keyword}%")
              ->orWhere('nik', 'like', "%{$keyword}%")
              ->orWhere('phone', 'like', "%{$keyword}%")
              ->orWhere('bpjs_number', 'like', "%{$keyword}%");
        });
    }
}
