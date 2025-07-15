<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsChatRoomParticipant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $chatRoom = $request->route('chatRoom');

        // チャットルームの参加者でない
        if (!$chatRoom->isSeller(Auth::user()) && !$chatRoom->isBuyer(Auth::user())) {
            return redirect('/mypage/?page=deal');
        }

        // 購入者が取引終了済み
        if ($chatRoom->isBuyer(Auth::user()) && $chatRoom->status >= 1) {
            return redirect('/mypage/?page=deal');
        }

        // 出品者も取引完了済み
        if ($chatRoom->isSeller(Auth::user()) && $chatRoom->status >= 2) {
            return redirect('/mypage/?page=deal');
        }

        return $next($request);
    }
}
