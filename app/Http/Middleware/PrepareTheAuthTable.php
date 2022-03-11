<?php

namespace App\Http\Middleware;

use Closure;

class PrepareTheAuthTable
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
      if (\Auth::guard('sales')->check()) {
        $guard = 'sales';
      }
      else {
        $guard = 'admin';
      }
      \Config::set('auth.defaults.guard', $guard);

      view()->share('user_role', $guard);
      return $next($request);
    }
}
