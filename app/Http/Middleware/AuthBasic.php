<?php

namespace App\Http\Middleware;

use Closure;

class AuthBasic
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
        $user = config('auth.basic.user');
        $pass = config('auth.basic.pass');

        if (empty($user) || empty($pass)) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'server auth can`t be empty',
                    'data' => null
                ], 401);
        }

        $loginUser = $request->getUser();
        $loginPass = $request->getPassword();

        if ($loginUser == $user && $loginPass == $pass) {
            return $next($request);
        }

        return response()
            ->json([
                'success' => false,
                'message' => 'access denied',
                'data' => null
            ], 401);
    }
}
