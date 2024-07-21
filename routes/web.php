<?php

use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    // Admin routes
    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        });

        Route::resource('categories', CategoryController::class);
        Route::resource('jobs', JobController::class);
        Route::resource('applications', JobApplicationController::class);
        Route::get('users', [ProfileController::class, 'index'])->name('admin.users.index');
        Route::patch('jobs/{job}/status', [JobController::class, 'updateStatus'])->name('jobs.updateStatus');
    });

    // Seeker routes
    Route::group(['prefix' => 'seeker', 'middleware' => ['role:seeker']], function () {
        Route::get('/', function () {
            return view('seeker.dashboard');
        });
        Route::get('jobs', [JobController::class, 'publicIndex'])->name('seeker.jobs.index');
        Route::get('jobs/{job}', [JobController::class, 'publicShow'])->name('seeker.jobs.show');
        Route::post('jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('seeker.jobs.apply');
        Route::post('jobs/{job}/save', [JobController::class, 'save'])->name('seeker.jobs.save');
        Route::post('jobs/{job}/unsave', [JobController::class, 'unsave'])->name('seeker.jobs.unsave');
        Route::get('applications', [JobApplicationController::class, 'index'])->name('seeker.applications.index');
    });

    // Employer routes
    Route::group(['prefix' => 'employer', 'middleware' => ['role:employer']], function () {
        Route::get('/', function () {
            return view('employer.dashboard');
        });
        Route::resource('jobs', JobController::class);
        Route::get('applications', [JobApplicationController::class, 'index'])->name('employer.applications.index');
        Route::get('applications/{application}', [JobApplicationController::class, 'show'])->name('employer.applications.show');
        Route::patch('applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('employer.applications.updateStatus');
        Route::patch('jobs/{job}/status', [JobController::class, 'updateStatus'])->name('jobs.updateStatus');
    });

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/chat', function () {
        return view('chatbot.index');
    });

    Route::post('/chat', [App\Http\Controllers\ChatbotController::class, 'chat'])->name('chat');

});

// Auth routes
Auth::routes();

// Public routes
Route::get('/', function () {
    return redirect()->route('public.jobs.index');
})->name('main');

Route::get('/home', function () {
    return redirect()->route('public.jobs.index');
})->name('home');

Route::get('/jobs', [JobController::class, 'publicIndex'])->name('public.jobs.index');
Route::post('/jobs', [JobController::class, 'publicSearch'])->name('public.jobs.search');
Route::get('/jobs/{job}', [JobController::class, 'publicShow'])->name('public.jobs.show');

