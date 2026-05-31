<?php

namespace App\Filament\Admin\Widgets;

use App\Models\BookEvent;
use Filament\Widgets\Widget;

class UpcomingEventsWidget extends Widget
{
    protected string $view = 'filament.widgets.upcoming-events';

    protected int $eventsLimit = 5;

    public function getEventsProperty(): array
    {
        return BookEvent::upcoming(30)
            ->orderBy('event_date')
            ->limit($this->eventsLimit)
            ->get()
            ->map(fn (BookEvent $event) => [
                'id' => $event->id,
                'title' => $event->title,
                'event_date' => $event->event_date,
                'location_name' => $event->location_name,
                'city' => $event->city,
                'total_copies_sold' => $event->total_copies_sold,
                'total_income' => $event->total_income,
            ])
            ->values()
            ->all();
    }
}