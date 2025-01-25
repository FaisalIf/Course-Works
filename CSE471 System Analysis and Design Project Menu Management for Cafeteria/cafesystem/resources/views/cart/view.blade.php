<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | Cafe System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
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
                    <span class="text-gray-700"></span></span>
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

        <!-- Order List -->
        <div class="mt-8 px-4 sm:px-0">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Order List</h3>
                <a href="{{ route('cart.ClearCart') }}"
                    class="text-orange-600 hover:text-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                    Clear List
                </a>
            </div>
            <div class="grid grid-cols-1 gap-6">

                <div class="rounded-lg scrollbar-hidden overflow-scroll md:overflow-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-md">
                        <thead class="bg-gray-200 text-gray-600">
                            <tr>
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Item Name</th>
                                <th class="py-3 px-6 text-left">Quantity</th>
                                <th class="py-3 px-6 text-left">Price Per Item</th>
                                <th class="py-3 px-6 text-left">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $item_counter = 1;
                            @endphp
                            @forelse (Cart::session($userID)->getContent() as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6">{{ $item_counter }}</td>
                                    <td class="py-3 px-6">{{ $item->name }}</td>
                                    <td class="py-3 px-6">
                                        <form method="POST" action="{{ route('cart.update') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                class="w-16 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                                                min="0" max="100">
                                            <button type="submit"
                                                class="text-orange-600 hover:text-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition text-sm">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-3 px-6">${{ $item->price }}</td>
                                    <td class="py-3 px-6">{{ $item->getPriceSum() }}</td>
                                </tr>
                                @php
                                    $item_counter++;
                                @endphp

                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No orders available.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>


        <div class="mt-8 px-4 sm:px-0">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Add Coupon/ Promo Code</h3>
                        @forelse (Cart::session($userID)->getConditions() as $condition)
                            <div class="flex justify-between mt-4">
                                <span class="text-gray-600">{{ $condition->getName() }}</span>
                                <span class="text-green-900">{{ $condition->getValue() }}</span>
                            </div>
                            <div class="flex mt-4">
                                <form method="POST" action="{{ route('cart.removePromoCode') }}">
                                    @csrf
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                        Remove
                                    </button>
                                </form>
                            </div>

                        @empty
                            @if (session('error'))
                                <div class="text-red-600">{{ session('error') }}</div>
                            @endif
                            <form method="POST" action="{{ route('cart.addPromoCode') }}" class="mt-4 space-y-4">
                                @csrf
                                <input type="text" name="code" id="code-promo" required
                                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                                <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition">
                                    Apply Promo
                                </button>
                            </form>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Billing</h3>
                        <div class="flex justify-between mt-4">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">${{ Cart::session($userID)->getSubTotal() }}</span>
                        </div>
                        <div class="flex justify-between mt-4">
                            <span class="text-red-600">Promo</span>
                            <span class="text-red-900">-${{ Cart::getSubTotal() - Cart::getTotal() }}</span>
                        </div>

                        {{-- // devider --}}
                        <div class="border-t border-gray-200 mt-4"></div>
                        <div class="flex justify-between mt-4">
                            <span class="text-gray-600">Total</span>
                            <span class="text-gray-900">{{ Cart::getTotal() }}</span>
                        </div>


                        @if (Cart::getTotal() != 0)
                            <div class="w-full flex">
                                <a href="{{ route('cart.checkout') }} "
                                    class="w-1/2 flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition mt-4 space-y-4 mr-2 text-center">
                                    Pay Now
                                </a>

                                <a href="{{ route('cart.OrderWithoutPayment') }}"
                                    class="w-1/2 flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition mt-4 space-y-4 text-center">
                                    Order without Payment
                                </a>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="mt-8 px-4 sm:px-0">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('menu.view') }}"
                    class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">View Menu</h3>
                        <p class="mt-2 text-gray-600">Browse our delicious selection of food and beverages.</p>
                    </div>
                </a>

                <a href="{{ route('order.track') }}"
                    class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900">Track Order</h3>
                        <p class="mt-2 text-gray-600">View the status of your current orders.</p>
                    </div>
                </a>
            </div>
        </div>
    </main>
</body>

</html>
