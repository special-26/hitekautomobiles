<?php

use App\Http\Controllers\EmployeeDocumentController;
use App\Livewire\Attendance\Index as AttendanceIndex;
use App\Livewire\Attendance\MonthlySummary;
use App\Livewire\Bays\Index as BaysIndex;
use App\Livewire\CompanyHolidays\Index as CompanyHolidaysIndex;
use App\Livewire\Customers\Edit as CustomerEdit;
use App\Livewire\Customers\Index as CustomerIndex;
use App\Livewire\Customers\Show as CustomerShow;
use App\Livewire\Customers\Vehicles\Create as VehicleCreate;
use App\Livewire\Customers\Vehicles\Edit as VehicleEdit;
use App\Livewire\Customers\Vehicles\Show as VehicleShow;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Employees\Create as EmployeesCreate;
use App\Livewire\Employees\Edit as EmployeesEdit;
use App\Livewire\Employees\Index as EmployeesIndex;
use App\Livewire\Employees\Show as EmployeesShow;
use App\Livewire\JobCards\Billing;
use App\Livewire\JobCards\Create as NewJobCard;
use App\Livewire\JobCards\CustomerVehicle;
use App\Livewire\JobCards\History;
use App\Livewire\JobCards\Images;
use App\Livewire\JobCards\Index as JobCardIndex;
use App\Livewire\JobCards\Insurance;
use App\Livewire\JobCards\Invoice;
use App\Livewire\JobCards\Parts;
use App\Livewire\JobCards\Payments;
use App\Livewire\JobCards\Show as JobCardShow;
use App\Livewire\JobCards\Tasks;
use App\Livewire\LeaveManagement\Index as LeaveManagementIndex;
use App\Livewire\MarketingStudio\BrandProfile;
use App\Livewire\MarketingStudio\CanvasEditor;
use App\Livewire\MarketingStudio\CreativeEditor;
use App\Livewire\MarketingStudio\Index as MarketingStudioIndex;
use App\Livewire\Payroll\Index as PayrollIndex;
use App\Livewire\Payroll\Payments as PayrollPayments;
use App\Livewire\Payroll\Settings as PayrollSettings;
use App\Livewire\PublicServiceBooking;
use App\Livewire\ServiceSlotBooking;
use App\Livewire\ServiceTasks\Index as ServiceTasksIndex;
use App\Livewire\Shifts\Index as ShiftsIndex;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/team', function () {
    return view('team');
})->name('team');


// Claim Docs
Route::get('/doca/bodyshop-cliam-docs', function () {
    return view('bodyshop-claim-docs');
})->name('bodyshop-claim-docs');

