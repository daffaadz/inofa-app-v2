<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Offer extends Model
{
    use HasFactory, Searchable;
    
    protected $fillable = [
        'project_id',
        'user_id',
        'proposed_price',
        'proposed_deadline',
        'cover_letter',
        'milestones',
        'status',
        'accepted_at',
    ];

    protected $casts = [
        'proposed_price'  => 'decimal:2',
        'proposed_deadline'=> 'date',
        'milestones'      => 'array',
        'accepted_at'     => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agreement()
    {
        return $this->hasOne(ProjectAgreement::class);
    }
}