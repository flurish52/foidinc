<?php

use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\MassIntentionsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteLinkController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/page/{slug}', [PageController::class, 'index'])->name('view.page');
Route::get('/get_links', [RouteLinkController::class, 'index'])->name('get.links');
Route::get('/contact_us', [ContactUsController::class, 'create'])->name('get.contact_request');
Route::post('/contact_us', [ContactUsController::class, 'store'])->name('store.contact_request');
Route::post('/mass_intentions', [MassIntentionsController::class, 'store'])->name('store.mass_intention_request');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
