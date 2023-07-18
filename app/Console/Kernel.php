<?php

namespace App\Console;

use App\Enums\NotificationType;
use App\Events\JobFailed;
use App\Events\JobFinished;
use App\Events\JobSucceeded;
use Dotenv\Dotenv;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Native\Laravel\Facades\Settings;
use Native\Laravel\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $notifications = Settings::get('notifications.show', NotificationType::FAILURE_ONLY);

        foreach (json_decode(Storage::get('jobs')) as $job) {
            if ($job->active) {
                $schedule->call($this->createCallbackForJob($job))
                    ->cron($job->cron)
                    ->onSuccess(fn () => $notifications === NotificationType::ALL ? JobSucceeded::broadcast($job) : null)
                    ->onFailure(function () use ($job, $notifications) {
                        if (! in_array($notifications, [
                            NotificationType::ALL,
                            NotificationType::FAILURE_ONLY,
                        ])) {
                            return;
                        }
                        JobFailed::broadcast($job);
                    });
            }
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected function createCallbackForJob($job): callable
    {
        return function () use ($job) {
            $env = [];

            if ($job->env) {
                $envString = $job->env;
                if (is_file($envString)) {
                    $envString = file_get_contents($envString);
                }

                $env = Dotenv::parse($envString);
            }

            Storage::delete("{$job->id}.log");

            Storage::append("{$job->id}.log", "\$ {$job->command}");

            Process::env($env)
                ->forever()
                ->path(base_path())
                ->run($job->command, function (string $type, string $line) use ($job) {
                    $timestamp = date('Y-m-d H:i:s');
                    Storage::append("{$job->id}.log", "[{$timestamp}]: {$line}");
                });
        };
    }
}
