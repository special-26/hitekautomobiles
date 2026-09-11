<?php

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\BayController;
use App\Http\Controllers\Api\Admin\CustomerController;
use App\Http\Controllers\Api\Admin\DepartmentController;
use App\Http\Controllers\Api\Admin\EmployeeController;
use App\Http\Controllers\Api\Admin\JobCardController;
use App\Http\Controllers\Api\Admin\JobCardPartController;
use App\Http\Controllers\Api\Admin\JobCardTaskController;
use App\Http\Controllers\Api\Admin\MechanicCoordinatorTaskController;
use App\Http\Controllers\Api\Admin\MechanicTaskController;
use App\Http\Controllers\Api\Admin\PartController;
use App\Http\Controllers\Api\Admin\PermissionController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\StockMovementController;
use App\Http\Controllers\Api\Admin\VehicleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);

    Route::post('/logout', [AuthController::class, 'logout']);
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
        Route::middleware('permission:departments.view')->group(function () {
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
        Route::middleware('permission:departments.create')->group(function () {
            Route::post(
                '/departments',
                [DepartmentController::class, 'store']
            );
        });
        // Update Department
        Route::middleware('permission:departments.update')->group(function () {
            Route::put(
                '/departments/{department}',
                [DepartmentController::class, 'update']
            );
        });
        // Update Status
        Route::middleware('permission:departments.status.update')->patch(
            '/departments/{department}/status',
            [DepartmentController::class, 'updateStatus']
        );

        /*
    |--------------------------------------------------------------------------
    | Bays
    |--------------------------------------------------------------------------
    */
        Route::prefix('bays')->group(function () {
            Route::get(
                '/',
                [BayController::class, 'index']
            )->middleware('permission:bays.view');

            Route::post(
                '/',
                [BayController::class, 'store']
            )->middleware('permission:bays.create');

            Route::get(
                '/{bay}',
                [BayController::class, 'show']
            )->middleware('permission:bays.view');

            Route::put(
                '/{bay}',
                [BayController::class, 'update']
            )->middleware('permission:bays.update');

            Route::patch(
                '/{bay}/status',
                [BayController::class, 'updateStatus']
            )->middleware('permission:bays.status.update');
        });

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

        /*
    ----------------------------------------------------------------------
    | JobCard Routes - for admin, advisor, manager
    |----------------------------------------------------------------------
    */
        Route::get(
            '/job-cards',
            [JobCardController::class, 'index']
        )->middleware('permission:job-cards.view');
        Route::post(
            '/job-cards',
            [JobCardController::class, 'store']
        )->middleware('permission:job-cards.create');
        Route::get(
            '/job-cards/{jobCard}',
            [JobCardController::class, 'show']
        )->middleware('permission:job-cards.view');
        Route::put(
            '/job-cards/{jobCard}',
            [JobCardController::class, 'update']
        )->middleware('permission:job-cards.update');
        Route::patch(
            '/job-cards/{jobCard}/status',
            [JobCardController::class, 'updateStatus']
        )->middleware('permission:job-cards.status.update');
        Route::patch(
            '/job-cards/{jobCard}/workflow-status',
            [JobCardController::class, 'updateWorkflowStatus']
        )->middleware('permission:job-cards.status.update');

        // Job Card Task Routes
        Route::prefix('job-cards/{jobCard}/tasks')->group(function () {
            Route::get(
                '/',
                [JobCardTaskController::class, 'index']
            )->middleware('permission:job-cards-tasks.view');

            Route::post(
                '/',
                [JobCardTaskController::class, 'store']
            )->middleware('permission:job-cards-tasks.create');

            Route::get(
                '/{task}',
                [JobCardTaskController::class, 'show']
            )->middleware('permission:job-cards-tasks.view');

            Route::put(
                '/{task}',
                [JobCardTaskController::class, 'update']
            )->middleware('permission:job-cards-tasks.update');

            Route::patch(
                '/{task}/status',
                [JobCardTaskController::class, 'updateStatus']
            )->middleware('permission:job-cards-tasks.status.update');
        });
        /*
    |--------------------------------------------------------------------------
    | Permission Management
    |--------------------------------------------------------------------------
    */
        Route::get(
            '/permissions',
            [PermissionController::class, 'index']
        )->middleware('permission:roles.view');


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
        Route::post(
            '/roles',
            [RoleController::class, 'store']
        )->middleware('permission:roles.create');

        Route::put(
            '/roles/{role}',
            [RoleController::class, 'update']
        )->middleware('permission:roles.update');

        /*
    |--------------------------------------------------------------------------
    | Role Management
    |--------------------------------------------------------------------------
    */
        Route::prefix('mechanic/tasks')
            ->group(function () {
                Route::get('/', [MechanicTaskController::class, 'index']);
                Route::get('/{task}', [MechanicTaskController::class, 'show']);
                Route::patch('/{task}/status', [
                    MechanicTaskController::class,
                    'updateStatus'
                ]);
            });

        /*
    |--------------------------------------------------------------------------
    | Mechanic Cordinator Task Management
    |--------------------------------------------------------------------------
    */
        Route::prefix('coordinator/tasks')
            ->middleware(['permission:job-cards-tasks.view'])
            ->group(function () {
                Route::get('/', [
                    MechanicCoordinatorTaskController::class,
                    'index',
                ]);
                Route::get('/summary', [
                    MechanicCoordinatorTaskController::class,
                    'summary',
                ]);

                Route::get('/{task}', [
                    MechanicCoordinatorTaskController::class,
                    'show',
                ]);

                Route::patch('/{task}/status', [
                    MechanicCoordinatorTaskController::class,
                    'updateStatus',
                ])->middleware('permission:job-cards-tasks.status.update');

                Route::patch('/{task}/assignment', [
                    MechanicCoordinatorTaskController::class,
                    'updateAssignment',
                ])->middleware('permission:job-cards-tasks.update');
            });

        /*
    |--------------------------------------------------------------------------
    | Car Parts Management
    |--------------------------------------------------------------------------
    */
        Route::prefix('/parts')
            ->group(function () {
                Route::get('/', [PartController::class, 'index']);
                Route::post('/', [PartController::class, 'store']);
                Route::get('/{part}', [PartController::class, 'show']);
                Route::put('/{part}', [PartController::class, 'update']);
                Route::delete('/{part}', [PartController::class, 'destroy']);
            });

        Route::prefix('/stock-movements')
            ->group(function () {
                Route::get('/', [StockMovementController::class, 'index']);
                Route::post('/', [StockMovementController::class, 'store']);
                Route::get('/{stockMovement}', [StockMovementController::class, 'show']);
            });

        Route::prefix('/job-cards/{jobCard}/parts')
            ->group(function () {
                Route::get('/', [JobCardPartController::class, 'index']);
                Route::post('/', [JobCardPartController::class, 'store']);
                Route::get('/{jobCardPart}', [JobCardPartController::class, 'show']);
                Route::put('/{jobCardPart}', [JobCardPartController::class, 'update']);
                Route::delete('/{jobCardPart}', [JobCardPartController::class, 'destroy']);
                Route::patch('/{jobCardPart}/issue', [JobCardPartController::class, 'issue']);
                Route::patch('/{jobCardPart}/return', [JobCardPartController::class, 'returnPart']);
            });
    });



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
