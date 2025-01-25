<!DOCTYPE html>
<html>
<head>
    <title>Welcome | Cafe System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 to-orange-100 min-h-screen flex flex-col">
    <header class="flex justify-between items-center py-6 px-8 bg-orange-600 text-white">
        <div class="flex items-center">
            <svg class="h-8 w-auto mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 62 65">
                <!-- SVG Path Content -->
            </svg>
            <span class="text-xl font-bold">Cafe Management System</span>
        </div>
        <nav class="space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded bg-white text-orange-600 font-medium hover:bg-orange-100">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded bg-white text-orange-600 font-medium hover:bg-orange-100">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded bg-white text-orange-600 font-medium hover:bg-orange-100">Register</a>
                    @endif
                @endauth
            @endif
        </nav>
    </header>

    <main class="flex-grow flex flex-col items-center justify-center text-center px-4">
        <h1 class="text-5xl font-bold text-orange-700 mb-4">Welcome to Cafe Management System</h1>
        <p class="text-lg text-gray-700 mb-6">Simplify your cafe's operations with ease and efficiency.</p>
        <div class="space-x-4">
            <a href="{{ route('login') }}" class="px-6 py-3 bg-orange-600 text-white rounded-lg text-lg font-medium hover:bg-orange-700">Get Started</a>
            <a href="{{ route('register') }}" class="px-6 py-3 bg-gray-100 text-orange-600 rounded-lg text-lg font-medium hover:bg-gray-200">Sign Up</a>
        </div>
    </main>

    <footer class="py-4 bg-orange-600 text-white text-center">
        <p>&copy; 2024 Cafe Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
