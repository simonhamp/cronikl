<?php

namespace App\Providers;

use App\Events\JobFailed;
use App\Events\JobSucceeded;
use App\Listeners\ShowJobFailedNotification;
use App\Listeners\ShowJobSucceededNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        JobSucceeded::class => [
            ShowJobSucceededNotification::class,
        ],
        JobFailed::class => [
            ShowJobFailedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
