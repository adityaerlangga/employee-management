<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('date')->comment('Work date (YYYY-MM-DD)');
            $table->time('start_time')->comment('Start time in 24-hour format (HH:MM)');
            $table->time('end_time')->comment('End time in 24-hour format (HH:MM)');
            $table->decimal('hourly_rate', 10, 2)->comment('Hourly rate at time of entry');
            $table->decimal('daily_salary', 10, 2)->comment('Calculated daily salary');
            $table->tinyInteger('month')->comment('Month (1-12) for quick filtering');
            $table->year('year')->comment('Year (2020-2030) for quick filtering');
            $table->timestamps();
            
            $table->index(['employee_id', 'month', 'year']);
            $table->index(['date']);
            $table->index(['month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_entries');
    }
};
