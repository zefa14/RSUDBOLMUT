<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // ─── Role Helper Methods ───────────────────────────────────────────

    /**
     * Cek apakah user adalah Super Admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Cek apakah user adalah Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah Dokter
     */
    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    /**
     * Cek apakah user adalah Petugas
     */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    /**
     * Cek apakah user adalah Kasir
     */
    public function isKasir(): bool
    {
        return $this->role === 'kasir';
    }

    /**
     * Cek apakah user adalah Farmasi (Apoteker)
     */
    public function isFarmasi(): bool
    {
        return $this->role === 'farmasi';
    }

    /**
     * Cek apakah user adalah Pasien
     */
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    /**
     * Cek apakah user memiliki salah satu dari beberapa role
     * Contoh: $user->hasAnyRole(['admin', 'doctor'])
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Mendapatkan label role yang mudah dibaca
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'super_admin' => 'Super Administrator',
            'admin'   => 'Administrator',
            'doctor'  => 'Dokter',
            'petugas' => 'Petugas',
            'patient' => 'Pasien',
            'kasir'   => 'Kasir',
            'farmasi' => 'Apoteker',
            default   => ucfirst($this->role),
        };
    }

    /**
     * Mendapatkan warna badge berdasarkan role
     */
    public function getRoleColorAttribute(): string
    {
        return match ($this->role) {
            'super_admin' => 'dark',
            'admin'   => 'danger',
            'doctor'  => 'success',
            'petugas' => 'info',
            'patient' => 'warning',
            'kasir'   => 'primary',
            'farmasi' => 'teal',
            default   => 'secondary',
        };
    }

    /**
     * Mendapatkan icon berdasarkan role
     */
    public function getRoleIconAttribute(): string
    {
        return match ($this->role) {
            'super_admin' => 'bi-stars',
            'admin'   => 'bi-shield-fill',
            'doctor'  => 'bi-person-badge-fill',
            'petugas' => 'bi-person-workspace',
            'patient' => 'bi-person-fill',
            'kasir'   => 'bi-cash-coin',
            'farmasi' => 'bi-capsule-pill',
            default   => 'bi-person',
        };
    }

    /**
     * Mendapatkan URL avatar (fallback ke default jika tidak ada)
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(storage_path('app/public/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }

        // Generate avatar dari inisial nama
        $name    = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&background=0d6efd&color=ffffff&size=128&bold=true&format=png";
    }

    // ─── Relationships ──────────────────────────────────────────────────

    /**
     * Relasi ke dokter jika role = doctor
     */
    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    /**
     * Relasi ke pasien jika role = patient
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
}
