<?php

use App\Http\Controllers\SalaryCalculationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-tailwind', function () {
    return view('test-tailwind');
});

Route::get('/salary-calculation', [SalaryCalculationController::class, 'index'])->name('salary-calculation.index');
Route::get('/salary-calculation/create', [SalaryCalculationController::class, 'create'])->name('salary-calculation.create');
Route::post('/salary-calculation', [SalaryCalculationController::class, 'store'])->name('salary-calculation.store');
