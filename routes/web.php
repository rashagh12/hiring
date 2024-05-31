<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobApplications;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\admin\UserController;
use App\Models\Category;
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

Route::get('/', function () {
    return view('home');
});
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
Route::get('/jobs',[JobsController::class,'index'])->name('jobs');
Route::get('/jobs/detail/{id}',[JobsController::class,'detail'])->name('jobDetail');
Route::post('/applyJob',[JobsController::class,'applyJob'])->name('applyJob');
Route::post('/savedjob',[JobsController::class,'savedJob'])->name('savedJob');

// 'middleware' => 'checkRole'
    Route::get('/admin/dashboard',[DashboardController::class,'index'])->name('admin.dashboard')->middleware('checkRole');
    Route::get('/admin/users',[UserController::class,'index'])->name('admin.users');
    Route::get('/admin/{id}/edite',[UserController::class,'edite'])->name('admin.users.edite');
    Route::put('/admin/update',[UserController::class,'update'])->name('admin.users.update');
    Route::delete('/admin/delete/{id}',[UserController::class,'deleteuser'])->name('admin.users.delete');
    Route::get('/admin/cv/{id}',[UserController::class,'viewcv'])->name('admin.users.cv');



Route::get('/admin/jobs',[JobController::class,'index'])->name('admin.jobs');
Route::get('/applicants',[JobApplications::class,'index'])->name('jobs.applicants');


Route::get('/admin/category',[CategoryController::class,'index'])->name('admin.category');
Route::get('/admin/category/create',[CategoryController::class,'createCategory'])->name('admin.category.create');
Route::post('/admin/category/saveCategory',[CategoryController::class,'saveCategory'])->name('admin.category.save');
Route::get('/admin/editCategory/{id}',[CategoryController::class,'editCategory'])->name('admin.category.edit');
Route::put('/admin/updateCategory/{id}',[CategoryController::class,'updateCategory'])->name('admin.category.update');
Route::delete('/admin/deleteCategory/{id}',[CategoryController::class,'deleteCategory'])->name('admin.category.delete');



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/account/profile', [HomeController::class, 'profile'])->name('account.profile');
Route::put('/account/update', [HomeController::class, 'updateprofile'])->name('account.update');
Route::post('/account/update-profile-pic', [HomeController::class, 'updateProfilePic'])->name('account.updateProfilePic');
Route::get('/account/create', [HomeController::class, 'createJob'])->name('account.create')->middleware('checkRole');
Route::post('/account/saveJob', [HomeController::class, 'saveJob'])->name('account.saveJob')->middleware('checkRole');
Route::get('/account/{id}', [HomeController::class, 'myJobs'])->name('account.myJobs')->middleware('checkRole');
Route::get('/account/{id}/edit', [HomeController::class, 'editejob'])->name('account.editejob')->middleware('checkRole');
Route::put('/account/{id}/update', [HomeController::class, 'updatejob'])->name('account.updatejob')->middleware('checkRole');
Route::delete('/account/deletejob/{id}', [HomeController::class, 'deletejob'])->name('account.deletejob')->middleware('checkRole');
Route::get('/job-application', [HomeController::class, 'jobApplication'])->name('account.jobApplication');
Route::delete('/remove-job-application/{id}',[HomeController::class,'removeJobs'])->name('account.removeJobs');   
Route::get('/savedJobs',[HomeController::class,'savedJobs'])->name('account.savedJobs');   
Route::delete('/removeJobs/{id}',[HomeController::class,'removesavedJobs'])->name('account.removeSavedJob');   
Route::post('/account/cv',[JobsController::class,'updateProfilecv'])->name('account.updateProfilecv');   


