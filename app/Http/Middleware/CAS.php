<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class CAS
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
        //1-检查有没有ticket
        $ticket = Session::get('ticket');
        if ($ticket === null) {
            return redirect()->route('admin.login.login');
        }
        //继续访问
        return $next($request);
    }
}
