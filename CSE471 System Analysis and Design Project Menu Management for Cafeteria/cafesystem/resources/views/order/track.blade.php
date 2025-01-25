<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Orders | Cafe System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-orange-600">Cafe System</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, Customer!</span>
                    <a href="{{ route('logout') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Orders List -->
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your Orders</h2>

                @if($orders->isEmpty())
                    <p class="text-gray-600">You have no orders yet.</p>
                @else
                    <div class="space-y-6">
                        @foreach($orders as $order)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Order ID -->
                                    <div>
                                        <span class="text-gray-700 font-medium">Order ID:</span>
                                        <span class="text-gray-600">{{ $order->order_id }}</span>
                                    </div>
                                    <!-- Status -->
                                    <div>
                                        <span class="text-gray-700 font-medium">Status:</span>
                                        <span class="text-gray-600">{{ $order->status }}</span>
                                    </div>
                                    <!-- Total Amount -->
                                    <div>
                                        <span class="text-gray-700 font-medium">Total Amount:</span>
                                        <span class="text-gray-600">₱{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                    <!-- Payment Status -->
                                    <div>
                                        <span class="text-gray-700 font-medium">Payment Status:</span>
                                        <span class="text-gray-600">{{ $order->payment_status }}</span>
                                    </div>
                                    <!-- Order Date -->
                                    <div>
                                        <span class="text-gray-700 font-medium">Order Date:</span>
                                        <span class="text-gray-600">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y H:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>