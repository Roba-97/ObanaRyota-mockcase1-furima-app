<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ExhibitController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\ChatMessageController;

Route::middleware('custom.verified')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::get('/item/{item}', [DetailController::class, 'index'])->name('detail.index');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/favorite/{item}', [DetailController::class, 'toggleItemFavorite']);
    Route::post('/comment/{item}', [DetailController::class, 'comment']);
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/profile', [MypageController::class, 'edit']);
    Route::patch('/mypage/profile', [MypageController::class, 'update']);
    Route::get('/sell', [ExhibitController::class, 'index']);
    Route::post('/sell', [ExhibitController::class, 'store']);
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'edit']);
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'update']);
    Route::post('/purchase/stripe/{item}', [PurchaseController::class, 'stripe']);
    Route::get('/purchase/{item}', [PurchaseController::class, 'index'])->middleware('profile.registered')->name('purchase.index');
    Route::get('/chat/{chatRoom}', [ChatRoomController::class, 'index']);
    Route::post('/chat/{chatRoom}', [ChatMessageController::class, 'create']);
    Route::patch('/chat/{message}', [ChatMessageController::class, 'update']);
    Route::delete('/chat/{message}', [ChatMessageController::class, 'delete']);
});

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/mypage/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return redirect('/email/verify')->with('message', '認証メールを再度送付しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
