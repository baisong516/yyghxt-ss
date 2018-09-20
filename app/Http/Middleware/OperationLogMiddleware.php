<?php

namespace App\Http\Middleware;

use App\OperationLog;
use Closure;
use Illuminate\Support\Facades\Auth;

class OperationLogMiddleware
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
        if (Auth::User()) {
            $log = [
                'user_id' => Auth::user()->id,
                'path'    => $request->path(),
                'method'  => $request->method(),
                'ip'      => $request->getClientIp(),
                'input'   => '',
            ];
            if ($request->method()!='GET'){
                OperationLog::create($log);
            }
        }
        return $next($request);
    }
}
