<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Host
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
        if(Auth::check() && Auth::user()->isHost() ){
            return $next($request);
        }
        
        $Role = Auth::user()->roles->first();
        return redirect('/'.$Role->name);
    }
}
