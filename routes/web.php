<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\ProjectController as GuestProjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Education;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Portfolio Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/education', function () {
    return Inertia::render('Guest/Education', [
        'education' => Education::orderBy('start_date', 'desc')->get()
    ]);
})->name('education');

Route::get('/projects', [GuestProjectController::class, 'index'])->name('guest.projects.index');
Route::get('/projects/{project}', [GuestProjectController::class, 'show'])->name('guest.projects.show');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

// Guest Contact Routes
Route::post('/contact', [App\Http\Controllers\Guest\ContactController::class, 'store'])
    ->name('guest.contact.store');

// Admin Routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->middleware('admin')
    ->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Test route for debugging
    Route::post('/test-upload', function (Request $request) {
        \Log::info('Test upload request:', [
            'all_data' => $request->all(),
            'files' => $request->allFiles(),
            'has_images' => $request->hasFile('images'),
        ]);
        
        return response()->json([
            'success' => true,
            'data' => $request->all(),
            'files' => $request->allFiles()
        ]);
    })->name('test-upload');

    // Skills Management
    Route::resource('skills', SkillController::class);
    Route::patch('skills/{skill}/visibility', [SkillController::class, 'toggleVisibility'])
        ->name('skills.toggle-visibility');

    // Education Management
    Route::resource('education', EducationController::class);
    Route::patch('education/{education}/visibility', [EducationController::class, 'toggleVisibility'])
        ->name('education.toggle-visibility');

    // Projects Management
    Route::resource('projects', ProjectController::class);
    Route::patch('projects/{project}/visibility', [ProjectController::class, 'toggleVisibility'])
        ->name('projects.toggle-visibility');
    Route::post('projects/{project}/images', [ProjectController::class, 'uploadImage'])
        ->name('projects.images.upload');
    Route::delete('projects/{project}/images/{image}', [ProjectController::class, 'deleteImage'])
        ->name('projects.images.delete');
    Route::patch('projects/{project}/main-image/{image}', [ProjectController::class, 'setMainImage'])
        ->name('projects.images.main');

    // Messages Management
    Route::get('/messages', [App\Http\Controllers\Admin\MessageController::class, 'index'])
        ->name('messages.index');
    Route::get('/messages/{message}', [App\Http\Controllers\Admin\MessageController::class, 'show'])
        ->name('messages.show');
    Route::delete('/messages/{message}', [App\Http\Controllers\Admin\MessageController::class, 'destroy'])
        ->name('messages.destroy');
    Route::put('/messages/{message}/toggle-read', [App\Http\Controllers\Admin\MessageController::class, 'toggleRead'])
        ->name('messages.toggleRead');
});

require __DIR__.'/auth.php';
