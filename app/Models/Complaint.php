<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'description',
        'terms_accepted',
        'status',
        'admin_response',
        'responded_at',
    ];

    protected $casts = [
        'terms_accepted' => 'boolean',
        'responded_at' => 'datetime',
    ];

    /**
     * Get the user that owns the complaint.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
