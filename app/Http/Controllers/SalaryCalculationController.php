<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryCalculationRequest;
use App\Models\Employee;
use App\Models\WorkEntry;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SalaryCalculationController extends Controller
{
    /**
     * Display a listing of salary calculations.
     */
    public function index(): View
    {
        $workEntries = WorkEntry::with('employee')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy(function ($entry) {
                return $entry->employee->id . '-' . $entry->year . '-' . $entry->month;
            });

        return view('salary-calculation.index', compact('workEntries'));
    }

    /**
     * Show the form for creating a new salary calculation.
     */
    public function create(): View
    {
        return view('salary-calculation.create');
    }

    /**
     * Store a newly created salary calculation.
     */
    public function store(SalaryCalculationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Find or create employee
        $employee = Employee::firstOrCreate(
            ['employee_id' => $validated['employee_id']],
            [
                'name' => $validated['employee_name'],
                'email' => $validated['employee_email'],
            ]
        );

        // Update employee if name or email changed
        if ($employee->name !== $validated['employee_name'] || $employee->email !== $validated['employee_email']) {
            $employee->update([
                'name' => $validated['employee_name'],
                'email' => $validated['employee_email'],
            ]);
        }

        // Save work entries
        foreach ($validated['work_entries'] as $entry) {
            if (empty($entry['date']) || empty($entry['start_time']) || empty($entry['end_time'])) {
                continue; // Skip empty entries
            }

            $date = Carbon::parse($entry['date']);
            // Parse time as HH:MM format
            $startTimeParts = explode(':', $entry['start_time']);
            $endTimeParts = explode(':', $entry['end_time']);
            
            $startTime = Carbon::createFromTime(
                (int) $startTimeParts[0],
                (int) $startTimeParts[1],
                0
            );
            $endTime = Carbon::createFromTime(
                (int) $endTimeParts[0],
                (int) $endTimeParts[1],
                0
            );

            // Calculate hours worked
            $hoursWorked = $endTime->diffInMinutes($startTime) / 60;
            $dailySalary = $validated['hourly_rate'] * $hoursWorked;

            WorkEntry::create([
                'employee_id' => $employee->id,
                'date' => $date,
                'start_time' => $entry['start_time'] . ':00',
                'end_time' => $entry['end_time'] . ':00',
                'hourly_rate' => $validated['hourly_rate'],
                'daily_salary' => $dailySalary,
                'month' => $validated['month'],
                'year' => $validated['year'],
            ]);
        }

        return redirect()->route('salary-calculation.index')
            ->with('success', 'Salary calculation saved successfully.');
    }
}
