<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Native\Laravel\Notification;

class ShowJobSucceededNotification
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
            ->title('✅ Task run: '.($event->job->name ?? $event->job->id))
            ->message("Your task [{$event->job->command}] ran successfully.")
            ->show();
    }
}
