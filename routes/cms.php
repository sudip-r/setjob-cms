<?php

use App\Http\Controllers\alterCMS\API\APIController;
use App\Http\Controllers\alterCMS\Category\CategoryController;
use App\Http\Controllers\alterCMS\HomeController;
use App\Http\Controllers\alterCMS\Media\MediaController;
use App\Http\Controllers\alterCMS\Post\PostController;
use App\Http\Controllers\alterCMS\Page\PageController;
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
Route::get('profile/user-setting', [SettingController::class, 'setting'])->name('profile.setting');

Route::patch('profile/user-setting/{setting}', [SettingController::class, 'updateSetting'])->name('profile.setting.update');

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

$router->get('pages', [PageController::class, 'index'])->name('pages.index');

$router->get('pages/create', [PageController::class, 'create'])->name('pages.create');

$router->post('pages/store', [PageController::class, 'store'])->name('pages.store');

$router->get('pages/edit/{page}', [PageController::class, 'edit'])->name('pages.edit');

$router->patch('pages/update/{page}', [PageController::class, 'update'])->name('pages.update');

$router->delete('pages/delete/{page}', [PageController::class, 'delete'])->name('pages.delete');

$router->get('pages/search', [PageController::class, 'search'])->name('pages.search');
