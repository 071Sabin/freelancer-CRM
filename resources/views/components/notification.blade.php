@props(['type' => 'success'])

@php
    // Configuration based on type
    $config = [
        'success' => [
            'icon' => 'M5 13l4 4L19 7',
            'colorClass' => 'emerald',
            'title' => 'Success',
        ],
        'warning' => [
            'icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
            'colorClass' => 'amber',
            'title' => 'Attention Needed',
        ],
        'error' => [
            'icon' => 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z',
            'colorClass' => 'red',
            'title' => 'Error Occurred',
        ],
    ][$type] ?? $config['success'];
@endphp

<div id="toast-{{ uniqid() }}" class="pointer-events-none fixed top-0 right-0 z-[9999] p-6">
    <div x-data="{
            show: true,
            duration: 4200,
            init() {
                setTimeout(() => this.show = false, this.duration)
            }
        }" 
        x-show="show" 
        x-transition:enter="transform ease-[cubic-bezier(.16,1,.3,1)] duration-500"
        x-transition:enter-start="translate-x-6 opacity-0 scale-95"
        x-transition:enter-end="translate-x-0 opacity-100 scale-100" 
        x-transition:leave="transform ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-x-0" 
        x-transition:leave-end="opacity-0 translate-x-4"
        class="pointer-events-auto w-full max-w-sm"
        style="display: none;">

        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 border-l-[3px] border-l-{{ $config['colorClass'] }}-500 dark:border-l-{{ $config['colorClass'] }}-400 shadow-[0_10px_28px_-10px_rgba(0,0,0,0.18)] dark:shadow-[0_10px_28px_-10px_rgba(0,0,0,0.5)] ring-1 ring-black/5 dark:ring-white/10"
            role="alert" aria-live="assertive">

            <div class="px-4 py-3">
                <div class="flex items-start gap-3">
                    {{-- Dynamic Icon --}}
                    <div class="mt-[2px]">
                        <svg class="h-4 w-4 text-{{ $config['colorClass'] }}-600 dark:text-{{ $config['colorClass'] }}-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $config['icon'] }}" />
                        </svg>
                    </div>

                    {{-- Dynamic Content --}}
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                            {{ $config['title'] }}
                        </p>
                        <p class="mt-0.5 text-xs md:text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">
                            {{ $slot }}
                        </p>
                    </div>

                    {{-- Close Button --}}
                    <button @click="show = false"
                        class="rounded-md p-1 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition focus:outline-none focus:ring-2 focus:ring-{{ $config['colorClass'] }}-500/40">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Dynamic Progress Bar --}}
            <div class="absolute bottom-0 left-0 h-[2px] w-full bg-neutral-200 dark:bg-neutral-700">
                <div class="h-full bg-{{ $config['colorClass'] }}-500 dark:bg-{{ $config['colorClass'] }}-400"
                    x-bind:style="`animation: toast-progress ${duration}ms linear forwards`">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes toast-progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }
</style>


