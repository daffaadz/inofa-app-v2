<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    protected $fillable = ['message_id', 'disk', 'path', 'original_name', 'mime', 'size'];

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function url(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
