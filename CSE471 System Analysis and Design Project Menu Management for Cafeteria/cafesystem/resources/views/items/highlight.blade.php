<!DOCTYPE html>
<html lang="en">
<head>
    <title>Highlight Items | Cafe System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Highlight Items of the Day</h1>
        
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-md">
                <thead class="bg-gray-200 text-gray-600">
                    <tr>
                        <th class="py-3 px-6 text-left">Item Name</th>
                        <th class="py-3 px-6 text-left">Current Status</th>
                        <th class="py-3 px-6 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menuItems as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $item->name }}</td>
                        <td class="py-3 px-6">
                            {{ $item->highlight_id ? 'Highlighted' : 'Not Highlighted' }}
                        </td>
                        <td class="py-3 px-6">
                            <form action="{{ route('items.highlights', $item->item_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="highlight" value="{{ $item->highlight_id ? 0 : 1 }}">
                                <button type="submit" class="
                                    {{ $item->highlight_id ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} 
                                    text-white px-4 py-2 rounded-lg">
                                    {{ $item->highlight_id ? 'Remove Highlight' : 'Add Highlight' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4">No menu items found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
