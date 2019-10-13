<?php
namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Repositories\SettingRepository;
use App\Repositories\TokenRepository;
use App\Repositories\UserMetaRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService {
    private $settingRepository;
    private $userMeta;

    public function __construct(SettingRepository $settingRepository, UserMetaRepository $userMeta)
    {
        $this->settingRepository = $settingRepository;
        $this->userMeta = $userMeta;
    }

    public function login(LoginRequest $request, $role = false) {
        $credential = $request->only(['email', 'password']);
        $token = auth()->attempt($credential);

        if($token && $role && (!in_array($role, User::getRoles()) || $role != auth()->user()->role)) {
            auth()->logout();
            return responseMessage(false, ['email' => [__('message.you_do_not_have_permission')]]);
        }

        if($token && auth()->user()->status != User::STATUS_ACTIVE) {
            $userStatus = auth()->user()->status;
            auth()->logout();
            return responseMessage(false, ['email' => [
                (
                    $userStatus == User::STATUS_NOT_ACTIVE ?
                        __('message.your_account_is_not_active') :
                        __('message.your_account_is_blocked')
                )
            ]]);
        }

        if(!$token) {
            $result = responseMessage(false, ['email' => [__('message.email_or_password_is_incorrect')]]);
        } else {
            $result = responseData(true, ['token' => $this->newTokenData($token)]);
        }

        return $result;
    }

    public function logout(LogoutRequest $request) {
        TokenRepository::getInstance()->removeToken($request->get('token'), 'refresh_token');
        auth()->invalidate();
        return responseMessage(true, __('message.you_have_been_logged_out'));
    }

    public function newTokenData($token) {
        $refreshTokenLifetime = config('app.refresh_token_lifetime');

        return [
            'access_token' => $token,
            'refresh_token' => createToken('refresh_token', 'refresh', 0, ['expiration' => $refreshTokenLifetime]),
            'created_at' => date('Y/m/d H:i:s'),
            'user' => $this->getUserAllData()
        ];
    }

    private function getUserAllData() {
        $user = auth()->user();
        $result = [
            'id' => $user->id,
            'role' => $user->role,
            'email' => $user->email
        ];

        $userMetas = $this->userMeta->all();

        foreach($userMetas as $val) {
            $result['meta'][$val->meta_key] = $val->meta_value;
        }

        return $result;
    }

    public function refresh(Request $request) {
        $token = $this->getToken($request);

        $tokenRepository = TokenRepository::getInstance()->getBy(['token' => $token, 'user_id' => false]);
        $user = UserRepository::getInstance()->find($tokenRepository->user_id);
        $newToken = auth()->login($user, false);

        TokenRepository::getInstance()->removeToken($token, 'refresh_token');
        return responseData(true, ['token' => $this->newTokenData($newToken)]);
    }

    public function getToken(Request $request) {
        return substr($request->header(config('app.token_field')), strlen(config('app.token_type') . ' '));
    }

    public function resetPassword(ResetPasswordRequest $request) {
        $data = $request->only(['email']);
        //$data['email'] - send reset password link to email
        return responseData(true);
    }

    public function register(RegisterRequest $request) {
        $data = $request->only(['email', 'password']);
        //UserRepository::getInstance()
        return responseData(true);
    }
}
