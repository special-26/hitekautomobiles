<?php

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\BayController;
use App\Http\Controllers\Api\Admin\CustomerController;
use App\Http\Controllers\Api\Admin\DepartmentController;
use App\Http\Controllers\Api\Admin\EmployeeController;
use App\Http\Controllers\Api\Admin\JobCardController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\VehicleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });
});

/*
|--------------------------------------------------------------------------
| Super Admin - Admin Accounts
|--------------------------------------------------------------------------
*/
Route::middleware('permission:owner.admins.manage')->group(function () {

    Route::get(
        '/owner/admins',
        [AdminController::class, 'index']
    );

    Route::post(
        '/owner/admins',
        [AdminController::class, 'store']
    );

    Route::put(
        '/owner/admins/{user}',
        [AdminController::class, 'update']
    );

    Route::patch(
        '/owner/admins/{user}/status',
        [AdminController::class, 'updateStatus']
    );
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes - For Admin
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')
    ->prefix('admin')
    ->group(function () {

        /*
    |--------------------------------------------------------------------------
    | Employee Management
    |--------------------------------------------------------------------------
    */
        Route::middleware('permission:employees.view')->group(function () {
            Route::get(
                '/employees',
                [EmployeeController::class, 'index']
            );
            Route::get(
                '/employees/{employee}',
                [EmployeeController::class, 'show']
            );
        });
        // Create
        Route::middleware('permission:employees.create')->group(function () {
            Route::post(
                '/employees',
                [EmployeeController::class, 'store']
            );
        });
        // Update Employee
        Route::middleware('permission:employees.update')->group(function () {
            Route::put(
                '/employees/{employee}',
                [EmployeeController::class, 'update']
            );
        });
        // Update Status
        Route::middleware('permission:employees.status.update')->group(function () {
            Route::patch(
                '/employees/{employee}/status',
                [EmployeeController::class, 'updateStatus']
            );
        });

        /*
    |--------------------------------------------------------------------------
    | Department Management
    |--------------------------------------------------------------------------
    */
        Route::middleware('permission:employees.view')->group(function () {
            Route::get(
                '/departments',
                [DepartmentController::class, 'index']
            );
            Route::get(
                '/departments/{department}',
                [DepartmentController::class, 'show']
            );
        });
        // Create
        Route::middleware('permission:employees.create')->group(function () {
            Route::post(
                '/departments',
                [DepartmentController::class, 'store']
            );
        });
        // Update Department
        Route::middleware('permission:employees.update')->group(function () {
            Route::put(
                '/departments/{department}',
                [DepartmentController::class, 'update']
            );
        });
        // Update Status
        Route::middleware('permission:employees.update')->patch(
            '/departments/{department}/status',
            [DepartmentController::class, 'updateStatus']
        );

        /*
    |--------------------------------------------------------------------------
    | Role Management
    |--------------------------------------------------------------------------
    */
        Route::middleware('permission:roles.view')->group(function () {
            Route::get(
                '/roles',
                [RoleController::class, 'index']
            );

            Route::get(
                '/roles/{role}',
                [RoleController::class, 'show']
            );
        });

        /*
    |--------------------------------------------------------------------------
    | Bays
    |--------------------------------------------------------------------------
    */
        Route::get(
            '/bays',
            [BayController::class, 'index']
        )->middleware('permission:bays.view');

        Route::post(
            '/bays',
            [BayController::class, 'store']
        )->middleware('permission:bays.create');

        Route::get(
            '/bays/{bay}',
            [BayController::class, 'show']
        )->middleware('permission:bays.view');

        Route::put(
            '/bays/{bay}',
            [BayController::class, 'update']
        )->middleware('permission:bays.update');

        Route::patch(
            '/bays/{bay}/status',
            [BayController::class, 'updateStatus']
        )->middleware('permission:bays.status.update');

        /*
    |--------------------------------------------------------------------------
    | Customers API Through Admin
    |--------------------------------------------------------------------------
    */
        Route::get(
            '/customers',
            [CustomerController::class, 'index']
        )->middleware('permission:customers.view');

        Route::post(
            '/customers',
            [CustomerController::class, 'store']
        )->middleware('permission:customers.create');

        Route::get(
            '/customers/{customer}',
            [CustomerController::class, 'show']
        )->middleware('permission:customers.view');

        Route::put(
            '/customers/{customer}',
            [CustomerController::class, 'update']
        )->middleware('permission:customers.update');

        Route::patch(
            '/customers/{customer}/status',
            [CustomerController::class, 'updateStatus']
        )->middleware('permission:customers.status.update');

        /*
    |--------------------------------------------------------------------------
    | Vehicles
    |--------------------------------------------------------------------------
    */
        Route::get(
            '/vehicles',
            [VehicleController::class, 'index']
        )->middleware('permission:vehicles.view');

        Route::post(
            '/vehicles',
            [VehicleController::class, 'store']
        )->middleware('permission:vehicles.create');

        Route::get(
            '/vehicles/{vehicle}',
            [VehicleController::class, 'show']
        )->middleware('permission:vehicles.view');

        Route::put(
            '/vehicles/{vehicle}',
            [VehicleController::class, 'update']
        )->middleware('permission:vehicles.update');

        Route::patch(
            '/vehicles/{vehicle}/status',
            [VehicleController::class, 'updateStatus']
        )->middleware('permission:vehicles.status.update');
    });

/*
|--------------------------------------------------------------------------
| JobCard Routes - for admin, advisor, manager
|--------------------------------------------------------------------------
*/
Route::get('/job-cards', [JobCardController::class, 'index']);
Route::post('/job-cards', [JobCardController::class, 'store']);
Route::get('/job-cards/{jobCard}', [JobCardController::class, 'show']);
Route::put('/job-cards/{jobCard}', [JobCardController::class, 'update']);
Route::patch('/job-cards/{jobCard}/status', [JobCardController::class, 'updateStatus']);


/*
|--------------------------------------------------------------------------
| Customer Portal
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->group(function () {
    Route::post(
        '/register',
        [CustomerAuthController::class, 'register']
    );
    Route::post(
        '/login',
        [CustomerAuthController::class, 'login']
    );
    Route::middleware('auth:sanctum')->group(function () {
        Route::get(
            '/me',
            [CustomerAuthController::class, 'me']
        );
        Route::post(
            '/logout',
            [CustomerAuthController::class, 'logout']
        );
    });
});
