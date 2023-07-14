<div>
    <div class="rounded-lg px-6 py-4 text-sm dark:bg-gray-800 bg-white" x-data="{ expanded: false }">
        <div class="flex items-center justify-between cursor-pointer" @click="expanded = ! expanded">
            <h5 class="font-bold text-xl">Schedule a new task</h5>
        </div>
        <div class="py-2" x-show="expanded" x-collapse x-cloak>
            <div
                class="bg-gray-50 text-gray-600 dark:bg-gray-700 dark:text-gray-400 flex flex-row rounded-lg p-4 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="text-gray-400 h-6 flex-shrink-0">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>
                </svg>
                <div class="ml-4 mt-0.5 flex flex-grow">
                    <p class="">
                        Schedule any recurring tasks that need to run on your computer. <b>Don't forget to use absolute paths</b>
                    </p>
                </div>
            </div>

        <div class="mt-4 flex flex-col">
            <label class="font-bold">Command</label>

            <div class="mt-1 flex items-center">
                <input type="text" class="w-full border rounded p-2"
                       placeholder="php /Users/{{ get_current_user() }}/Sites/my-laravel-app/artisan schedule:run"
                       list="commands" autocorrect="off" wire:model="command">
                <datalist id="commands">
                </datalist>
            </div>
        </div>

        <div class="mt-4 flex space-x-4 items-center">
                <p class="">
                    Select a .env file to use when running this command
                </p>
                <input type="text"
                       readonly
                       value="{{ $envFile }}"
                       class="flex-1 p-2 rounded border border-gray-200"
                       placeholder=""/>

                <button
                    wire:click="selectEnv"
                    class="bg-gradient-to-b from-[#4B91F7] to-[#367AF6] rounded-lg text-white py-1 px-2 shadow">
                    Select File
                </button>
            </div>

{{--                <div class="mt-4 flex flex-col"><label>User</label>--}}
{{--                    <div class="mt-1 flex items-center"><input type="text" class="w-full"--}}
{{--                                                               list="serverSchedulerUsers" autocomplete="off">--}}
{{--                        <datalist id="serverSchedulerUsers">--}}
{{--                        </datalist>--}}
{{--                    </div>--}}
{{--                </div>--}}
            <div class="mt-4 flex flex-col">
                <label class="font-bold">Frequency</label>

                <div class="mt-1 flex space-x-4">
                    <div class="mt-1">
                        <label class="flex items-center">
                            <input type="radio" name="frequency" class="" value="minutely" wire:model="frequency">
                            &nbsp;&nbsp;Every Minute
                        </label>
                    </div>

                    <div class="mt-1">
                        <label class="flex items-center">
                            <input type="radio" name="frequency" class="" value="hourly" wire:model="frequency">
                            &nbsp;&nbsp;Hourly
                        </label>
                    </div>

                    <div class="mt-1">
                        <label class="flex items-center">
                            <input type="radio" name="frequency" class="" value="daily" wire:model="frequency">
                            &nbsp;&nbsp;Nightly
                        </label>
                    </div>

                    <div class="mt-1">
                        <label class="flex items-center">
                            <input type="radio" name="frequency" class="" value="weekly" wire:model="frequency">
                            &nbsp;&nbsp;Weekly
                        </label>
                    </div>

                    <div class="mt-1">
                        <label class="flex items-center">
                            <input type="radio" name="frequency" class="" value="monthly" wire:model="frequency">
                            &nbsp;&nbsp;Monthly
                        </label>
                    </div>

                    <div class="mt-1">
                        <label class="flex items-center">
                            <input type="radio" name="frequency" class="" value="yearly" wire:model="frequency">
                            &nbsp;&nbsp;Yearly
                        </label>
                    </div>

{{--                        <div class="mt-1">--}}
{{--                            <label class="flex items-center">--}}
{{--                                <input type="radio" name="frequency" class="" value="reboot">--}}
{{--                                &nbsp;&nbsp;On Reboot--}}
{{--                            </label>--}}
{{--                        </div>--}}

                    <div class="mt-1">
                        <label class="flex items-center">
                            <input type="radio" name="frequency" class="" value="custom" wire:model="frequency">
                            &nbsp;&nbsp;Custom
                        </label>
                    </div>
                </div>
            </div>

            @if($frequency === 'custom')
                <div class="mt-4 flex flex-col">
                    <label class="font-bold">Custom Schedule</label>
                    <div class="mt-1 grid grid-cols-5 gap-2">
                        <input placeholder="minute" type="text" class=" border rounded p-2" wire:model="minute">
                        <input placeholder="hour" type="text" class=" border rounded p-2" wire:model="hour">
                        <input placeholder="day of month" type="text" class=" border rounded p-2" wire:model="date">
                        <input placeholder="month" type="text" class=" border rounded p-2" wire:model="month">
                        <input placeholder="day of week" type="text" class=" border rounded p-2" wire:model="day">
                    </div>

                    <div class="bg-gray-50 text-gray-600 dark:bg-gray-700 dark:text-gray-400 flex flex-row rounded-lg p-4 text-sm mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="text-gray-400 h-6 flex-shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>
                        </svg>
                        <div class="ml-4 mt-0.5 flex flex-grow">
                            <p class="">Need help formatting your own expression?
                                Check out <a href="https://crontab.guru/" class="text-blue-500" target="_blank"
                                             rel="noopener noreferrer">crontab.guru</a>.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-4 grid grid-cols-3" wire:poll.visible.5000ms>
                <div class="col-span-2">
                    @if(count($this->nextRuns) > 0)
                        <span class="font-semibold">Next Expected Runs (UTC):</span>
                        <ul>
                            @foreach($this->nextRuns as $run)
                                <li>{{ $run }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="flex items-end justify-end gap-4">
                    <button class="cursor-pointer rounded bg-transparent border-2 overflow-hidden border-gray-700 px-4 py-2 hover:bg-gray-700 hover:text-white"
                            wire:click="clear" @click="expanded = false">
                        <span class="flex items-center justify-between">Cancel</span>
                    </button>
                    <button class="cursor-pointer rounded bg-black px-4 py-2 border-2 border-gray-700 overflow-hidden text-white hover:bg-gray-700 disabled:bg-gray-400 disabled:border-gray-400 disabled:cursor-not-allowed"
                            wire:click="createJob" @click="expanded = false" {{ ! $command || ! $frequency ? 'disabled' : '' }}>
                        <span class="flex items-center justify-between">Create</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
