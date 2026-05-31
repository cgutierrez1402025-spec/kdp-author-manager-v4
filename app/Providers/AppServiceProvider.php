<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\ManuscriptVersion;
use App\Models\Publication;
use App\Models\Work;
use App\Observers\ActivityLogObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Work::observe(ActivityLogObserver::class);
        ManuscriptVersion::observe(ActivityLogObserver::class);
        Publication::observe(ActivityLogObserver::class);
    }
}