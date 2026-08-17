<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('KDP Author Manager')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->resources([
                \App\Filament\Admin\Resources\AiTasks\AiTaskResource::class,
                \App\Filament\Admin\Resources\BookEvents\BookEventResource::class,
                \App\Filament\Admin\Resources\BookPromotions\BookPromotionResource::class,
                \App\Filament\Admin\Resources\Checklists\ChecklistResource::class,
                \App\Filament\Admin\Resources\EventBooks\EventBookResource::class,
                \App\Filament\Admin\Resources\IllustrationAnchors\IllustrationAnchorResource::class,
                \App\Filament\Admin\Resources\KdpMetadatas\KdpMetadataResource::class,
                \App\Filament\Admin\Resources\KdpSelectPeriods\KdpSelectPeriodResource::class,
                \App\Filament\Admin\Resources\ManuscriptVersions\ManuscriptVersionResource::class,
                \App\Filament\Admin\Resources\Marketplaces\MarketplaceResource::class,
                \App\Filament\Admin\Resources\Platforms\PlatformResource::class,
                \App\Filament\Admin\Resources\PromotionCosts\PromotionCostResource::class,
                \App\Filament\Admin\Resources\PromotionDailyResults\PromotionDailyResultResource::class,
                \App\Filament\Admin\Resources\Prompts\PromptResource::class,
                \App\Filament\Admin\Resources\Publications\PublicationResource::class,
                \App\Filament\Admin\Resources\SourceUsages\SourceUsageResource::class,
                \App\Filament\Admin\Resources\Sources\SourceResource::class,
                \App\Filament\Admin\Resources\Tasks\TaskResource::class,
                \App\Filament\Admin\Resources\Works\WorkResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->widgets([
                \App\Filament\Admin\Widgets\ActivePromotionsWidget::class,
                \App\Filament\Admin\Widgets\MyTasksWidget::class,
                \App\Filament\Admin\Widgets\UpcomingEventsWidget::class,
                \App\Filament\Admin\Widgets\SummaryCardsWidget::class,
                \App\Filament\Admin\Widgets\RevenueChartWidget::class,
                \App\Filament\Admin\Widgets\TopWorksByRevenueWidget::class,
                \App\Filament\Admin\Widgets\ExpiringKdpSelectWidget::class,
                \App\Filament\Admin\Widgets\RecentActivityWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
