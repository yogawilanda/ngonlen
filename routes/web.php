<?php

use App\Http\Middleware\EnsureTeamMembership;
use App\Livewire\Studio\Studio;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::prefix('{current_team}')
    ->middleware(['auth', EnsureTeamMembership::class])
    ->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');

        Route::get('studio', Studio::class)
            ->name('studio');

        Route::get('builder', Studio::class)
            ->name('builder');
    });

require __DIR__.'/settings.php';
