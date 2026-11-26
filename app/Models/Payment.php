<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'project_agreement_id',
        'amount',
        'type',
        'payment_method',
        'consumer_payment_proof',
        'status',
        'admin_confirmed',
        'admin_confirmed_at',
        'admin_transferred',
        'admin_transferred_at',
        'admin_transfer_proof',
    ];

    protected $casts = [
        'amount'              => 'decimal:2',
        'admin_confirmed'     => 'boolean',
        'admin_transferred'   => 'boolean',
        'admin_confirmed_at'  => 'datetime',
        'admin_transferred_at'=> 'datetime',
    ];

    /* ---------------- Relations ---------------- */

    public function agreement()
    {
        return $this->belongsTo(ProjectAgreement::class, 'project_agreement_id');
    }

    public function payer()
    {
        return $this->agreement->consumer();
    }
    public function consumer()
    {
        return $this->hasOneThrough(
            User::class,
            ProjectAgreement::class,
            'id', 'id',
            'project_agreement_id', 'consumer_id'
        );
    }

    public function receiver()
    {
        return $this->agreement->developer();
    }
    public function developer()
    {
        return $this->hasOneThrough(
            User::class,
            ProjectAgreement::class,
            'id', 'id',
            'project_agreement_id', 'developer_id'
        );
    }

    /* ---------------- Scopes ---------------- */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeTransferred($query)
    {
        return $query->where('status', 'transferred');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /* ---------------- Helpers ---------------- */

    public function isProofUploaded(): bool
    {
        return !empty($this->consumer_payment_proof);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return in_array($this->status, ['confirmed', 'transferred']);
    }

    public function markAsConfirmed(): void
    {
        $this->update([
            'status' => 'confirmed',
            'admin_confirmed' => true,
            'admin_confirmed_at' => now(),
        ]);
    }

    public function markAsTransferred(): void
    {
        $this->update([
            'status' => 'transferred',
            'admin_transferred' => true,
            'admin_transferred_at' => now(),
        ]);
    }
}
