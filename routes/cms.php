<?php

use App\Http\Controllers\alterCMS\API\APIController;
use App\Http\Controllers\alterCMS\Category\CategoryController;
use App\Http\Controllers\alterCMS\Faq\FaqController;
use App\Http\Controllers\alterCMS\HomeController;
use App\Http\Controllers\alterCMS\Media\MediaController;
use App\Http\Controllers\alterCMS\Post\PostController;
use App\Http\Controllers\alterCMS\Page\PageController;
use App\Http\Controllers\alterCMS\Job\JobController;
use App\Http\Controllers\alterCMS\Member\MemberController;
use App\Http\Controllers\alterCMS\Partner\PartnerController;
use App\Http\Controllers\alterCMS\Setting\SettingController;
use App\Http\Controllers\alterCMS\User\RoleController;
use App\Http\Controllers\alterCMS\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

/*
|--------------------------------------------------------------------------
| CMS Routes
|--------------------------------------------------------------------------
|
| Here is where you can register cms routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "auth" middleware group. Now create something great!
|
 */

/* ==================================================================================
Dashboard
===================================================================================*/
Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::get('logger', [LogViewerController::class, 'index']);

Route::get('logout', function () {
    Auth::logout();
    return back();
})->name('logout');

/* ==================================================================================
API
===================================================================================*/
Route::post('/update-dark-mode', [APIController::class, 'toggleDarkMode'])->name('toggle.dark-mode');

/* ==================================================================================
Role Module
====================================================================================*/

Route::get('user/roles', [RoleController::class, 'index'])->name('users.roles.index');

Route::get('user/role/create', [RoleController::class, 'create'])->name('users.roles.create');

Route::post('user/role/store', [RoleController::class, 'store'])->name('users.roles.store');

Route::get('user/role/edit/{role}', [RoleController::class, 'edit'])->name('users.roles.edit');

Route::patch('user/role/update/{role}', [RoleController::class, 'update'])->name('users.roles.update');

Route::get('user/roles/permissions/{role}', [RoleController::class, 'permissions'])->name('users.roles.permissions');

Route::post('user/roles/permission/update/{role}', [RoleController::class, 'updatePermissions'])->name('users.roles.permissions.update');

/* ==================================================================================
User Module
====================================================================================*/

Route::get('users', [UserController::class, 'index'])->name('users.index');

Route::get('users/create', [UserController::class, 'create'])->name('users.create');

Route::post('users/store', [UserController::class, 'store'])->name('users.store');

Route::get('users/edit/{user}', [UserController::class, 'edit'])->name('users.edit');

Route::patch('users/update/{user}', [UserController::class, 'update'])->name('users.update');

Route::get('user/verification/check/{token}', [UserController::class, 'verify'])->name('users.verification.check');

/* ==================================================================================
Setting Module
====================================================================================*/
Route::get('settings/main', [SettingController::class, 'main'])->name('settings.index');

Route::patch('settings/main/update', [SettingController::class, 'updateMainSetting'])->name('settings.main.update');

Route::get('settings/stripe', [SettingController::class, 'stripe'])->name('settings.stripe');

Route::patch('settings/stripe/update', [SettingController::class, 'updateStripe'])->name('settings.stripe.update');

Route::get('settings/home', [SettingController::class, 'home'])->name('settings.home');

Route::patch('settings/home/update', [SettingController::class, 'updateHome'])->name('settings.home.update');

Route::get('settings/profile', [SettingController::class, 'setting'])->name('settings.profile');

Route::patch('profile/user-setting/{setting}', [SettingController::class, 'updateSetting'])->name('settings.profile.update');

Route::get('messages', [SettingController::class, 'messages'])->name('messages.message');

Route::patch('message/{message}', [SettingController::class, 'sendMessage'])->name('messages.message.send');

/* ==================================================================================
Category Module
====================================================================================*/

Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');

Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');

Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');

Route::get('categories/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');

Route::patch('categories/update/{category}', [CategoryController::class, 'update'])->name('categories.update');

Route::delete('categories/delete/{category}', [CategoryController::class, 'delete'])->name('categories.delete');

Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');

/* ==================================================================================
Media Module
====================================================================================*/

Route::get('medias', [MediaController::class, 'index'])->name('medias.index');

Route::get('medias/add', [MediaController::class, 'create'])->name('medias.create');

Route::get('medias/edit/{media}', [MediaController::class, 'edit'])->name('medias.edit');

Route::delete('medias/delete/{media}', [MediaController::class, 'delete'])->name('medias.delete');

Route::patch('medias/update/{media}', [MediaController::class, 'update'])->name('medias.update');

Route::post('medias/store', [MediaController::class, 'store'])->name('medias.store');

