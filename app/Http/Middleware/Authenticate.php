<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Crypt;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, \Closure $next, ...$guards)
    {
        if ($request->cookie('token')) {
            $request->headers->set('authorization', 'Bearer ' . Crypt::decrypt($request->cookie('token'), false));
            dd($request);
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}
