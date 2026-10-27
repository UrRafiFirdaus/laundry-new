<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    public const PENDING    = 'pending';
    public const SETTLEMENT = 'settlement';

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $guarded = [];

    protected $casts = [
        'expiry_time'  => 'datetime',
        'paid_at'      => 'datetime',
        'raw_response' => 'array',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket', 'id_paket');
    }

    public function isPaid(): bool
    {
        return $this->status === self::SETTLEMENT;
    }

    public function isPending(): bool
    {
        return $this->status === self::PENDING;
    }

    /** Sudah kedaluwarsa/gagal, atau masih pending tapi lewat batas waktu. */
    public function isExpired(): bool
    {
        if ($this->isPaid()) {
            return false;
        }
        if (! $this->isPending()) {
            return true; // expire, cancel, deny, failure
        }
        return $this->expiry_time !== null && $this->expiry_time->isPast();
    }
}
