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
    ];

    protected $casts = [
        'amount'              => 'decimal:2',
        'admin_confirmed'     => 'boolean',
        'admin_transferred'   => 'boolean',
        'admin_confirmed_at'  => 'datetime',
        'admin_transferred_at'=> 'datetime',
    ];

    public function agreement()
    {
        return $this->belongsTo(ProjectAgreement::class, 'project_agreement_id');
    }
}