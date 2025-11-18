<div class="">
    <div class="">

        <div class="mb-8">
            <x-main-heading title="Clients" subtitle="Manage your business relationships and track client progress." />
        </div>

        @if (session('success'))
            <div class="mb-6">
                <x-success-message>
                    {{ session('success') }}
                </x-success-message>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Clients</p>
                <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                    {{-- {{ $totalClients ?? '12' }} --}} 12
                </p>
            </div>
            <div
                class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Active Projects</p>
                <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                    {{-- {{ $activeProjects ?? '5' }} --}} 5
                </p>
            </div>
            {{-- <div
                class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Pending Invoices</p>
                <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                    3
                </p>
            </div> --}}
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">

            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <x-input-field type="text" placeholder="Search clients..." class="pl-10" />
            </div>

            <a href="#"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-neutral-900 hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500 w-full sm:w-auto justify-center">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Client
            </a>
        </div>

        <div
            class="bg-white dark:bg-neutral-800 shadow-sm border border-neutral-200 dark:border-neutral-700 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                    <thead class="bg-neutral-50 dark:bg-neutral-700/50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Client Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Company</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Last Contact</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">

                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 bg-neutral-200 dark:bg-neutral-700 rounded-full flex items-center justify-center text-neutral-500 dark:text-neutral-300 font-bold">
                                        JD
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">John Doe
                                        </div>
                                        <div class="text-sm text-neutral-500 dark:text-neutral-400">john@example.com
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900 dark:text-neutral-100">Acme Corp</div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">Tech Industry</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-neutral-100 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-300 border border-neutral-200 dark:border-neutral-600">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                Nov 14, 2025
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#"
                                    class="text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100 mr-3">Edit</a>
                                <button
                                    class="text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Delete</button>
                            </td>
                        </tr>

                        <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 bg-neutral-200 dark:bg-neutral-700 rounded-full flex items-center justify-center text-neutral-500 dark:text-neutral-300 font-bold">
                                        SJ
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">Sarah
                                            Jones</div>
                                        <div class="text-sm text-neutral-500 dark:text-neutral-400">sarah@startup.io
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900 dark:text-neutral-100">Startup IO</div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">Marketing</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-neutral-200 text-neutral-600 dark:bg-neutral-900 dark:text-neutral-500 border border-neutral-300 dark:border-neutral-700">
                                    Inactive
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                Oct 02, 2025
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="#"
                                    class="text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100 mr-3">Edit</a>
                                <button
                                    class="text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Delete</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <div
                class="bg-white dark:bg-neutral-800 px-4 py-3 flex items-center justify-between border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-neutral-700 dark:text-neutral-400">
                            Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span
                                class="font-medium">12</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-500 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                                <span>Previous</span>
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-500 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                                <span>Next</span>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
