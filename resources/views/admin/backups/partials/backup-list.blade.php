


<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 overflow-hidden">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:text-gray-400">
        <tr class="bg-gray-50">
            <th class="px-4 py-3 text-left">
                File Name
            </th>
            <th class="px-4 py-3 text-left">
                Size
            </th>
            <th class="px-4 py-3 text-left">
                Last Modified
            </th>
            <th class="px-4 py-3 text-left">
                Actions
            </th>
        </tr>
    </thead>
    <tbody class="text-gray-600">


        @forelse ($backups as $backup)
            <tr class="hover:bg-gray-50  border-b border-stroke {{ $loop->index % 2 == 0 ? '' : 'bg-gray-50' }}">
                <td class="px-4 py-3 text-left">{{ $backup['name'] }}</td>
                <td class="px-4 py-3 text-left">{{ number_format($backup['size'] / 1024 / 1024, 2) }} MB</td>
                <td class="px-4 py-3 text-left">{{ date('Y-m-d H:i:s', $backup['last_modified']) }}</td>


                <td class="px-4 py-3 flex space-x-2 items-end text-right">

                    <form action="{{ route('backups.delete', ['type' => $type, 'filename' => $backup['name']]) }}" method="POST" class="inline" id="delete">
                        @csrf
                        @method('DELETE')
                    </form>


                    <a href="{{ route('backups.download', ['type' => $type, 'filename' => $backup['name']]) }}"
                        class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700">
                        <i class="fad fa-download mr-2"></i>Download
                    </a>

                    <button form="delete" type="submit" class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700"
                            onclick="return confirm('Are you sure you want to delete this backup?')">
                            <i class="fad fa-trash-alt mr-2"></i>Delete
                    </button>


                </td>


            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-4 py-2 text-center">No backups found.</td>
            </tr>
        @endforelse

    </tbody>

</table>
