<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalaryCalculationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_name' => ['required', 'string', 'max:255'],
            'employee_id' => ['required', 'string', 'max:255'],
            'employee_email' => ['required', 'email', 'max:255'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer', 'min:2020', 'max:2030'],
            'hourly_rate' => ['required', 'numeric', 'min:0'],
            'work_entries' => ['required', 'array', 'min:1'],
            'work_entries.*.date' => ['nullable', 'date'],
            'work_entries.*.start_time' => ['nullable', 'date_format:H:i'],
            'work_entries.*.end_time' => ['nullable', 'date_format:H:i', 'after:work_entries.*.start_time'],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $workEntries = $this->input('work_entries', []);

            foreach ($workEntries as $index => $entry) {
                if (empty($entry['date']) || empty($entry['start_time']) || empty($entry['end_time'])) {
                    continue;
                }

                // Validate 10-minute interval for times
                $startTime = $entry['start_time'];
                $endTime = $entry['end_time'];

                if (!$this->isValid10MinuteInterval($startTime)) {
                    $validator->errors()->add(
                        "work_entries.{$index}.start_time",
                        "Start time must be in 10-minute intervals (e.g., 09:00, 09:10, 09:20)."
                    );
                }

                if (!$this->isValid10MinuteInterval($endTime)) {
                    $validator->errors()->add(
                        "work_entries.{$index}.end_time",
                        "End time must be in 10-minute intervals (e.g., 17:00, 17:10, 17:20)."
                    );
                }

                // Validate minimum 10 minutes difference
                if ($startTime && $endTime) {
                    $start = \Carbon\Carbon::parse($startTime);
                    $end = \Carbon\Carbon::parse($endTime);
                    $diffMinutes = $end->diffInMinutes($start);

                    if ($diffMinutes < 10) {
                        $validator->errors()->add(
                            "work_entries.{$index}.end_time",
                            "Work duration must be at least 10 minutes."
                        );
                    }
                }
            }
        });
    }

    /**
     * Check if time is in 10-minute intervals.
     */
    private function isValid10MinuteInterval(string $time): bool
    {
        $parts = explode(':', $time);
        if (count($parts) !== 2) {
            return false;
        }

        $minutes = (int) $parts[1];
        return $minutes % 10 === 0;
    }
}