Route::get('/allMedia/{search?}', [MediaController::class, 'listMedia'])->name('media.all');

Route::post('/uploadFiles', [MediaController::class, 'uploadFiles'])->name('uploadFiles');

Route::post('/updateMedia/{id}', [MediaController::class, 'updateMedia'])->name('media.update');

Route::delete('/deleteMedia/{id}', [MediaController::class, 'deleteMedia'])->name('media.delete');

/* ==================================================================================
Post Module
====================================================================================*/

Route::get('posts', [PostController::class, 'index'])->name('posts.index');

Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');

Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');

Route::get('posts/edit/{post}', [PostController::class, 'edit'])->name('posts.edit');

Route::patch('posts/update/{post}', [PostController::class, 'update'])->name('posts.update');

Route::delete('posts/delete/{post}', [PostController::class, 'delete'])->name('posts.delete');

Route::get('posts/search', [PostController::class, 'search'])->name('posts.search');

Route::get('posts/status/{post}', [PostController::class, 'statusToggle'])->name('posts.status');

Route::post('posts/quicksave/{id}', [PostController::class, 'quickSave'])->name('posts.quick.save');

/* ==================================================================================
Page Module
====================================================================================*/

Route::get('pages', [PageController::class, 'index'])->name('pages.index');

Route::get('pages/create', [PageController::class, 'create'])->name('pages.create');

Route::post('pages/store', [PageController::class, 'store'])->name('pages.store');

Route::get('pages/edit/{page}', [PageController::class, 'edit'])->name('pages.edit');

Route::patch('pages/update/{page}', [PageController::class, 'update'])->name('pages.update');

Route::delete('pages/delete/{page}', [PageController::class, 'delete'])->name('pages.delete');

Route::get('pages/search', [PageController::class, 'search'])->name('pages.search');

/* ==================================================================================
Job Module
====================================================================================*/

Route::get('jobs', [JobController::class, 'index'])->name('jobs.index');

Route::get('jobs/create', [JobController::class, 'create'])->name('jobs.create');

Route::post('jobs/store', [JobController::class, 'store'])->name('jobs.store');

Route::get('jobs/edit/{job}', [JobController::class, 'edit'])->name('jobs.edit');

Route::patch('jobs/update/{job}', [JobController::class, 'update'])->name('jobs.update');

Route::delete('jobs/delete/{job}', [JobController::class, 'delete'])->name('jobs.delete');

Route::get('jobs/search', [JobController::class, 'search'])->name('jobs.search');

Route::get('jobs/status/{job}', [JobController::class, 'statusToggle'])->name('jobs.status');

Route::post('jobs/quicksave/{id}', [JobController::class, 'quickSave'])->name('jobs.quick.save');

/* ==================================================================================
Partner Module
====================================================================================*/

Route::get('partners', [PartnerController::class, 'index'])->name('partners.index');

Route::get('partners/create', [PartnerController::class, 'create'])->name('partners.create');

Route::post('partners/store', [PartnerController::class, 'store'])->name('partners.store');

Route::get('partners/edit/{partner}', [PartnerController::class, 'edit'])->name('partners.edit');

Route::patch('partners/update/{partner}', [PartnerController::class, 'update'])->name('partners.update');

Route::delete('partners/delete/{partner}', [PartnerController::class, 'delete'])->name('partners.delete');

Route::get('partners/search', [PartnerController::class, 'search'])->name('partners.search');

/* ==================================================================================
Faq Module
====================================================================================*/

Route::get('faqs', [FaqController::class, 'index'])->name('faqs.index');

Route::get('faqs/create', [FaqController::class, 'create'])->name('faqs.create');

Route::post('faqs/store', [FaqController::class, 'store'])->name('faqs.store');

Route::get('faqs/edit/{faq}', [FaqController::class, 'edit'])->name('faqs.edit');

Route::patch('faqs/update/{faq}', [FaqController::class, 'update'])->name('faqs.update');

Route::delete('faqs/delete/{faq}', [FaqController::class, 'delete'])->name('faqs.delete');

Route::get('faqs/search', [FaqController::class, 'search'])->name('faqs.search');

/* ==================================================================================
Members Module
====================================================================================*/

Route::get('members/employee', [MemberController::class, 'employee'])->name('members.employee');

Route::get('members/employer', [MemberController::class, 'employer'])->name('members.employer');

Route::get('members/status/{member}', [MemberController::class, 'toggleStatus'])->name('members.status');

Route::get('members/employee/search', [MemberController::class, 'employeeSearch'])->name('members.employee.search');

Route::get('members/employer/search', [MemberController::class, 'employerSearch'])->name('members.employer.search');