// Dashboard
Route::get('/dashboard', DashboardIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Job-Card
Route::prefix('job-cards')->middleware(['auth'])->group(function () {
    Route::get('create/{customer?}/{vehicle?}', NewJobCard::class)
        ->name('job-cards.create');
    Route::get('/', JobCardIndex::class)
        ->name('job-cards.index');
    Route::get('{jobCard}', JobCardShow::class)
        ->name('job-cards.show');
    Route::get('{jobCard}/customer-vehicle', CustomerVehicle::class)
        ->name('job-cards.customer-vehicle');
    Route::get('{jobCard}/tasks', Tasks::class)
        ->name('job-cards.tasks');
    Route::get('{jobCard}/parts', Parts::class)
        ->name('job-cards.parts');
    Route::get('{jobCard}/images', Images::class)
        ->name('job-cards.images');
    Route::get('{jobCard}/insurance', Insurance::class)
        ->name('job-cards.insurance');
    Route::get('{jobCard}/billing', Billing::class)
        ->name('job-cards.billing');
    Route::get('{jobCard}/payments', Payments::class)
        ->name('job-cards.payments');
    Route::get('{jobCard}/history', History::class)
        ->name('job-cards.history');
    Route::get('{jobCard}/invoice/{invoice}', Invoice::class)
        ->name('job-cards.invoice');
});

// All Customers List
Route::prefix('customers')->middleware(['auth'])->group(function () {
    Route::get('/', CustomerIndex::class)
        ->name('customers.index');
    Route::get('{customer}', CustomerShow::class)
        ->name('customers.show');
    Route::get('{customer}/edit', CustomerEdit::class)
        ->name('customers.edit');
    // Customer's Vehicles
    Route::get('{customer}/vehicles/create', VehicleCreate::class)
        ->name('customers.vehicles.create');
});
// All Vehicles
Route::prefix('vehicles')->middleware(['auth'])->group(function () {
    Route::get('{vehicle}', VehicleShow::class)
        ->name('vehicles.show');
    Route::get('/vehicles/{vehicle}/edit', VehicleEdit::class)
        ->name('vehicles.edit');
});

// Service Task Routes
Route::get('/service-tasks', ServiceTasksIndex::class)
    ->middleware(['auth'])
    ->name('service-tasks.index');

// Bay Management
Route::get('/bays', BaysIndex::class)
    ->middleware(['auth'])
    ->name('bays.index');

Route::middleware(['auth', 'can:company-holidays.view'])
    ->group(function () {
        Route::get('/company-holidays', CompanyHolidaysIndex::class)
            ->name('company-holidays.index');
    });

// Employees
Route::prefix('employees')->middleware(['auth'])->group(function () {
    Route::get('/', EmployeesIndex::class)
        ->middleware('can:employees.create')
        ->name('employees.index');
    Route::get('create', EmployeesCreate::class)
        ->middleware('can:employees.create')
        ->name('employees.create');
    Route::get('{employee}', EmployeesShow::class)
        ->middleware(['auth', 'can:employees.view'])
        ->name('employees.show');
    Route::get('{employee}/edit', EmployeesEdit::class)
        ->middleware(['auth', 'can:employees.update'])
        ->name('employees.edit');
});
Route::get('/employee-documents/{document}/download', [
    EmployeeDocumentController::class,
    'download',
])->middleware(['auth'])->name('employee-documents.download');
Route::get('/leave-management', LeaveManagementIndex::class)
    ->middleware(['auth', 'can:leave-requests.view'])
    ->name('leave-management.index');

Route::get('/attendance', AttendanceIndex::class)
    ->middleware(['auth', 'can:attendance.view'])
    ->name('attendance.index');
Route::get('/attendance/monthly-summary', MonthlySummary::class)
    ->middleware(['auth', 'can:attendance.view'])
    ->name('attendance.monthly-summary');
Route::get('/shifts', ShiftsIndex::class)
    ->middleware(['auth', 'can:shifts.view'])
    ->name('shifts.index');
Route::get('/payroll/settings', PayrollSettings::class)
    ->middleware('can:payroll.settings.manage')
    ->name('payroll.settings');
Route::get('/payroll', PayrollIndex::class)
    ->middleware('can:payroll.view')
    ->name('payroll.index');
Route::get('/payroll/{payroll}/payments', PayrollPayments::class)
    ->middleware('can:payroll.payment.manage')
    ->name('payroll.payments');

// Creative Studio
Route::get('/marketing-studio', MarketingStudioIndex::class)
    ->middleware(['auth', 'can:marketing-studio.view'])
    ->name('marketing-studio.index');
Route::get('/marketing-studio/brand-profile', BrandProfile::class)
    ->middleware(['auth', 'can:marketing-studio.view'])
    ->name('marketing-studio.brand-profile');
Route::get('/marketing-studio/create', CreativeEditor::class)
    ->middleware(['auth', 'can:marketing-studio.view'])
    ->name('marketing-studio.create');

Route::get('/marketing-studio/canvas', CanvasEditor::class)
    ->middleware(['auth', 'can:marketing-studio.view'])
    ->name('marketing-studio.canvas');

// Book Service 
Route::get('/book-service', PublicServiceBooking::class)
    ->name('book-service');

// Customer Business Profile
Volt::route(
    'customer/profile',
    'customer.profile'
)
    ->middleware(['auth', 'verified'])
    ->name('customer.profile');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
