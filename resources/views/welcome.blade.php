@auth('web')
    <x-layouts.app>
        <section class="w-full max-w-6xl mx-auto text-center mt-20 px-6 flex flex-col items-center hero-glow">

            <!-- Heading -->
            <h1
                class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight max-w-4xl
               text-neutral-900 dark:text-white">
                Build Faster. Launch Smarter.
                <span class="text-indigo-600 dark:text-indigo-400">Scale Without Limits.</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-lg md:text-xl mt-6 max-w-2xl
              text-neutral-600 dark:text-neutral-300">
                NovaEdge gives developers cutting-edge tools to craft powerful apps with unmatched speed,
                clarity, and scalability — from concept to launch.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-wrap items-center gap-4 mt-10">
                <a href="#get-started"
                    class="px-8 py-4 rounded-xl text-white font-semibold bg-indigo-600 hover:bg-indigo-700
                   dark:bg-indigo-500 dark:hover:bg-indigo-600 transition shadow-lg shadow-indigo-600/20">
                    Get Started
                </a>

                <a href="#features"
                    class="px-8 py-4 rounded-xl font-semibold border border-neutral-300 dark:border-neutral-700
                   text-neutral-800 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800
                   transition">
                    Explore Features
                </a>
            </div>
            {{-- <livewire:counter /> --}}
        </section>
    </x-layouts.app>
@endauth
