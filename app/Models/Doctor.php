<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'employee_code',
        'name',
        'specialization',
        'phone',
        'email',
        'str_number',
        'sip_number',
        'photo',
        'is_active',
        'notes',
        'consultation_fee',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Boot: Auto-generate employee_code ─────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($doctor) {
            if (empty($doctor->employee_code)) {
                $count = static::count() + 1;
                $doctor->employee_code = 'DOK-' . str_pad($count, 3, '0', STR_PAD_LEFT);
            }
            // Fix legacy column error
            $doctor->specialist = $doctor->specialization ?? '-';
        });

        static::updating(function ($doctor) {
            $doctor->specialist = $doctor->specialization ?? '-';
        });
    }

    // ─── Accessors ──────────────────────────────────────────────────────

    /** URL foto dokter */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(storage_path('app/public/' . $this->photo))) {
            return asset('storage/' . $this->photo);
        }
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&background=198754&color=ffffff&size=128&bold=true";
    }

    /** Label status aktif */
    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'Aktif' : 'Nonaktif';
    }

    /** Warna badge status */
    public function getStatusColorAttribute(): string
    {
        return $this->is_active ? 'success' : 'secondary';
    }

    // ─── Relationships ──────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
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
              ->orWhere('specialization', 'like', "%{$keyword}%")
              ->orWhere('employee_code', 'like', "%{$keyword}%");
        });
    }
}
