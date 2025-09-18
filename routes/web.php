<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\MassIntentionsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SearchController;
use App\Models\ContactUs;
use App\Models\MassIntentions;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
    ]);
});

Route::get('/page/{slug}', [PageController::class, 'index'])->name('view.page');
Route::get('/contact-us', [ContactUsController::class, 'create'])->name('get.contact_request');
Route::post('/contact_us', [ContactUsController::class, 'store'])->name('store.contact_request');
Route::post('/mass_intentions', [MassIntentionsController::class, 'store'])->name('store.mass_intention_request');
Route::get('/readings/daily-readings', [ProjectController::class, 'dailyReadings']);
Route::get('/news/news-from-vatican', [ProjectController::class, 'newsFromVatican']);
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/admin/dashboard', function () {
    return Inertia::render('Dashboard', [
        'massIntentions' => MassIntentions::count(),
        'contactMessages' => ContactUs::count(),
        'recentContacts' => ContactUs::latest()->paginate(5),
        'recentIntentions' => MassIntentions::latest()->paginate(5),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::patch('/update_intention/status', [MassIntentionsController::class, 'update'])->name('intention.update');
    Route::delete('/delete_intention/{id}', [MassIntentionsController::class, 'destroy'])->name('intention.delete');
    Route::delete('/delete_contact_message/{id}', [ContactUsController::class, 'destroy'])->name('contact_message.delete');

    Route::get('/admin/mass_intentions', [MassIntentionsController::class, 'index'])->name('contact_message.view');
    Route::get('/admin/contact_messages', [ContactUsController::class, 'index'])->name('contact_message.view');
    Route::get('/admin/pages', [PageController::class, 'adminView'])->name('admin_view.pages');
    Route::get('/admin/create_page', [PageController::class, 'create'])->name('admin_create.pages');
    Route::get('/admin/edit_page/{slug}', [PageController::class, 'edit'])->name('admin_get_edit.pages');
    Route::post('/admin/store_page', [PageController::class, 'store'])->name('admin_store.pages');
    Route::patch('/admin/edit_page/{page}', [PageController::class, 'update'])->name('admin_edit_update.pages');
    Route::patch('/admin/update_status/{slug}', [PageController::class, 'updatePageStatus'])->name('admin_update_status.pages');

    Route::get('/admin/edit_home', [PageController::class, 'home'])->name('admin_edit_home');
    Route::post('/hero/slider/edit', [PageController::class, 'updateHomeSlider'])->name('updateHomeSlider');
    Route::get('/hero/slider', [PageController::class, 'getHeroSlides'])->name('getHeroSlider');

    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/project/store', [ProjectController::class, 'store']);
    Route::delete('/project/{card}', [ProjectController::class, 'destroy']);


    Route::get('/admin/users', [AdminController::class, 'allUsers']);
    Route::delete('/admin/delete/{id}', [AdminController::class, 'destroy']);
    Route::patch('/admin/update/{user}', [AdminController::class, 'updateUser']);
});

require __DIR__ . '/auth.php';
