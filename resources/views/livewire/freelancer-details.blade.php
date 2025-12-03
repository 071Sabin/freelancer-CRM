<div>
    <div class="overflow-x-auto rounded-lg shadow-md">
        <table class="min-w-full border border-gray-300 bg-white">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700"><button wire:click="sortByName">Name</button></th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $u)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $u->id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $u->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800">{{ $u->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
