<?php

namespace Tests\Feature;

use App\Models\BookPromotion;
use App\Models\Publication;
use App\Models\PromotionCost;
use App\Models\PromotionDailyResult;
use App\Models\User;
use App\Services\PromotionAnalyticsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PromotionRoiTest extends TestCase
{
    use RefreshDatabase;

    public function test_roi_calculation_is_correct(): void
    {
        $user = User::factory()->create();
        $work = \App\Models\Work::factory()->create(['user_id' => $user->id]);
        $publication = Publication::create([
            'work_id' => $work->id,
            'format' => 'ebook',
            'status' => 'published',
        ]);

        $promotion = BookPromotion::create([
            'publication_id' => $publication->id,
            'promotion_type' => 'free',
            'start_date' => now()->subDays(7)->toDateString(),
            'end_date' => now()->toDateString(),
            'normal_price' => 4.99,
            'promotional_price' => 0,
            'status' => 'completed',
        ]);

        PromotionCost::create([
            'book_promotion_id' => $promotion->id,
            'cost_type' => 'marketing',
            'amount' => 50.00,
            'currency' => 'EUR',
            'date' => now()->toDateString(),
        ]);

        PromotionDailyResult::create([
            'book_promotion_id' => $promotion->id,
            'date' => now()->subDays(3)->toDateString(),
            'paid_units' => 50,
            'free_units_promo' => 100,
            'net_royalties' => 75.00,
            'currency' => 'EUR',
        ]);

        $service = new PromotionAnalyticsService();

        $costs = $service->calculateTotalCost($promotion->id);
        $revenue = $service->calculateTotalRevenue($promotion->id);
        $roi = $service->calculateROI($promotion->id);

        $this->assertEquals(50.00, $costs);
        $this->assertEquals(75.00, $revenue);
        $this->assertEquals(50.0, round($roi));
    }
}