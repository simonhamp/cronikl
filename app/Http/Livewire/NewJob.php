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

    public $envFile = '';

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
            ->singleFile()
            ->withHiddenFiles()
            ->asSheet()
            ->open();
    }

    public function createJob()
    {
        $jobs = collect(Storage::json('jobs'))
            ->merge([[
                'id' => uniqid(),
                'command' => $this->command,
                'frequency' => $this->frequency,
                'cron' => $this->getCronExpression(),
                'active' => false,
                'env' => $this->envFile,
            ]]);

        Storage::put('jobs', $jobs->toJson(JSON_PRETTY_PRINT));

        Notification::new()
            ->title('Task created')
            ->message('Your task was successfully created.')
            ->show();

        $this->emitUp('jobCreated');
    }

    protected function getCronExpression()
    {
        if ($this->frequency !== 'custom') {
            return $this->frequency === 'minutely' ? '* * * * *' : "@{$this->frequency}";
        }

        return implode(' ', [$this->minute, $this->hour, $this->date, $this->month, $this->day]);
    }
}
