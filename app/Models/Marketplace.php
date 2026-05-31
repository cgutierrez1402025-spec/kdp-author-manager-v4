<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marketplace extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform_id',
        'code',
        'name',
        'currency',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('ordered', function ($builder) {
            $builder->orderBy('name');
        });
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    public function bookPromotions(): HasMany
    {
        return $this->hasMany(BookPromotion::class);
    }

    public function scopeForPlatform(string $platform): self
    {
        return $this->whereHas('platform', fn ($q) => $q->where('name', $platform));
    }

    public function getDisplayNameAttribute(): string
    {
        return "{$this->name} ({$this->currency})";
    }
}