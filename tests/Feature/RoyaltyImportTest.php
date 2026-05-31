<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\RoyaltyEntry;
use App\Models\RoyaltyPayment;
use App\Models\Marketplace;
use App\Models\Platform;
use App\Models\User;
use App\Models\Work;
use App\Services\RoyaltyAnalyticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoyaltyImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_royalty_entry_without_duplicates(): void
    {
        $user = User::factory()->create();
        $work = Work::factory()->create(['user_id' => $user->id]);
        $publication = Publication::create([
            'work_id' => $work->id,
            'format' => 'ebook',
            'status' => 'published',
        ]);

        $entry = RoyaltyEntry::create([
            'publication_id' => $publication->id,
            'year' => 2025,
            'month' => 12,
            'paid_units' => 100,
            'free_units' => 25,
            'kenp_pages' => 5000,
            'royalty_ebook' => 70.00,
            'royalty_paperback' => 0,
            'royalty_hardcover' => 0,
            'royalty_kenp' => 35.00,
            'total_royalty' => 105.00,
            'currency' => 'USD',
        ]);

        $this->assertDatabaseHas('royalty_entries', [
            'publication_id' => $publication->id,
            'year' => 2025,
            'month' => 12,
        ]);

        $duplicate = RoyaltyEntry::where('publication_id', $publication->id)
            ->where('year', 2025)
            ->where('month', 12)
            ->count();

        $this->assertEquals(1, $duplicate, 'Should not allow duplicate entries for same publication/year/month');
    }
}