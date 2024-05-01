<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Scheduler extends Component
{
    public $jobs;

    public $currentJob;

    public $modalTitle;
    public $modalContent;

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

        $this->saveJobs();
    }

    public function pauseJob($id): void
    {
        $job = $this->jobs->get($id);
        $job['active'] = false;
        $this->jobs->put($id, $job);

        $this->saveJobs();
    }

    public function resumeJob($id): void
    {
        $job = $this->jobs->get($id);
        $job['active'] = true;
        $this->jobs->put($id, $job);

        $this->saveJobs();
    }

    public function showJobLog($id)
    {
        $this->currentJob = $this->jobs->get($id);

        $this->showModal(
            title: 'Task output',
            content: Storage::get("{$id}.log"),
        );
    }

    public function showEnv($id)
    {
        $this->currentJob = $this->jobs->get($id);

        $env = $this->currentJob['env'];

        if (is_file($env)) {
            $env = file_get_contents($env);
        }

        $this->showModal(content: $env);
    }

    private function saveJobs()
    {
        Storage::put('jobs', $this->jobs->toJson(JSON_PRETTY_PRINT));
    }

    private function showModal(string $title = null, string $content = null)
    {
        $this->modalTitle = $title;
        $this->modalContent = $content;
    }
}
