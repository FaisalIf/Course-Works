<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Cafe System</title>
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
                    <span class="text-gray-700">Welcome, Admin!</span>
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
        <!-- Welcome Section -->
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Admin Dashboard</h2>
                <p class="text-gray-600">Manage all aspects of the cafe system efficiently.</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 px-4 sm:px-0">
            <a href="{{ route('menu.manage') }}" class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Manage Menu</h3>
                    <p class="mt-2 text-gray-600">Add, edit, delete items, and organize categories.</p>
                </div>
            </a>

            <a href="{{ route('order.incoming') }}" class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">View Incoming Orders</h3>
                    <p class="mt-2 text-gray-600">Track and manage incoming orders.</p>
                </div>
            </a>

            <a href="{{ route('order.update') }}" class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Update Order Status</h3>
                    <p class="mt-2 text-gray-600">Update the status of customer orders.</p>
                </div>
            </a>

            <a href="{{ route('items.unavailable') }}" class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Mark Item as Unavailable</h3>
                    <p class="mt-2 text-gray-600">Mark out-of-stock items as unavailable.</p>
                </div>
            </a>

            <a href="{{ route('items.highlight') }}" class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Highlight Items of the Day</h3>
                    <p class="mt-2 text-gray-600">Highlight today's featured items.</p>
                </div>
            </a>

            <!-- <a href="{{ route('revenue.daily') }}" class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Display Daily Revenue</h3>
                    <p class="mt-2 text-gray-600">View daily sales revenue.</p>
                </div>
            </a> -->

            <a href="{{ route('promotions.add') }}" class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Add Promotions & Discounts</h3>
                    <p class="mt-2 text-gray-600">Add promotional offers and discounts.</p>
                </div>
            </a>
        </div>
    </main>
</body>
</html>
