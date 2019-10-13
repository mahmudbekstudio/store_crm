<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomException;
use App\Models\User;
use App\Repositories\TokenRepository;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use \Tymon\JWTAuth\Exceptions\TokenInvalidException;
use \Tymon\JWTAuth\Exceptions\TokenExpiredException;

class Token extends BaseMiddleware
{
    private $payload;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = '')
    {
        try {
            $this->tokenExist($request);
            $roleParams = explode('.', $role);
            $mainParam = array_shift($roleParams);

            switch($mainParam) {
                case 'access':
                    $this->checkAccess($request, $roleParams);
                    break;
                case 'refresh':
                    $this->checkRefresh($request, $roleParams);
                    break;
                case 'once':
                    $this->checkOnce($request, $roleParams);
                    break;
            }
        } catch(Exception $e) {
            if($e instanceof TokenInvalidException) {
                return response()->json(responseMessage(false, __('message.token_is_invalid')));
            } elseif ($e instanceof TokenExpiredException) {
                return response()->json(responseMessage(false, __('message.token_is_expired')));
            } elseif ($e instanceof CustomException) {
                return response()->json(responseMessage(false, $e->getMessage()));
            } else {
                return response()->json(responseMessage(false, __('message.authorization_token_not_found')));
            }
        }

        return $next($request);
    }

    /*private function auth($request) {
        $token = $this->getHeaderToken($request);

        if(!$token) throw new Exception();

        $user = auth()->authenticate($token);

        if(!$user) throw new Exception('Token is Invalid');

        auth()->login($user, false);
    }*/

    private function checkAccess($request, $roleParams) {
        $this->payload = auth()->payload();
        $tokenParam = array_shift($roleParams);

        if(in_array($tokenParam, User::getRoles())) {
            $this->checkRole($tokenParam);
        }

        $this->authenticate($request);
    }

    private function checkRole($role) {
        $roleArr = explode('_', $role);
        if(!in_array($this->payload['role'], $roleArr)) throw new CustomException(__('message.you_do_not_have_permission'));
    }

    private function checkRefresh($request, $roleParams) {
        $tokenRepository = TokenRepository::getInstance()->getBy(['token' => $this->getHeaderToken($request), 'user_id' => false]);

        if(!$tokenRepository) throw new TokenInvalidException();
        if($tokenRepository->expiration < utcTime()) throw new TokenExpiredException();
    }

    private function checkOnce($request, $roleParams) {
        //
    }

    private function tokenExist($request) {
        $token = $this->getHeaderToken($request);

        if(!$token) throw new CustomException(__('message.token_in_not_exist'));
    }

    private function getHeaderToken(Request $request) {
        $authorization = $request->header('Authorization');
        return $authorization ? substr($authorization, strlen('Bearer ')) : null;
    }
}
