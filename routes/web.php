<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\FranceTravail;
use App\Livewire\Agents;
use App\Livewire\Indeed;
use App\Livewire\LinkFT;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('utilisateurs', 'utilisateurs')
    ->middleware(['auth', 'verified'])
    ->name('utilisateurs');
// Scrapping routes debut
Route::view('agents', 'agents')
    ->middleware(['auth', 'verified'])
    ->name('agents');
Route::get('/francetravail', FranceTravail::class)->name('francetravail');
Route::get('/indeed', Indeed::class)->name('indeed');

// DEBUT CARTES France Travail

// STEP 1 - Liens France Travail
Route::view('liens-francetravail', 'liens-francetravail')
    ->middleware(['auth', 'verified'])
    ->name('liens-francetravail');
// STEP 2 - Offres France Travail
Route::view('offres-francetravail', 'offres-francetravail')
    ->middleware(['auth', 'verified'])
    ->name('offres-francetravail');
// STEP 3 - Infos France Travail
Route::view('infos-ft', 'infos-ft')
    ->middleware(['auth', 'verified'])
    ->name('infos-ft');
// STEP 4 - Contacts France Travail
Route::view('contacts-ft', 'contacts-francetravail')
    ->middleware(['auth', 'verified'])
    ->name('contacts-ft');
// STEP 5 - Numéros France Travail
Route::view('numeros-francetravail', 'numeros-francetravail')
    ->middleware(['auth', 'verified'])
    ->name('numeros-francetravail');
// STEP 6 - Saint Graal Travail
Route::view('saintgraal', 'saintgraal-francetravail')
    ->middleware(['auth', 'verified'])
    ->name('saintgraal-francetravail');
// FIN CARTES France Travail

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    // Routes for scrapping management
    // Volt::route('n8n/liste', 'n8n.liste')->name('liste');
    // Route::prefix('n8n')->group(function () {
    //     Route::redirect('N8N', 'n8n/liste');
    //     Volt::route('n8n/liste', 'n8n.liste')->name('n8n.liste');
    // });

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
