<?php

use App\Http\Controllers\backend\ArticleController;
use App\Http\Controllers\backend\PermissionController;
use App\Http\Controllers\backend\ProfileController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\GalleryController;
use App\Http\Controllers\backend\GalleryFolderController;

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

Route::get('/new-backend', function () {
    return view('backend.dashboard');
});
Route::get('/alerts', function () {
    return view('alerts');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('backend.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //    Permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/view', [PermissionController::class, 'fetch'])->name('permissions.view');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/delete', [PermissionController::class, 'destroy'])->name('permissions.destroy');



    //    Roles

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/view', [RoleController::class, 'fetch'])->name('roles.view');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/delete', [RoleController::class, 'destroy'])->name('roles.destroy');

    /*Users Routes*/
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/view', [UserController::class, 'fetch'])->name('users.view');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/delete', [UserController::class, 'destroy'])->name('users.destroy');

    //    Article

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::post('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/delete', [ArticleController::class, 'destroy'])->name('articles.destroy');

    /*Gallery*/
    Route::get('gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('folder/fetch', [GalleryFolderController::class, 'show'])->name('folder.fetch');
    Route::post('folder/store', [GalleryFolderController::class, 'store'])->name('folder.store');
    Route::delete('folder/{id}', [GalleryFolderController::class, 'destroy'])->name('folder.delete');
});

Route::get('test', [GalleryController::class, 'test'])->name('test');
require __DIR__ . '/auth.php';
