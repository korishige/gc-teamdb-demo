<?php

namespace App\Http\Middleware;

use Closure;

class AuthAdmin
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
    if (\Session::get('role') != 'admin')
      return \Redirect::to('/');
    return $next($request);
  }
}
