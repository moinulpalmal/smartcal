<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCreateQC
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

        if(!$userRoles->contains('createqcs')){
            return redirect('/home');
        }

        return $next($request);
    }
}
