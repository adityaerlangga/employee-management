<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'name',
        'email',
    ];

    /**
     * Get the work entries for the employee.
     */
    public function workEntries(): HasMany
    {
        return $this->hasMany(WorkEntry::class);
    }
}
