<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    public $timestamps = false; // only created_at

    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];
}