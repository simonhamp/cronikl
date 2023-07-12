<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Scheduler extends Component
{
    public $jobs;

    public $currentJob;

    public $jobLog;

    protected $listeners = ['jobCreated' => 'loadJobs'];

    public function render()
    {
        $this->loadJobs();

        return view('livewire.scheduler');
    }

    public function loadJobs()
    {
        $this->jobs = collect(json_decode(Storage::get('jobs')))->keyBy('id');
    }

    public function deleteJob($id): void
    {
        $this->jobs->forget($id);

        Storage::put('jobs', $this->jobs->toJson());
    }

    public function pauseJob($id): void
    {
        $job = $this->jobs->get($id);
        $job['active'] = false;
        $this->jobs->put($id, $job);

        Storage::put('jobs', $this->jobs->toJson());
    }

    public function resumeJob($id): void
    {
        $job = $this->jobs->get($id);
        $job['active'] = true;
        $this->jobs->put($id, $job);

        Storage::put('jobs', $this->jobs->toJson());
    }

    public function getJobLog($id)
    {
        $this->currentJob = $this->jobs->get($id);
        $this->jobLog = Storage::get("{$id}.log");
    }
}
