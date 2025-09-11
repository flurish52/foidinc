<?php

use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\MassIntentionsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteLinkController;
use App\Models\ContactUs;
use App\Models\MassIntentions;
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


Route::get('/admin/dashboard', function () {
    return Inertia::render('Dashboard', [
        'massIntentions' => MassIntentions::count(),
        'contactMessages' => ContactUs::count(),
        'recentContacts' => ContactUs::latest()->paginate(5),
        'recentIntentions' => MassIntentions::latest()->paginate(5),

//        'donationsTotal' => \App\Models\Donations::sum('amount'),
//        'donationAmounts' => \App\Models\Donations::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::patch('/update_intention/status', [MassIntentionsController::class, 'update'])->name('intention.update');
    Route::delete('/delete_intention/{id}', [MassIntentionsController::class, 'destroy'])->name('intention.delete');
    Route::delete('/delete_contact_message/{id}', [ContactUsController::class, 'destroy'])->name('contact_message.delete');

    Route::get('admin/mass_intentions', [MassIntentionsController::class, 'index'])->name('contact_message.view');
    Route::get('admin/contact_messages', [ContactUsController::class, 'index'])->name('contact_message.view');
    Route::get('admin/pages', [PageController::class, 'adminView'])->name('admin_view.pages');
    Route::get('admin/route_links', [RouteLinkController::class, 'index'])->name('admin_view.pages');
    Route::get('admin/create_page', [PageController::class, 'create'])->name('admin_create.pages');
    Route::get('admin/edit_page/{page}', [PageController::class, 'edit'])->name('admin_get_edit.pages');
    Route::post('admin/store_page', [PageController::class, 'store'])->name('admin_store.pages');
    Route::patch('admin/edit_page/{page}', [PageController::class, 'update'])->name('admin_edit.pages');

});

require __DIR__ . '/auth.php';
