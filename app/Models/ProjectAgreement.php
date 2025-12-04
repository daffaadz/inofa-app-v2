<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectAgreement extends Model
{
    // Primary key adalah UUID
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'project_id',
        'project_title',
        'consumer_id',
        'developer_id',
        'client_name',
        'final_price',
        'price_details',
        'start_date',
        'end_date',
        'status',
        'terms',
        'scope_projects',
        'projects_mvp',
        'progress',
        'deliverables',
        'signed_at',
        'conversation_id',
    ];

    protected $casts = [
        'final_price' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'price_details' => 'array',
        'projects_mvp' => 'array',
        'progress' => 'integer',
        'deliverables' => 'array',
        'signed_at' => 'datetime',
    ];

    /**
     * Boot function untuk auto-generate UUID
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_TERMINATED = 'terminated';
    const STATUS_DISPUTED = 'disputed';

    /**
     * Relationships
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function consumer()
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function messages()
    {
        return $this->hasMany(ChMessage::class, 'project_agreement_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'project_id', 'project_id');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', self::STATUS_ACCEPTED);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeForConsumer($query, $consumerId)
    {
        return $query->where('consumer_id', $consumerId);
    }

    public function scopeForDeveloper($query, $developerId)
    {
        return $query->where('developer_id', $developerId);
    }

    /**
     * Accessors & Mutators
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }

    public function getTotalPaidAttribute()
    {
        return $this->payments()
            ->whereIn('status', ['confirmed', 'completed', 'transferred'])
            ->sum('amount');
    }

    public function getRemainingPaymentAttribute()
    {
        return $this->final_price - $this->total_paid;
    }

    /**
     * Methods
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isAccepted()
    {
        return $this->status === self::STATUS_ACCEPTED;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isTerminated()
    {
        return $this->status === self::STATUS_TERMINATED;
    }

    public function isDisputed()
    {
        return $this->status === self::STATUS_DISPUTED;
    }

    public function isFullyPaid()
    {
        return $this->total_paid >= $this->final_price;
    }

    /**
     * Calculate total from price details
     */
    public function calculateTotalFromDetails()
    {
        if (!$this->price_details || !is_array($this->price_details)) {
            return 0;
        }

        return collect($this->price_details)->sum('price');
    }

    /**
     * Get formatted price breakdown
     */
    public function getFormattedPriceDetails()
    {
        if (!$this->price_details) {
            return [];
        }

        return collect($this->price_details)->map(function ($item) {
            return [
                'item' => $item['item'] ?? '',
                'price' => $item['price'] ?? 0,
                'formatted_price' => 'Rp ' . number_format($item['price'] ?? 0, 0, ',', '.')
            ];
        })->toArray();
    }

    /**
     * Get sorted MVP features by priority
     */
    public function getSortedMvpFeatures()
    {
        if (!$this->projects_mvp) {
            return [];
        }

        return collect($this->projects_mvp)
            ->sortBy('priority')
            ->values()
            ->toArray();
    }

    /**
     * Get short ID (first 8 characters of UUID)
     */
    public function getShortIdAttribute()
    {
        return substr($this->id, 0, 8);
    }
}
