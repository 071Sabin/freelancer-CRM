<div class="">

    <div class="mb-8">
        <x-main-heading title="Invoices"
            subtitle="Create, send, and track invoices with clear payment status and totals." />
        {{-- <p class="text-sm italic text-red-400 dark:text-red-600">Refresh to activate "Add Client" form</p> --}}
    </div>

    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif

    {{-- calling error component from the component --}}
    {{-- <x-error></x-error> --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Total Invoices -->
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                Total Invoices
            </p>
            <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">
                0
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                All time
            </p>
        </div>

        <!-- Paid Invoices -->
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                Paid Invoices
            </p>
            <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">
                0
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                Successfully paid
            </p>
        </div>

        <!-- Outstanding Amount -->
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                Outstanding Amount
            </p>
            <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">
                $0.00
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                Awaiting payment
            </p>
        </div>

        <!-- Overdue Invoices -->
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                Overdue Invoices
            </p>
            <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">
                0
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                Past due date
            </p>
        </div>

    </div>









</div>
