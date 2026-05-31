<?php

namespace App\Services\RoyaltyParsers;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class BaseRoyaltyParser
{
    protected array $requiredColumns = [];
    protected string $dateFormat = 'Y-m-d';

    abstract public function getPlatformCode(): string;

    abstract public function mapRow(array $row): array;

    public function parse(array $row): array
    {
        $this->validateColumns($row);

        return $this->mapRow($row);
    }

    protected function validateColumns(array $row): void
    {
        $missing = collect($this->requiredColumns)
            ->reject(fn ($col) => isset($row[$col]) || array_key_exists($col, $row))
            ->values();

        if ($missing->isNotEmpty()) {
            throw new \InvalidArgumentException(
                "Missing required columns: " . $missing->join(', ')
            );
        }
    }

    protected function parseDate(string $date): string
    {
        return \Carbon\Carbon::parse($date)->format($this->dateFormat);
    }

    protected function parseDecimal(string $value): float
    {
        return (float) Str::of($value)->replaceMatches('/[^0-9.\-]/', '')->toString();
    }

    protected function parseInteger(string $value): int
    {
        return (int) Str::of($value)->replaceMatches('/[^0-9\-]/', '')->toString();
    }
}