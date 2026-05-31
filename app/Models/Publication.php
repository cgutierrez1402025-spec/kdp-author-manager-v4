<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'work_language_id',
        'manuscript_version_id',
        'platform_id',
        'marketplace_id',
        'format',
        'external_identifier',
        'public_url',
        'status',
        'price',
        'currency',
        'territories',
        'isbn',
        'asin',
        'published_at',
        'notes',
    ];

    protected $casts = [
        'published_at' => 'timestamp',
        'price' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $publication) {
            $publication->asin = self::formatAsinValue($publication->asin);
            $publication->isbn = self::formatIsbnValue($publication->isbn);
        });

        static::updating(function (self $publication) {
            if ($publication->wasChanged('asin')) {
                $publication->asin = self::formatAsinValue($publication->asin);
            }
            if ($publication->wasChanged('isbn')) {
                $publication->isbn = self::formatIsbnValue($publication->isbn);
            }
        });
    }

    public function rules(): array
    {
        return [
            'work_id' => 'required|exists:works,id',
            'work_language_id' => 'required|exists:work_languages,id',
            'manuscript_version_id' => 'required|exists:manuscript_versions,id',
            'platform_id' => 'required|exists:platforms,id',
            'marketplace_id' => 'nullable|exists:marketplaces,id',
            'format' => 'required|in:ebook,paperback,hardcover,audiobook',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|size:3',
            'isbn' => $this->getUniqueIsbnRule(),
            'asin' => $this->getUniqueAsinRule(),
        ];
    }

    protected static function formatAsinValue(?string $asin): ?string
    {
        if (! $asin) {
            return null;
        }

        return strtoupper(Str::of($asin)->replaceMatches('/[^A-Z0-9]/', '')->toString());
    }

    protected static function formatIsbnValue(?string $isbn): ?string
    {
        if (! $isbn) {
            return null;
        }

        return strtoupper(Str::of($isbn)->replaceMatches('/[^0-9X]/', '')->toString());
    }

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function workLanguage(): BelongsTo
    {
        return $this->belongsTo(WorkLanguage::class);
    }

    public function manuscriptVersion(): BelongsTo
    {
        return $this->belongsTo(ManuscriptVersion::class);
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    public function marketplace(): BelongsTo
    {
        return $this->belongsTo(Marketplace::class);
    }

    public function kdpMetadata(): HasOne
    {
        return $this->hasOne(KdpMetadata::class);
    }

    public function getRoyaltyRateAttribute(): float
    {
        return match ($this->format) {
            'ebook' => 0.70,
            'paperback' => 0.60,
            'hardcover' => 0.45,
            default => 0.35,
        };
    }

    public function getEstimatedRoyaltyPerSaleAttribute(): float
    {
        $rate = $this->royalty_rate;
        return (float) ($this->price * $rate);
    }

    public function calculateEstimatedRoyalties(int $unitsSold): float
    {
        return $unitsSold * $this->estimated_royalty_per_sale;
    }

    public function getFormatLabelAttribute(): string
    {
        return match ($this->format) {
            'ebook' => 'eBook',
            'paperback' => 'Tapa Blanda',
            'hardcover' => 'Tapa Dura',
            'audiobook' => 'Audiolibro',
            default => $this->format,
        };
    }

    public function scopeByPlatform($query, int $platformId)
    {
        return $query->where('platform_id', $platformId);
    }

    public function scopeByMarketplace($query, int $marketplaceId)
    {
        return $query->where('marketplace_id', $marketplaceId);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getUniqueIsbnRule(): string
    {
        $ignoreId = $this->id ?? 'NULL';
        $marketplaceId = $this->marketplace_id ?? 'NULL';

        return "nullable|unique:publications,isbn,{$ignoreId},id,marketplace_id,{$marketplaceId}";
    }

    public function getUniqueAsinRule(): string
    {
        $ignoreId = $this->id ?? 'NULL';
        $marketplaceId = $this->marketplace_id ?? 'NULL';

        return "nullable|unique:publications,asin,{$ignoreId},id,marketplace_id,{$marketplaceId}";
    }
}