<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use \App\Http\Controllers\LogsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('verifyToken')->group(function(){
    Route::post('/me', function (Request $request) {
        return $request->dbUser;
    });

    Route::get('{date}/logs', [LogsController::class, 'index']);

    Route::prefix('employees')->group(function(){
        Route::get('search', [EmployeesController::class, 'searchEmployees']);
        Route::get('export', [EmployeesController::class, 'exportEmployees']);
        Route::post('import', [EmployeesController::class, 'importEmployees']);
        Route::prefix('{id}')->group(function(){
            Route::get('/', [EmployeesController::class, 'single']);
            Route::get('/managers', [EmployeesController::class, 'employeeManagers']);
            Route::get('/managers-salary', [EmployeesController::class, 'employeeManagersWithSalaries']);
        });
    });
});
