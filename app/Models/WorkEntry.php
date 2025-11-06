<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkEntry extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'date',
        'start_time',
        'end_time',
        'hourly_rate',
        'daily_salary',
        'month',
        'year',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'hourly_rate' => 'decimal:2',
            'daily_salary' => 'decimal:2',
            'month' => 'integer',
            'year' => 'integer',
        ];
    }

    /**
     * Get the employee that owns the work entry.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
