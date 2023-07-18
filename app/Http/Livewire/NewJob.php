<?php

namespace App\Http\Livewire;

use Cron\CronExpression;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Native\Laravel\Dialog;
use Native\Laravel\Notification;

class NewJob extends Component
{
    public $command;
    public $frequency;
    public $cron;
    public $minute;
    public $hour;
    public $date;
    public $month;
    public $day;

    public $env;

    public $envFile = '';
    public $envSource = '';
    public $copyEnv = false;

    public function getNextRunsProperty(): array
    {
        if (! $this->frequency) {
            return [];
        }

        if ($this->frequency !== 'custom') {
            $cron = $this->frequency === 'minutely' ? '* * * * *' : "@{$this->frequency}";
        } else {
            $cron = trim(implode(' ', [$this->minute, $this->hour, $this->date, $this->month, $this->day]));
        }

        if (! $cron) {
            return [];
        }

        try {
            $expression = new CronExpression($cron);

            return [
                $expression->getNextRunDate()->format('Y-m-d H:i:s'),
                $expression->getNextRunDate(null, 1)->format('Y-m-d H:i:s'),
                $expression->getNextRunDate(null, 2)->format('Y-m-d H:i:s'),
            ];
        } catch (\InvalidArgumentException $e) {

        }

        return [];
    }

    public function render()
    {
        return view('livewire.new-job');
    }

    public function selectEnv()
    {
        $this->envFile = Dialog::new()
            ->title('Select .env file')
            ->button('Select')
            ->files()
            ->withHiddenFiles()
            ->asSheet()
            ->open();
    }

    public function createJob()
    {
        $env = $this->env;

        if ($this->envSource === 'file' && is_file($this->envFile)) {
            $env = $this->copyEnv ? file_get_contents($this->envFile) : $this->envFile;
        }

        $id = uniqid();

        $jobs = collect(Storage::json('jobs'))
            ->merge([
                $id => [
                    'id' => $id,
                    'command' => $this->command,
                    'frequency' => $this->frequency,
                    'cron' => $this->getCronExpression(),
                    'active' => false,
                    'env' => $env,
                ]
            ]);

        Storage::put('jobs', $jobs->toJson(JSON_PRETTY_PRINT));

        $this->clear();

        Notification::new()
            ->title('Task created')
            ->message('Your task was successfully created.')
            ->show();

        $this->emitUp('jobCreated');
    }

    protected function getCronExpression(): string
    {
        if ($this->frequency !== 'custom') {
            return $this->frequency === 'minutely' ? '* * * * *' : "@{$this->frequency}";
        }

        return implode(' ', [$this->minute, $this->hour, $this->date, $this->month, $this->day]);
    }

    public function clear(): void
    {
        $this->command = null;
        $this->frequency = null;
        $this->cron = null;
        $this->minute = null;
        $this->hour = null;
        $this->date = null;
        $this->month = null;
        $this->day = null;
        $this->env = null;
        $this->envFile = '';
        $this->envSource = '';
        $this->copyEnv = false;
    }
}
