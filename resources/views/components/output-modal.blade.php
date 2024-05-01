@props([
    'title' => null,
])
<div>
    <div x-data="{ open: @entangle('modalContent').live }" class="flex justify-center">
        <div
            x-show="open"
            style="display: none"
            x-on:keydown.escape.prevent.stop="open = false"
            role="dialog"
            aria-modal="true"
            x-id="['modal-title']"
            :aria-labelledby="$id('modal-title')"
            class="fixed inset-0 z-10 overflow-y-auto"
        >
            <!-- Overlay -->
            <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

            <!-- Panel -->
            <div
                x-show="open" x-transition
                x-on:click="open = false"
                class="relative flex min-h-screen items-center justify-center p-4"
            >
                <div
                    x-on:click.stop
                    x-trap.noscroll.inert="open"
                    class="relative w-full max-w-2xl overflow-y-auto rounded-xl bg-white p-6 shadow-lg"
                >
                    <button type="button" x-on:click="open = false" class="rounded-full border border-gray-200 bg-white h-8 w-8 float-right flex items-center justify-center">
                        <span>&times;</span>
                    </button>

                    @if($title)
                        <!-- Title -->
                        <h2 class="text-2xl font-bold" :id="$id('modal-title')">{{ $title }}</h2>
                    @endif

                    <!-- Content -->
                    <p class="mt-6 text-gray-600 p-4 bg-gray-100">
                        <code>
                            {!! nl2br($slot) !!}
                        </code>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
