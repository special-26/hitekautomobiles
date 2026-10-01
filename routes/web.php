<?php

use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\JobCards\Billing;
use App\Livewire\JobCards\Create as NewJobCard;
use App\Livewire\JobCards\CustomerVehicle;
use App\Livewire\JobCards\History;
use App\Livewire\JobCards\Images;
use App\Livewire\JobCards\Index as JobCardIndex;
use App\Livewire\JobCards\Insurance;
use App\Livewire\JobCards\Parts;
use App\Livewire\JobCards\Payments;
use App\Livewire\JobCards\Show as JobCardShow;
use App\Livewire\JobCards\Tasks;
use App\Livewire\ServiceSlotBooking;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/team', function () {
    return view('team');
})->name('team');
Route::get('/team/nagender-sharma', function () {
    return view('nagender');
})->name('nagender');
Route::get('/team/ankit-sandhu', function () {
    return view('teams/ankit');
})->name('ankit');
Route::get('/team/basant-joshi', function () {
    return view('teams.basant');
})->name('basant');

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
    Route::get('create', NewJobCard::class)
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
});


// Customer Business Profile
Volt::route(
    'customer/profile',
    'customer.profile'
)
    ->middleware(['auth', 'verified'])
    ->name('customer.profile');
// Customer - Manage Vehicle
Volt::route(
    'customer/vehicles',
    'customer.vehicles'
)
    ->middleware(['auth', 'verified'])
    ->name('customer.vehicles');
// Book Service
Volt::route('customer/book-service', 'customer.book-service')
    ->middleware(['auth', 'verified'])
    ->name('customer.book-service');
// My Bookings
Volt::route('customer/bookings', 'customer.bookings')
    ->middleware(['auth', 'verified'])
    ->name('customer.bookings');

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


Route::get('/book-service', ServiceSlotBooking::class);
