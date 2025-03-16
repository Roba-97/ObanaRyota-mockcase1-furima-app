<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ExhibitController;
use App\Http\Controllers\PurchaseController;

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

Route::get('/', [ItemController::class, 'index']);
Route::get('/search', [ItemController::class, 'search']);
Route::get('/item/{item}', [DetailController::class, 'index'])->name('detail.index');

Route::middleware('auth')->group(function () {
    Route::get('/favorite/{item}', [DetailController::class, 'toggleItemFavorite']);
    Route::post('/comment/{item}', [DetailController::class, 'comment']);
    Route::get('/mypage', [MypageController::class, 'index']);
    Route::get('/mypage/profile', [MypageController::class, 'edit']);
    Route::patch('/mypage/profile', [MypageController::class, 'update']);
    Route::get('/sell', [ExhibitController::class, 'index']);
    Route::post('/sell', [ExhibitController::class, 'store']);
    Route::get('/purchase/address/', [PurchaseController::class, 'edit']);
    Route::get('/purchase/{item}', [PurchaseController::class, 'index']);
    Route::post('/purchase/{item}', [PurchaseController::class, 'store']);
});