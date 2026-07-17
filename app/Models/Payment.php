<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'patient_id',
        'customer_name',
        'payment_type',
        'invoice_number',
        'total_amount',
        'payment_method',
        'status',
        'paid_at',
        'processed_by',
        'notes',
    ];

    protected $casts = [
        'paid_at'      => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    // ─── Boot: Auto-generate invoice_number ────────────────────────────
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->invoice_number)) {
                $year  = now()->year;
                $month = now()->format('m');
                // Gunakan max(id) untuk mencegah duplikat jika ada data yang dihapus
                $maxId = static::max('id') ?? 0;
                $payment->invoice_number = 'INV-' . $year . $month . '-' . str_pad($maxId + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // ─── Accessors ──────────────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Menunggu',
            'paid'      => 'Lunas',
            'partial'   => 'Sebagian',
            'cancelled' => 'Dibatalkan',
            default     => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'warning',
            'paid'      => 'success',
            'partial'   => 'info',
            'cancelled' => 'danger',
            default     => 'secondary',
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'cash'      => 'Tunai',
            'bpjs'      => 'BPJS',
            'insurance' => 'Asuransi',
            'transfer'  => 'Transfer Bank',
            'debit'     => 'Kartu Debit',
            'credit'    => 'Kartu Kredit',
            default     => $this->payment_method,
        };
    }

    /** Format total_amount ke Rupiah */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }

    // ─── Relationships ──────────────────────────────────────────────────

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function items()
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // ─── Scopes ────────────────────────────────────────────────────────

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
