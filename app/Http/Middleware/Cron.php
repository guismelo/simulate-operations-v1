<?php

namespace App\Http\Middleware;

use Closure;

class Cron
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if (empty($request->token)) {
            return response()
                ->json(['success' => false, 'message' => 'security token cant`t be empty'], 401);
        }

        if ($request->token !== '9bf8f627f0517e75187cd29c56d00ed2641158c1fa807b664ec702e448ca92b9') {
            return response()
                ->json(['success' => false, 'message' => 'security token is invalid'], 401);
        }

        return $next($request);
    }
}
