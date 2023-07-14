<div class="space-y-4 w-[1000px] ">
    <div class="rounded-lg px-6 py-4 text-sm dark:bg-gray-800 bg-white">
        <div class="flex items-center justify-between"><h5 class="font-bold text-xl">Scheduled tasks</h5></div>
        <div class="py-2">
            <table class="w-full text-left">
                <thead class="text-gray-500">
                <tr class="h-10">
                    <th class="pr-4 font-normal">Frequency</th>
                    <th class="pr-4 font-normal">Cron</th>
{{--                    <th class="pr-4 font-normal">User</th>--}}
                    <th class="w-full pr-4 font-normal">Command</th>
                    <th class="w-full pr-4 font-normal">Env</th>
                    <th class="pr-4 font-normal">Status</th>
                    <th class="w-4"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($jobs as $job)
                    <tr class="h-12 border-t border-gray-100 dark:border-gray-700">
                    <td class="pr-4">{{ $job->frequency }}</td>
                    <td class="min-w-[8rem] pr-4"><code class="text-red-400">{{ $job->cron }}</code></td>
{{--                    <td class="min-w-24 break-all pr-4">root</td>--}}
                    <td class="max-w-md pr-4">
                        <div class="group">
                            <div class="-mx-1 cursor-pointer rounded-sm px-1" tabindex="0">
                                <pre class="console my-2 text-xs"><code
                                        class="group-hover:whitespace-pre-wrap group-hover:break-all">{{ $job->command }}</code></pre>
                            </div>
                        </div>
                    </td>
                    <td class="pr-4">{{ ($job->env ?? null) ? '✅' : '❌' }}</td>
                    <td class="pr-4">
                        @if($job->active)
                            <span class="text-uppercase inline-flex items-center rounded-full px-2.5 py-1 text-sm bg-teal-400 bg-opacity-10 text-gray-900 dark:bg-teal-400/40 dark:text-white/80">
                                <span class="relative mr-1.5 flex h-2.5 w-2.5"><span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-teal-400"></span></span>
                                Active
                            </span>
                        @else
                            <span class="text-uppercase inline-flex items-center rounded-full px-2.5 py-1 text-sm bg-yellow-400 bg-opacity-20 text-gray-900 dark:bg-amber-400/40 dark:text-amber-400">
                                <span class="relative mr-1.5 flex h-2.5 w-2.5"><span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-yellow-400"></span></span>
                                Paused
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="flex justify-end" x-data="{
                            open: false,
                            confirmDelete: false,
                            close() {
                                this.open = false
                                this.confirmDelete = false
                            }
                        }">
                            <span class="relative">
                                <button class="text-gray-400 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-full cursor-pointer" @click="open = ! open">
                                    <svg viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-6 p-1">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M5.83325 3.49999C5.83325 2.85566 6.35559 2.33333 6.99992 2.33333C7.64425 2.33333 8.16658 2.85566 8.16658 3.49999C8.16658 4.14433 7.64425 4.66666 6.99992 4.66666C6.35559 4.66666 5.83325 4.14433 5.83325 3.49999ZM6.99992 5.83333C6.35559 5.83333 5.83325 6.35566 5.83325 6.99999C5.83325 7.64433 6.35559 8.16666 6.99992 8.16666C7.64425 8.16666 8.16658 7.64433 8.16658 6.99999C8.16658 6.35566 7.64425 5.83333 6.99992 5.83333ZM5.83325 10.5C5.83325 9.85566 6.35559 9.33333 6.99992 9.33333C7.64425 9.33333 8.16658 9.85566 8.16658 10.5C8.16658 11.1443 7.64425 11.6667 6.99992 11.6667C6.35559 11.6667 5.83325 11.1443 5.83325 10.5Z"
                                              fill="currentColor"></path>
                                    </svg>
                                </button>

                                    <button type="button" class="text-left px-2 py-1 hover:bg-gray-200 rounded m-1" wire:click="getJobLog('{{ $job->id }}')" @click="open = false">Show last output</button>
{{--                                    <div><button type="button" class="w-full">Show Next Runs</button></div>--}}
                                <div class="rounded-lg bg-white shadow-lg right-0 z-10 w-52 origin-top-right flex flex-col absolute"
                                     x-cloak x-show="open" x-transition @click.outside="close()">
                                    @if ($job->active)
                                        <button class="text-left px-2 py-1 hover:bg-gray-200 rounded m-1" wire:click="pauseJob('{{ $job->id }}')" @click="open = false">Pause task</button>
                                    @else
                                        <button class="text-left px-2 py-1 hover:bg-gray-200 rounded m-1" wire:click="resumeJob('{{ $job->id }}')" @click="open = false">Start task</button>
                                    @endif

                                    <hr>

                                    <button type="button" class="flex justify-between px-2 py-1 bg-red-100 hover:bg-red-200 rounded m-1 transition-all"
                                            @click="confirmDelete ? $wire.deleteJob('{{ $job->id }}') && close() : confirmDelete = true"
                                            :class="{'!bg-red-500 text-white': confirmDelete }">
                                        <span>Delete task</span>
                                        <span x-show="confirmDelete" class="font-bold">Are you sure?</span>
                                    </button>
                                </div>
                            </span>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @livewire('new-job')

    @if ($jobLog)
        <x-output-modal :command="$currentJob['command']">
            {{ $jobLog }}
        </x-output-modal>
    @endif
</div>
