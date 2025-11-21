<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgreementValidation extends Model
{
    // Fillable fields
    protected $fillable = [
        'project_agreement_id',
        'admin_id',
        'status',
        'notes',
        'validated_at'
    ];

    // Relationships
    public function agreement() {
        return $this->belongsTo(ProjectAgreement::class);
    }

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
