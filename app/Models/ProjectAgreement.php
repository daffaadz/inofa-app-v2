<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAgreement extends Model
{
    protected $table = 'project_agreements';

    protected $fillable = [
        'project_id',
        'consumer_id',
        'developer_id',
        'offer_id',
        'final_price',
        'start_date',
        'end_date',
        'status',
        'terms',
        'milestones',
        'signed_at',
    ];

    protected $casts = [
        'final_price' => 'decimal:2',
        'start_date'  => 'date',
        'end_date'    => 'date',
        'milestones'  => 'array',
        'signed_at'   => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function consumer()
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}