<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tailwind CSS Test - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center">
            Tailwind CSS Test Page
        </h1>

        <!-- Colors Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Colors</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md">
                    <p class="font-medium">Blue</p>
                </div>
                <div class="bg-green-500 text-white p-4 rounded-lg shadow-md">
                    <p class="font-medium">Green</p>
                </div>
                <div class="bg-red-500 text-white p-4 rounded-lg shadow-md">
                    <p class="font-medium">Red</p>
                </div>
                <div class="bg-yellow-500 text-white p-4 rounded-lg shadow-md">
                    <p class="font-medium">Yellow</p>
                </div>
            </div>
        </section>

        <!-- Typography Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Typography</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <p class="text-xs text-gray-600 mb-2">Extra Small Text</p>
                <p class="text-sm text-gray-600 mb-2">Small Text</p>
                <p class="text-base text-gray-700 mb-2">Base Text</p>
                <p class="text-lg text-gray-800 mb-2">Large Text</p>
                <p class="text-xl font-bold text-gray-900 mb-2">Extra Large Bold</p>
                <p class="text-2xl font-extrabold text-gray-900">2XL Extra Bold</p>
            </div>
        </section>

        <!-- Spacing & Layout Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Spacing & Layout</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-16 h-16 bg-indigo-500 rounded"></div>
                    <div class="w-16 h-16 bg-purple-500 rounded"></div>
                    <div class="w-16 h-16 bg-pink-500 rounded"></div>
                </div>
                <div class="space-y-4">
                    <div class="p-4 bg-gray-200 rounded">Padding 4</div>
                    <div class="p-6 bg-gray-300 rounded">Padding 6</div>
                    <div class="p-8 bg-gray-400 rounded">Padding 8</div>
                </div>
            </div>
        </section>

        <!-- Buttons Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Buttons</h2>
            <div class="flex flex-wrap gap-4">
                <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition-colors">
                    Primary Button
                </button>
                <button class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition-colors">
                    Success Button
                </button>
                <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition-colors">
                    Danger Button
                </button>
                <button class="border-2 border-gray-500 hover:bg-gray-500 hover:text-white text-gray-700 font-semibold py-2 px-4 rounded transition-colors">
                    Outline Button
                </button>
            </div>
        </section>

        <!-- Cards Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Cards</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Card 1</h3>
                    <p class="text-gray-600">This is a sample card with hover effect.</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Card 2</h3>
                    <p class="text-gray-600">This is a sample card with hover effect.</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Card 3</h3>
                    <p class="text-gray-600">This is a sample card with hover effect.</p>
                </div>
            </div>
        </section>

        <!-- Responsive Design Section -->
        <section class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Responsive Design</h2>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-sm md:text-base lg:text-lg xl:text-xl text-gray-700">
                    This text changes size based on screen width:
                    <span class="block sm:inline">Mobile: Small</span>
                    <span class="hidden md:inline">Tablet: Base</span>
                    <span class="hidden lg:inline">Desktop: Large</span>
                    <span class="hidden xl:inline">XL: Extra Large</span>
                </div>
            </div>
        </section>

        <!-- Back Link -->
        <div class="text-center">
            <a href="/" class="inline-block bg-gray-800 hover:bg-gray-900 text-white font-semibold py-2 px-6 rounded transition-colors">
                Back to Home
            </a>
        </div>
    </div>
</body>
</html>

