<?php

namespace App\Http\Middleware;

use Closure;
// use Session;
use App\SpecialUsers;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Str;

class RedirectIfNotLoggedIn
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
        // Check if user is logged in
        if (!Session::has('email')) {
            //check if user has userRole
            if (Session::has('userRole')) {
                $sessionRole = Session::get('userRole');

                //check which type of role it is

                //if OMC --- go to OMC Page
                if (strtoupper($sessionRole) == "OMC" || strtoupper($sessionRole) == "ADMIN") {
                    return redirect()->route('PetrosmartOmc');
                }
                if (strtoupper($sessionRole) == "USER" || strtoupper($sessionRole) == "MANAGER") {
                    return redirect()->route('Petrosmart Customer');
                }
            }
            return redirect()->route('login');
        }

        return $next($request);
    }
}
