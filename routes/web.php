<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobApplicationsController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin routes
Route::group(['middleware' => ['role:Admin']], function() {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/update', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/delete/{id}', [UserController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/admin/cv/{id}', [UserController::class, 'viewCv'])->name('admin.users.cv');

    Route::get('/admin/jobs', [JobController::class, 'index'])->name('admin.jobs');
    Route::get('/admin/applicants', [JobApplicationsController::class, 'index'])->name('admin.jobs.applicants');

    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::get('/admin/category/create', [CategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/category/save', [CategoryController::class, 'store'])->name('admin.category.save');
    Route::get('/admin/category/{id}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/admin/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.delete');
});

// User routes
Route::group(['middleware' => ['role:User']], function() {
    Route::get('/user', [HomeController::class, 'index'])->name('user.index');
});

// Employer routes
Route::group(['middleware' => ['role:Employer']], function() {
    Route::get('/employer', [HomeController::class, 'index'])->name('employer.index');
});

// Auth routes
Auth::routes();

// Common routes
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class, 'detail'])->name('job.detail');
Route::post('/applyJob', [JobsController::class, 'applyJob'])->name('applyJob');
Route::post('/savedjob', [JobsController::class, 'savedJob'])->name('savedJob');
Route::post('/account/cv', [JobsController::class, 'updateProfilecv'])->name('account.updateProfilecv');

// User account routes
Route::group(['middleware' => ['auth']], function() {
    Route::get('/account/profile', [HomeController::class, 'profile'])->name('account.profile');
    Route::put('/account/update', [HomeController::class, 'updateProfile'])->name('account.update');
    Route::post('/account/update-profile-pic', [HomeController::class, 'updateProfilePic'])->name('account.updateProfilePic');
    Route::get('/account/create', [HomeController::class, 'createJob'])->name('account.create')->middleware('role:Employer');
    Route::post('/account/saveJob', [HomeController::class, 'saveJob'])->name('account.saveJob')->middleware('role:Employer');
    Route::get('/account/{id}', [HomeController::class, 'myJobs'])->name('account.myJobs')->middleware('role:Employer');
    Route::get('/account/{id}/edit', [HomeController::class, 'editJob'])->name('account.editJob')->middleware('role:Employer');
    Route::put('/account/{id}/update', [HomeController::class, 'updateJob'])->name('account.updateJob')->middleware('role:Employer');
    Route::delete('/account/deletejob/{id}', [HomeController::class, 'deleteJob'])->name('account.deleteJob')->middleware('role:Employer');
    Route::get('/job-application', [HomeController::class, 'jobApplication'])->name('account.jobApplication');
    Route::delete('/remove-job-application/{id}', [HomeController::class, 'removeJobApplication'])->name('account.removeJobApplication');
    Route::get('/savedJobs', [HomeController::class, 'savedJobs'])->name('account.savedJobs');
    Route::delete('/removeJobs/{id}', [HomeController::class, 'removeSavedJob'])->name('account.removeSavedJob');
});

// Chat routes
Route::get('/chatbot', [ChatController::class, 'index'])->name('chatbot');
Route::post('/compare', [ChatController::class, 'comparison'])->name('compare');
