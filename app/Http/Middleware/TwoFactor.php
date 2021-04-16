<?php

namespace App\Http\Middleware;

use Closure;

class TwoFactor
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
        $user = auth()->user();
        // This checks if user is having two factor code. If yes, redirect user to verify page.
        if(auth()->check() && $user->two_factor_code && $user->two_factor_enable==1){
            if(!$request->is('verify*')){
                return redirect()->route('verify.index');
            }
        }
        return $next($request);
    }
}
