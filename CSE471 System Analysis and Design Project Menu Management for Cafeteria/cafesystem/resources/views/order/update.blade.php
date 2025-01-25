<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Update Order Status</h1>
        @if (session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-md">
                <thead class="bg-gray-200 text-gray-600">
                    <tr>
                        <th class="py-3 px-6 text-left">Order ID</th>
                        <th class="py-3 px-6 text-left">Customer ID</th>
                        <th class="py-3 px-6 text-left">Current Status</th>
                        <th class="py-3 px-6 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $order->order_id }}</td>
                        <td class="py-3 px-6">{{ $order->customer_id }}</td>
                        <td class="py-3 px-6">{{ $order->status }}</td>
                        <td class="py-3 px-6">
                            <form action="{{ route('order.updateStatus', $order->order_id) }}" method="POST">
                                @csrf
                                <div class="flex items-center space-x-2">
                                    <select name="status" id="status-{{ $order->order_id }}" class="border px-2 py-1 rounded-lg">
                                        <option value="Pending" {{ $order->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Preparing" {{ $order->status === 'Preparing' ? 'selected' : '' }}>Preparing</option>
                                        <option value="Ready" {{ $order->status === 'Ready' ? 'selected' : '' }}>Ready</option>
                                        <option value="Delivered" {{ $order->status === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>
                                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-lg">Update</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">No orders available.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
