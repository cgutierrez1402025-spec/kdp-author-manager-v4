<?php

namespace App\Filament\Admin\Widgets;

use App\Services\PromotionAnalyticsService;
use Filament\Widgets\Widget;

class ActivePromotionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.active-promotions';

    protected int $promotionsLimit = 10;

    public function getPromotionsProperty(): array
    {
        $service = app(PromotionAnalyticsService::class);

        return $service->getAllActivePromotionsWithROI(auth()->user())
            ->take($this->promotionsLimit)
            ->values()
            ->all();
    }
}
