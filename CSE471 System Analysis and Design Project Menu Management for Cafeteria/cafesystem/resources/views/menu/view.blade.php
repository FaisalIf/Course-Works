<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu | Cafe System</title>
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
                    <span class="text-gray-700">Welcome back!</span>
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

        <!-- Menu Section -->
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Our Menu</h2>
                <p class="text-gray-600">Explore our delicious selection of food and beverages.</p>
            </div>
        </div>

        <!-- Sorting and Filtering Section -->
        <div class="mt-8 px-4 sm:px-0">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="GET" action="{{ route('menu.view') }}" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                        <select id="sort" name="sort" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                            <option value="popularity_score" {{ request('sort') == 'popularity_score' ? 'selected' : '' }}>Popularity</option>
                        </select>
                    </div>
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Filter By Category</label>
                        <select id="category" name="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm rounded-md">
                            <option value="">All</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2 flex justify-end space-x-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                            Apply
                        </button>
                        <a href="{{ route('menu.view') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Menu Items Section -->
        <div class="mt-8 px-4 sm:px-0">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($menuItems as $item)
                    <div class="bg-white overflow-hidden shadow-md rounded-lg hover:shadow-xl transition">
                        <!-- Image -->
                        <div class="w-full aspect-square overflow-hidden">
                            <img 
                                src="{{ $item->photo_url ? asset($item->photo_url) : 'https://via.placeholder.com/300x300' }}" 
                                alt="{{ $item->name }}" 
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <!-- Card Body -->
                        <div class="p-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-2">{{ $item->name }}</h4>
                            <p class="text-gray-600 mb-4">{{ $item->description }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-orange-600 font-semibold">₱{{ number_format($item->price, 2) }}</span>
                                <span class="text-sm text-gray-500">{{ $item->category }}</span>
                            </div>
                            <div class="mt-4">
                                <span class="text-sm {{ $item->is_available ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $item->is_available ? 'Available' : 'Not Available' }}
                                </span>
                                <span class="text-sm text-gray-500 ml-2">Popularity: {{ $item->popularity_score }}</span>
                            </div>

                            <!-- Add to Cart Form -->
                            @if($item->is_available)
                                <form method="POST" action="{{ route('cart.add') }}" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->item_id }}">
                                    <div class="flex items-center space-x-4">
                                        <input 
                                            type="number" 
                                            name="quantity" 
                                            value="1" 
                                            min="1" 
                                            max="10" 
                                            class="w-16 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                        >
                                        <button 
                                            type="submit" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition"
                                        >
                                            Add to Cart
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="mt-4 text-center text-gray-500 text-sm">
                                    Currently Unavailable
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</body>
</html>