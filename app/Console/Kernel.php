<?php

namespace App\Console;

use Dotenv\Dotenv;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;
use Native\Laravel\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        foreach (json_decode(Storage::get('jobs')) as $job) {
            if ($job->active) {
                $schedule->call($this->createCallbackForJob($job))
                    ->cron($job->cron);
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
                $env = Dotenv::parse(file_get_contents($job->env));
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
