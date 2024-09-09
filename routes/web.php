<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\CodeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RestaurantUserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\CatalogItemController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Models\Restaurant;

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

Route::view('/', 'index')->name('home');

// routes/web.php
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/getitems', [HomeController::class, 'getItems'])->name('items.get');

Route::get('scan/{code}',     [HomeController::class, 'scan'])->name('scan');

Route::get('contact/{slug}',  [HomeController::class, 'contact'])->name('contact');


//Admin Routes
Route::prefix('/')
  ->middleware(['auth:frontend', 'phone-verified'])
  ->name('account.')
  ->group(function () {
    Route::get('account/update',     [HomeController::class, 'edit'])->name('edit');
    Route::post('account/update',    [HomeController::class, 'update'])->name('update');
    Route::get('account/statistics', [HomeController::class, 'statistics'])->name('statistics');

    Route::post('account/password_change',    [HomeController::class, 'passwordChange'])->name('password.change');

    Route::post('account/restaurant/update/{id}', [App\Http\Controllers\RestaurantController::class, 'update'])
      ->name('restaurant.update');


    // Catalog
    Route::get('/catalog', [App\Http\Controllers\CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/create', [App\Http\Controllers\CatalogController::class, 'create'])->name('catalog.create');
    Route::post('/catalog/store', [App\Http\Controllers\CatalogController::class, 'store'])->name('catalog.store');
    Route::get('/catalog/edit/{id}', [App\Http\Controllers\CatalogController::class, 'edit'])->name('catalog.edit');
    Route::put('/catalog/update/{id}', [App\Http\Controllers\CatalogController::class, 'update'])->name('catalog.update');
    Route::delete('/catalog/delete/{id}', [App\Http\Controllers\CatalogController::class, 'delete'])->name('catalog.delete');

    // Catalog Menu
    Route::get('/catalog_item', [App\Http\Controllers\CatalogItemController::class, 'index'])->name('catalog.item.index');
    Route::get('/catalog_item/create', [App\Http\Controllers\CatalogItemController::class, 'create'])->name('catalog.item.create');
    Route::post('/catalog_item/store', [App\Http\Controllers\CatalogItemController::class, 'store'])->name('catalog.item.store');
    Route::get('/catalog_item/edit/{id}', [App\Http\Controllers\CatalogItemController::class, 'edit'])->name('catalog.item.edit');
    Route::put('/catalog_item/update/{id}', [App\Http\Controllers\CatalogItemController::class, 'update'])->name('catalog.item.update');
    Route::delete('/catalog_item/delete/{id}', [App\Http\Controllers\CatalogItemController::class, 'delete'])->name('catalog.item.delete');

    // File Manager
    Route::get('/filemanager', [FileManagerController::class, 'index'])->name('filemanager.index');

    Route::get('/files/{modal_type}', [FileManagerController::class, 'files'])->name('filemanager.files');
  });

//Admin Routes
Route::prefix('admin/')
  ->middleware(['auth:sanctum', 'verified'])
  ->group(function () {


    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('export-codes', [CodeController::class, 'export'])->name('codes.export');
    Route::get('qr-generator', [CodeController::class, 'qrcode'])->name('qr.generator');

    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('codes', CodeController::class);
    Route::resource('restaurant_user', RestaurantUserController::class);
    Route::resource('users', UserController::class);


    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::get('/backups/{type}/{filename}/download', [BackupController::class, 'download'])->name('backups.download');
    Route::delete('/backups/{type}/{filename}', [BackupController::class, 'delete'])->name('backups.delete');
    Route::post('/backups', [BackupController::class, 'create'])->name('backups.create');


    // Restaurant
    Route::get('/restaurant', [RestaurantController::class, 'index'])->name('restaurant.index');
    Route::get('/restaurant/create', [RestaurantController::class, 'create'])->name('restaurant.create');
    Route::post('/restaurant/store', [RestaurantController::class, 'store'])->name('restaurant.store');
    Route::get('/restaurant/edit/{id}', [RestaurantController::class, 'edit'])->name('restaurant.edit');
    Route::put('/restaurant/update/{id}', [RestaurantController::class, 'update'])->name('restaurant.update');
    Route::delete('/restaurant/delete/{id}', [RestaurantController::class, 'delete'])->name('restaurant.delete');
    Route::get('/restaurant/view/{id}', [RestaurantController::class, 'view'])->name('restaurant.view');


    // Catalog
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/create', [CatalogController::class, 'create'])->name('catalog.create');
    Route::post('/catalog/store', [CatalogController::class, 'store'])->name('catalog.store');
    Route::get('/catalog/edit/{id}', [CatalogController::class, 'edit'])->name('catalog.edit');
    Route::put('/catalog/update/{id}', [CatalogController::class, 'update'])->name('catalog.update');
    Route::delete('/catalog/delete/{id}', [CatalogController::class, 'delete'])->name('catalog.delete');

    // Catalog Menu
    Route::get('/catalog_item', [CatalogItemController::class, 'index'])->name('catalog.item.index');
    Route::get('/catalog_item/create', [CatalogItemController::class, 'create'])->name('catalog.item.create');
    Route::post('/catalog_item/store', [CatalogItemController::class, 'store'])->name('catalog.item.store');
    Route::get('/catalog_item/edit/{id}', [CatalogItemController::class, 'edit'])->name('catalog.item.edit');
    Route::put('/catalog_item/update/{id}', [CatalogItemController::class, 'update'])->name('catalog.item.update');
    Route::delete('/catalog_item/delete/{id}', [CatalogItemController::class, 'delete'])->name('catalog.item.delete');

    // Filemanager

    Route::get('/filemanager', [FileManagerController::class, 'index'])->name('filemanager.index');
  });


// Route::get('profile/{user}',  [HomeController::class, 'profile'])->name('profile');
Route::get('/{user}',  [HomeController::class, 'profile'])->name('profile');
