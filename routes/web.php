<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [App\Http\Controllers\Front\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/set-jobs-cms/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('/login', function(){
  return redirect(route('home'));
});

Route::get('/register', function(){
  return redirect(route('home'));
});

Route::get('logout', function () {
  Auth::guard('web')->logout();
  Auth::guard('business')->logout();
  Auth::guard('client')->logout();
  Auth::logout();
  return back();
})->name('logout');

Route::post('/login/user', [App\Http\Controllers\Auth\LoginController::class, 'alterLogin'])->name('post.alter.login');

Route::get('/dashboard', [App\Http\Controllers\Front\DashboardController::class, 'dashboard'])->name('user.dashboard');

Route::get('/dashboard/profile', [App\Http\Controllers\Front\DashboardController::class, 'profile'])->name('user.profile');

/** Employer Routes **/
Route::post('/employer/update/profile', [App\Http\Controllers\Front\DashboardController::class, 'employerUpdateProfile'])->name('employer.update.profile');

Route::get('/dashboard/jobs', [App\Http\Controllers\Front\DashboardController::class, 'jobs'])->name('dashboard.jobs');

Route::get('/dashboard/jobs/add', [App\Http\Controllers\Front\DashboardController::class, 'createJobs'])->name('dashboard.jobs.create');

Route::post('/dashboard/jobs/store', [App\Http\Controllers\Front\DashboardController::class, 'storeJob'])->name('dashboard.jobs.store');

Route::get('/dashboard/jobs/edit/{id}', [App\Http\Controllers\Front\DashboardController::class, 'editJobs'])->name('dashboard.jobs.edit');

Route::post('/dashboard/jobs/update/{id}', [App\Http\Controllers\Front\DashboardController::class, 'updateJob'])->name('dashboard.jobs.update');

/** Employee Routes */
Route::post('/employee/update/profile', [App\Http\Controllers\Front\DashboardController::class, 'employeeUpdateProfile'])->name('employee.update.profile');


/** Front Routes */
Route::get('/jobs', [App\Http\Controllers\Front\HomeController::class, 'jobs'])->name('jobs.list');

Route::get('/jobs-detail', [App\Http\Controllers\Front\HomeController::class, 'jobDetail'])->name('jobs.detail');

Route::get('/about-us', [App\Http\Controllers\Front\HomeController::class, 'about'])->name('about');

Route::get('/terms-and-conditions', [App\Http\Controllers\Front\HomeController::class, 'terms'])->name('terms');

Route::get('/privacy-policies', [App\Http\Controllers\Front\HomeController::class, 'privacy'])->name('privacy');

Route::get('/company/{slug}', [App\Http\Controllers\Front\HomeController::class, 'employerDetail'])->name('employer.detail');

Route::get('/profile/{slug}', [App\Http\Controllers\Front\HomeController::class, 'employeeDetail'])->name('employee.detail');

Route::get('/faqs', [App\Http\Controllers\Front\HomeController::class, 'faqs'])->name('faqs');