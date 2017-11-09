<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\App;

class ApiAuth extends BaseMiddleware
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($token = $this->auth->getToken()) {
            if ($user = $this->auth->parseToken()->authenticate()) {
                Auth::onceUsingId($user->id);

                App::setLocale($user->locale);
            }
        } else {
            throw new AuthenticationException;
        }

        return $next($request);
    }
}
