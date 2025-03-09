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
Route::get('/item/{item}', [DetailController::class, 'index']);

/*
Route::middleware('auth')->group(function () {
    post('/item/{item}', [DetailController::class, 'comment']);
    get('/mypage', [MypageController::class, 'index']);
    get('/mypage/profile', [MypageController::class, 'edit']);
    patch('/mypage/profile', [MypageController::class, 'update']);
    get('/sell', [ExhibitController::class, 'index']);
    post('/sell', [ExhibitController::class, 'store']);
    get('/purchase/address/{item}', [PurchaseController::class, 'edit']);
    get('/purchase/{item}', [PurchaseController::class, 'index']);
    post('/purchase/{item}', [PurchaseController::class, 'store']);
});
*/
