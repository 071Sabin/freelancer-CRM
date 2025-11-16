<div class="w-full">

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-gray-100 tracking-tight">
            Dashboard
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">
            Overview of your clients, projects, invoices, and insights.
        </p>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <!-- Clients -->
        <div class="bg-white dark:bg-neutral-900 border border-stone-200 dark:border-stone-800 rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Clients</h3>
                <i class="bi bi-people text-gray-400 text-lg"></i>
            </div>
            <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-2">
                12
            </p>
            <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                +3 new this month
            </p>
        </div>

        <!-- Projects -->
        <div
            class="bg-white dark:bg-neutral-900 border border-stone-200 dark:border-stone-800 rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Projects</h3>
                <i class="bi bi-kanban text-gray-400 text-lg"></i>
            </div>
            <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-2">
                5
            </p>
            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                2 in progress
            </p>
        </div>

        <!-- Revenue -->
        <div
            class="bg-white dark:bg-neutral-900 border border-stone-200 dark:border-stone-800 rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</h3>
                <i class="bi bi-currency-dollar text-gray-400 text-lg"></i>
            </div>
            <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-2">
                $4,250
            </p>
            <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                +12% growth
            </p>
        </div>

        <!-- Invoices -->
        <div
            class="bg-white dark:bg-neutral-900 border border-stone-200 dark:border-stone-800 rounded-xl p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Invoices</h3>
                <i class="bi bi-receipt text-gray-400 text-lg"></i>
            </div>
            <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-2">
                3
            </p>
            <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                1 overdue
            </p>
        </div>

    </div>

    <!-- Two-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Projects -->
        <div
            class="lg:col-span-2 bg-white dark:bg-neutral-900 border border-stone-200 dark:border-stone-800 
                    rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                Recent Projects
            </h2>

            <div class="divide-y divide-stone-200 dark:divide-stone-700">
                <div class="py-4 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800 dark:text-gray-100">Website Redesign</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Client: Alpha Co.</p>
                    </div>
                    <span
                        class="px-2.5 py-1 rounded text-xs bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                        In Progress
                    </span>
                </div>

                <div class="py-4 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800 dark:text-gray-100">Logo Design</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Client: Freelance Hub</p>
                    </div>
                    <span
                        class="px-2.5 py-1 rounded text-xs bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
                        Completed
                    </span>
                </div>

                <div class="py-4 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800 dark:text-gray-100">SEO Optimization</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Client: Bright Foods</p>
                    </div>
                    <span
                        class="px-2.5 py-1 rounded text-xs bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300">
                        Pending
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div
            class="bg-white dark:bg-neutral-900 border border-stone-200 dark:border-stone-800 
                    rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                Quick Actions
            </h2>

            <div class="flex flex-col gap-3">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white text-center rounded-lg hover:bg-indigo-700">
                    + New Project
                </a>
                <a href="#"
                    class="px-4 py-2 bg-stone-200 text-stone-900 dark:bg-stone-700 dark:text-stone-100 
                                   text-center rounded-lg hover:bg-stone-300 dark:hover:bg-stone-600">
                    + New Client
                </a>
                <a href="#"
                    class="px-4 py-2 bg-stone-100 dark:bg-stone-800 text-center rounded-lg 
                                   hover:bg-stone-200 dark:hover:bg-stone-700 text-stone-800 dark:text-stone-200">
                    Generate Invoice
                </a>
            </div>
        </div>

    </div>

</div>
