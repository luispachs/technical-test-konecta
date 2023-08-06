<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{SaleController,ProductController};

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

Route::get('/', [SaleController::class,'index'])->name('main');
Route::any('/product/list',[ProductController::class,'index'])->name('index.product');
Route::post('/product/create',[ProductController::class,'createAction'])->name('create.product');
Route::get('/product/update/{id}',[ProductController::class,'updateViewAction'])->name('update.product');
Route::post('/product/update',[ProductController::class,'updateAction'])->name('send.update.product');

