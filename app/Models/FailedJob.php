<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJob extends Model
{
    protected $table = 'failed_jobs';

    public $timestamps = false; // only failed_at

    protected $fillable = [
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at',
    ];
}