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

Route::get('/alter-cms/login', [LoginController::class, 'showLoginForm'])->name('login');

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

Route::get('/jobs', [App\Http\Controllers\Front\HomeController::class, 'jobs'])->name('jobs.list');
