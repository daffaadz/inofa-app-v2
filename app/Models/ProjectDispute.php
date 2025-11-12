<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDispute extends Model
{
    protected $fillable = ['project_agreement_id','raised_by','status','issue','resolution','resolved_at'];

    public function agreement() {
        return $this->belongsTo(ProjectAgreement::class);
    }

    public function raiser() {
        return $this->belongsTo(User::class,'raised_by');
    }
}

