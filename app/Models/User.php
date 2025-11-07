<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Searchable, HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role', 'avatar', 'bio', 'location', 'dark_mode', 'messenger_color', 'active_status', 'provider', 'provider_id'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'dark_mode' => 'boolean',
        'active_status' => 'boolean',
    ];

    /* ---------------- Relationships ---------------- */

    public function developerProfile()
    {
        return $this->hasOne(DeveloperProfile::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_user')->withPivot('proficiency_level')->withTimestamps();
    }

    public function portfolios()
    {
        return $this->hasMany(Portofolio::class);
    }

    public function postedProjects()
    {
        // consumer side
        return $this->hasMany(Project::class, 'consumer_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function agreementsAsConsumer()
    {
        return $this->hasMany(ProjectAgreement::class, 'consumer_id');
    }

    public function agreementsAsDeveloper()
    {
        return $this->hasMany(ProjectAgreement::class, 'developer_id');
    }

    public function payments()
    {
        return $this->hasManyThrough(Payment::class, ProjectAgreement::class, 'consumer_id', 'project_agreement_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'consumer_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'developer_id');
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function completedProjects()
    {
        return $this->hasMany(ProjectAgreement::class, 'developer_id')->where('status', 'completed');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot(['role', 'joined_at', 'last_read_at', 'is_active'])
            ->withTimestamps();
    }
}
