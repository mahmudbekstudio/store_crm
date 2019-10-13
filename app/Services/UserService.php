<?php

namespace App\Services;

use App\Http\Requests\SaveProfileRequest;
use App\Repositories\UserMetaRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService {
    private $userMeta;
    private $repository;

    public function __construct(UserMetaRepository $userMeta)
    {
        $this->userMeta = $userMeta;
        $this->repository = UserRepository::getInstance();
    }

    public function getActiveUserData() {
        $authedUser = auth()->user();
        $user = [];
        $metasList = [];

        if($authedUser) {
            $user = $authedUser->toArray();
            $metas = $this->userMeta->getMetas($user['id'], ['firstname', 'lastname'])->toArray();

            foreach($metas as $val) {
                $metasList[$val['meta_key']] = $val['meta_value'];
            }
        }

        return ['user' => $user, 'meta' => $metasList];
    }

    public function profile() {
        return responseData(true, $this->getActiveUserData());
    }

    public function saveProfile(SaveProfileRequest $request) {
        $credential = $request->only(['firstname', 'lastname', 'old_password', 'password', 'password2']);

        if(!$this->checkPassword($credential)) {
            return responseMessage(false, 'Password is incorrect');
        }

        if(!empty($credential['password'])) {
            $hasher = app('hash');
            $this->repository->update(['password' => $hasher->make($credential['password'])], auth()->id());
        }

        $this->userMeta->withUser()->deleteWhere(['meta_key' => 'firstname']);
        $this->userMeta->withUser()->deleteWhere(['meta_key' => 'lastname']);
        $this->userMeta->withUser()->create(['meta_key' => 'firstname', 'meta_value' => $credential['firstname']]);
        $this->userMeta->withUser()->create(['meta_key' => 'lastname', 'meta_value' => $credential['lastname']]);

        return responseMessage(true, 'Successfully saved');
    }

    private function checkPassword($credential) {
        $oldPassword = isset($credential['old_password']) ? $credential['old_password'] : '';
        $password = isset($credential['password']) ? $credential['password'] : '';
        $password2 = isset($credential['password2']) ? $credential['password2'] : '';
        $result = true;

        if($oldPassword == '' && $password == '' && $password2 == '') {
            return $result;
        }

        if(
            (($password || $password2) && $password !== $password2) ||
            ($password && !$oldPassword) ||
            (!$password && $oldPassword)
        ) {
            $result = false;
        }

        if($result) {
            $currentUser = auth()->user();
            $hasher = app('hash');
            if(!$hasher->check($oldPassword, $currentUser->password)) {
                $result = false;
            }
        }

        return $result;
    }

    public function getById($id) {
        return $this->repository->find($id);
    }

    public function metas($userId = false, $keys = []) {
        $userMeta = $this->userMeta;
        $result = [];
        $userMeta = $userId ? $userMeta->withUser($userId) : $userMeta->withUser();
        $userMetaList = !empty($keys) ? $userMeta->findWhereIn('meta_key', $keys) : $userMeta->all();

        foreach($userMetaList as $val) {
            $result[$val->meta_key] = $val->meta_value;
        }

        return $result;
    }

    public function getUsersByType($role) {
        return responseData(true, ['list' => $this->repository->with(['meta'])->findByField('role', $role)]);
    }

    public function getUser($role, $id) {
        $user = $this->repository->with(['meta'])->find($id);

        if($user->role != $role) {
            return responseMessage(false, 'User not found by role ' . $role);
        }

        $result = [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'created_at' => $user->created_at,
            'metas' => []
        ];

        foreach($user->meta as $val) {
            $result['metas'][$val['meta_key']] = $val['meta_value'];
        }

        return responseData(true, ['user' => $result]);
    }
}
