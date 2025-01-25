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

        .crediCard.rearIsVsible {
            transform: rotateY(-180deg);
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








    <main class="flex min-h-screen flex-col items-center justify-between p-8 lg:p-24 bg-slate-100">
        <div class="grid grid-cols-1 md:grid-cols-2">

            <div>
                @if (session('error'))
                <div class="relative group mb-4">
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg blur opacity-25 group-hover:opacity-100 transition duration-1000 group-hover:duration-200">
                    </div>
                    <div
                        class="relative px-7 py-6 bg-white ring-1 ring-gray-900/5 rounded-lg leading-none flex items-top justify-start space-x-6">
                        <svg class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M6.75 6.75C6.75 5.64543 7.64543 4.75 8.75 4.75H15.25C16.3546 4.75 17.25 5.64543 17.25 6.75V19.25L12 14.75L6.75 19.25V6.75Z">
                            </path>
                        </svg>
                        <div class="space-y-2">
                            <p class="text-red-800">Error: {{ session('error') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <form class="bg-white w-full max-w-3xl mx-auto px-6 py-8 shadow-md rounded-md flex mb-4"
                    action="{{ route('cart.payment') }}" method="POST">
                    @csrf

                    <div class="pr-8 border-r-2 border-slate-300">
                        <label class="text-neutral-800 font-bold text-sm mb-2 block">Card number:</label>
                        <input type="text"
                            class="flex h-10 w-full rounded-md border-2 px-4 py-1.5 text-lg ring-offset-background focus-visible:outline-none focus-visible:border-purple-600 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mb-4"
                            id="cardNumber" onclick="flipCard('flipToFront')" maxlength="19" name="cardNumber"
                            placeholder="XXXX XXXX XXXX XXXX" required />
                        <div class="flex gap-x-2 mb-4">
                            <div class="flex-1">
                                <label class="text-neutral-800 font-bold text-sm mb-2 block">Exp. date:</label>
                                <input type="text"
                                    class="flex h-10 w-full rounded-md border-2 px-4 py-1.5 text-lg ring-offset-background focus-visible:outline-none focus-visible:border-purple-600 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mb-4"
                                    id="expDate" onclick="flipCard('flipToFront')" maxlength="5" minlength="5" name="expDate"
                                    placeholder="MM/YY" required />
                            </div>
                            <div class="flex-1">
                                <label class="text-neutral-800 font-bold text-sm mb-2 block">CCV:</label>
                                <input type="text"
                                    class="flex h-10 w-full rounded-md border-2 px-4 py-1.5 text-lg ring-offset-background focus-visible:outline-none focus-visible:border-purple-600 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 mb-4"
                                    id="ccvNumber" onclick="flipCard('flipToRear')" maxlength="3" minlength="3" name="ccvNumber"
                                    placeholder="123" required />
                            </div>
                        </div>

                        <label class="text-neutral-800 font-bold text-sm mb-2 block">Card holder:</label>
                        <input type="text"
                            class="flex h-10 w-full rounded-md border-2 px-4 py-1.5 text-lg ring-offset-background focus-visible:outline-none focus-visible:border-purple-600 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            id="cardName" onclick="flipCard('flipToFront')" placeholder="John Doe" name="cardName" required />

                        <button type="submit"
                            class="flex items-center justify-center bg-orange-600 hover:bg-orange-700 text-white font-bold text-lg rounded-md px-6 py-2 w-40 h-12 ml-auto mt-4">
                            Pay
                        </button>
                    </div>



                </form>
            </div>

            <div class="w-full md:pl-5 md:w-1/2">
                <div class="w-full h-56" style="perspective: 1000px">
                    <div id="creditCard" class="crediCard relative cursor-pointer transition-transform duration-500"
                        style="transform-style: preserve-3d" onclick="flipCard('flip')">
                        <div class="w-full m-auto rounded-xl shadow-2xl absolute" style="backface-visibility: hidden">
                            <img src="https://i.ibb.co/swnZ5b1/Front-Side-Card.jpg"
                                class="relative object-cover w-full h-full rounded-xl" />
                            <div class="w-full px-8 absolute top-8 text-white">
                                <div class="pt-1">
                                    <p class="font-light">Card Number</p>
                                    <p id="imageCardNumber" class="font-medium tracking-more-wider h-6">
                                        XXXX XXXX XXXX XXXX
                                    </p>
                                </div>
                                <div class="pt-6 flex justify-between">
                                    <div>
                                        <p class="font-light">Name</p>
                                        <p id="imageCardName" class="font-medium tracking-widest h-6">
                                            XXXX XXX
                                        </p>
                                    </div>
                                    <div>
                                        <p class="font-light">Expiry</p>
                                        <p id="imageExpDate" class="font-medium tracking-wider h-6 w-14">
                                            XX/XX
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full m-auto rounded-xl shadow-2xl absolute"
                            style="backface-visibility: hidden; transform: rotateY(180deg)">
                            <img src="https://i.ibb.co/Fn11jBc/Rear-Side-Card.jpg"
                                class="relative object-cover w-full h-full rounded-xl" />
                            <div class="w-full absolute top-8">
                                <div class="px-8 mt-11">
                                    <p id="imageCCVNumber"
                                        class="text-black flex items-center pl-4 pr-2 w-14 ml-auto">
                                        XXX
                                    </p>
                                    <p class="text-white font-light flex justify-end text-sm mt-2">
                                        security code
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        const cardEl = document.getElementById("creditCard");
        const flipCard = (flip) => {
            if (flip === "flipToRear" && !cardEl.classList.contains("rearIsVsible")) {
                cardEl.classList.add("rearIsVsible");
            }
            if (flip === "flipToFront" && cardEl.classList.contains("rearIsVsible")) {
                cardEl.classList.remove("rearIsVsible");
            }
            if (flip === "flip") {
                if (cardEl.classList.contains("rearIsVsible")) {
                    cardEl.classList.remove("rearIsVsible");
                } else {
                    cardEl.classList.add("rearIsVsible");
                }
            }
        };

        // Handle Card Number update
        const inputCardNumber = document.getElementById("cardNumber");
        const imageCardNumber = document.getElementById("imageCardNumber");

        inputCardNumber.addEventListener("input", (event) => {
            //   Remove all non-numeric characters from the input
            const input = event.target.value.replace(/\D/g, "");

            // Add a space after every 4 digits
            let formattedInput = "";
            for (let i = 0; i < input.length; i++) {
                if (i % 4 === 0 && i > 0) {
                    formattedInput += " ";
                }
                formattedInput += input[i];
            }

            inputCardNumber.value = formattedInput;
            imageCardNumber.innerHTML = formattedInput;
        });

        // Handle CCV update
        const inputCCVNumber = document.getElementById("ccvNumber");
        const imageCCVNumber = document.getElementById("imageCCVNumber");

        inputCCVNumber.addEventListener("input", (event) => {
            // Remove all non-numeric characters from the input
            const input = event.target.value.replace(/\D/g, "");
            inputCCVNumber.value = input;
            imageCCVNumber.innerHTML = input;
        });

        // Handle Exp Date update
        const expirationDate = document.getElementById("expDate");
        const imageExpDate = document.getElementById("imageExpDate");

        expirationDate.addEventListener("input", (event) => {
            // Remove all non-numeric characters from the input
            const input = event.target.value.replace(/\D/g, "");

            // Add a '/' after the first 2 digits
            let formattedInput = "";
            for (let i = 0; i < input.length; i++) {
                if (i % 2 === 0 && i > 0) {
                    formattedInput += "/";
                }
                formattedInput += input[i];
            }

            expirationDate.value = formattedInput;
            imageExpDate.innerHTML = formattedInput;
        });

        // Handle Card Name update
        const inputCardName = document.getElementById("cardName");
        const imageCardName = document.getElementById("imageCardName");

        inputCardName.addEventListener("input", (event) => {
            imageCardName.innerHTML = event.target.value;
        });
    </script>

</body>

</html>
