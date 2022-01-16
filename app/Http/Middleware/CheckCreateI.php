<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCreateI
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
        $userRoles = Auth::user()->tasks->pluck('name');
        //dd($userRoles);

        if(!$userRoles->contains('createi')){
            return redirect('/home');
        }

        return $next($request);
    }
}
