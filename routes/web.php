<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;

Route::get('/', fn() => redirect()->route('invitations.index'));

Route::prefix('invitations')->name('invitations.')->group(function () {
    Route::get('/', [InvitationController::class, 'index'])->name('index');
    Route::get('/create', [InvitationController::class, 'create'])->name('create');
    Route::post('/', [InvitationController::class, 'store'])->name('store');
    Route::get('/{invitation}', [InvitationController::class, 'show'])->name('show');

    Route::get('/{invitation}/print/{recipient}', [InvitationController::class, 'print'])->name('print');
});
