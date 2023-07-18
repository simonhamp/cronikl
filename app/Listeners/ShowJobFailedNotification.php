<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Native\Laravel\Notification;

class ShowJobFailedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Notification::new()
            ->title('🛑 Task failed: '.($event->job->name ?? $event->job->id))
            ->message("Your task [{$event->job->command}] failed to run.")
            ->show();
    }
}
