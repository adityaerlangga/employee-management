<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Salary Calculation - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Create Salary Calculation</h1>
            <a href="{{ route('salary-calculation.index') }}" class="text-blue-600 hover:text-blue-800">← Back to List</a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('salary-calculation.store') }}" method="POST" id="salary-calculation-form" class="bg-white rounded-lg shadow-md p-6">
            @csrf

            <!-- Form Header Section -->
            <div class="mb-8 border-b pb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Employee Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="employee_name" class="block text-sm font-medium text-gray-700 mb-2">Employee Name</label>
                        <input type="text" id="employee_name" name="employee_name" value="{{ old('employee_name') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="employee_id" class="block text-sm font-medium text-gray-700 mb-2">Employee ID</label>
                        <input type="text" id="employee_id" name="employee_id" value="{{ old('employee_id') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="employee_email" class="block text-sm font-medium text-gray-700 mb-2">Employee Email</label>
                        <input type="email" id="employee_email" name="employee_email" value="{{ old('employee_email') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="hourly_rate" class="block text-sm font-medium text-gray-700 mb-2">Hourly Rate (Rp)</label>
                        <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" min="0" value="{{ old('hourly_rate') }}" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700 mb-2">Month</label>
                        <select id="month" name="month" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Month</option>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('month') == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                        <select id="year" name="year" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Year</option>
                            @for($i = 2020; $i <= 2030; $i++)
                                <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <!-- Work Entries Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold text-gray-800">Work Entries</h2>
                    <div class="space-x-2">
                        <button type="button" id="add-row-btn" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded transition-colors">
                            Add Row
                        </button>
                    </div>
                </div>
                <div id="work-entries-container">
                    <!-- Dynamic rows will be added here -->
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('salary-calculation.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded transition-colors">
                    Save Calculation
                </button>
            </div>
        </form>
    </div>

    <script>
        let rowCounter = 0;

        // Add a new work entry row
        function addRow(date = '') {
            const container = document.getElementById('work-entries-container');
            const row = document.createElement('div');
            row.className = 'work-entry-row mb-4 p-4 border border-gray-300 rounded-md bg-gray-50';
            row.dataset.rowIndex = rowCounter++;

            row.innerHTML = `
                <div class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" name="work_entries[${row.dataset.rowIndex}][date]" value="${date}" required
                               class="work-entry-date w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                        <input type="text" name="work_entries[${row.dataset.rowIndex}][start_time]" 
                               class="work-entry-start-time w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Select time" readonly required>
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                        <input type="text" name="work_entries[${row.dataset.rowIndex}][end_time]" 
                               class="work-entry-end-time w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Select time" readonly required>
                    </div>
                    <div class="flex-1 min-w-[150px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Daily Salary</label>
                        <input type="text" readonly
                               class="work-entry-salary w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100"
                               value="Rp 0">
                    </div>
                    <div class="flex-shrink-0">
                        <button type="button" class="remove-row-btn bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition-colors">
                            Remove
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(row);

            // Attach event listeners to the new row
            attachRowEventListeners(row);
        }

        // Remove a work entry row
        function removeRow(button) {
            const row = button.closest('.work-entry-row');
            if (row && document.querySelectorAll('.work-entry-row').length > 1) {
                row.remove();
            } else {
                alert('At least one row must remain.');
            }
        }

        // Calculate daily salary for a row
        function calculateDailySalary(row) {
            const hourlyRate = parseFloat(document.getElementById('hourly_rate').value) || 0;
            const startTimeInput = row.querySelector('.work-entry-start-time');
            const endTimeInput = row.querySelector('.work-entry-end-time');
            const salaryInput = row.querySelector('.work-entry-salary');

            if (!startTimeInput.value || !endTimeInput.value || hourlyRate === 0) {
                salaryInput.value = 'Rp 0';
                return;
            }

            const startTime = startTimeInput.value.split(':');
            const endTime = endTimeInput.value.split(':');

            const startMinutes = parseInt(startTime[0]) * 60 + parseInt(startTime[1]);
            const endMinutes = parseInt(endTime[0]) * 60 + parseInt(endTime[1]);

            if (endMinutes <= startMinutes) {
                salaryInput.value = 'Rp 0';
                salaryInput.classList.add('border-red-500');
                return;
            }

            salaryInput.classList.remove('border-red-500');

            const minutesWorked = endMinutes - startMinutes;
            const hoursWorked = minutesWorked / 60;
            const dailySalary = hourlyRate * hoursWorked;

            // Format as Indonesian Rupiah (no decimals, dot as thousand separator)
            const formattedSalary = Math.round(dailySalary).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            salaryInput.value = 'Rp ' + formattedSalary;
        }

        // Auto-populate rows when month/year is selected
        function autoPopulateRows() {
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;

            if (!month || !year) {
                return;
            }

            // Clear existing rows
            const container = document.getElementById('work-entries-container');
            container.innerHTML = '';

            // Get number of days in the selected month
            const daysInMonth = new Date(year, month, 0).getDate();

            // Create a row for each day
            for (let day = 1; day <= daysInMonth; day++) {
                const dateString = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                addRow(dateString);
            }
        }

        // Attach event listeners to a row
        function attachRowEventListeners(row) {
            const startTimeInput = row.querySelector('.work-entry-start-time');
            const endTimeInput = row.querySelector('.work-entry-end-time');
            const removeBtn = row.querySelector('.remove-row-btn');

            // Initialize Flatpickr for end time first
            const endTimePicker = flatpickr(endTimeInput, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minuteIncrement: 10,
                onChange: function() {
                    calculateDailySalary(row);
                }
            });

            // Initialize Flatpickr for start time
            const startTimePicker = flatpickr(startTimeInput, {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minuteIncrement: 10,
                onChange: function(selectedDates, dateStr) {
                    calculateDailySalary(row);
                    // Update end time min time
                    if (dateStr) {
                        endTimePicker.set('minTime', dateStr);
                    } else {
                        endTimePicker.set('minTime', null);
                    }
                }
            });

            removeBtn.addEventListener('click', () => removeRow(removeBtn));
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Add initial row
            addRow();

            // Event listeners
            document.getElementById('add-row-btn').addEventListener('click', () => addRow());
            document.getElementById('hourly_rate').addEventListener('input', function() {
                document.querySelectorAll('.work-entry-row').forEach(row => calculateDailySalary(row));
            });
            document.getElementById('month').addEventListener('change', autoPopulateRows);
            document.getElementById('year').addEventListener('change', autoPopulateRows);
        });
    </script>
</body>
</html>

