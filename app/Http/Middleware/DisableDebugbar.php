<?php

namespace App\Http\Middleware;

use Barryvdh\Debugbar\LaravelDebugbar;
use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\JWTAuth;

class DisableDebugbar extends BaseMiddleware
{
    /**
     * The DebugBar instance
     *
     * @var LaravelDebugbar
     */
    protected $debugbar;

    /**
     * Create a new middleware instance.
     *
     * @param JWTAuth $auth
     * @param LaravelDebugbar $debugbar
     */
    public function __construct(JWTAuth $auth, LaravelDebugbar $debugbar)
    {
        parent::__construct($auth);
        $this->debugbar = $debugbar;
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
        $this->debugbar->disable();
        return $next($request);
    }
}
