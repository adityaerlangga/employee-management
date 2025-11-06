<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Salary Calculations - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Salary Calculations</h1>
            <a href="{{ route('salary-calculation.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded transition-colors">
                Create New Calculation
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($workEntries->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-600 mb-4">No salary calculations found.</p>
                <a href="{{ route('salary-calculation.create') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded transition-colors">
                    Create Your First Calculation
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($workEntries as $group => $entries)
                    @php
                        $firstEntry = $entries->first();
                        $employee = $firstEntry->employee;
                        $totalDays = $entries->count();
                        $totalSalary = $entries->sum('daily_salary');
                    @endphp
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $employee->name }}</h2>
                                <p class="text-gray-600">ID: {{ $employee->employee_id }}</p>
                                <p class="text-gray-600">Email: {{ $employee->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::create()->month($firstEntry->month)->format('F') }} {{ $firstEntry->year }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $totalDays }} days worked</p>
                            </div>
                        </div>
                        <div class="border-t pt-4">
                            <p class="text-xl font-bold text-green-600">Total Salary: Rp {{ number_format($totalSalary, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="/" class="text-blue-600 hover:text-blue-800">Back to Home</a>
        </div>
    </div>
</body>
</html>

