<?php

namespace App\Http\Middleware;

use App\Models\UserCard;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckCardOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $owner_id = Auth::user()->id;

        /** @var UserCard $card */
        $card = Route::current()->parameter('card');

        if (!$card || $card->user_id != $owner_id) {
            return redirect(\route('site.cards'));
        }

        return $next($request);
    }
}
