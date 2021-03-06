<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use App\Models\UserMeta;
use App\Repositories\UserMetaRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userRepository;
    private $userMetaRepository;
    private $user;

    public function __construct(UserRepository $userRepository, UserMetaRepository $userMetaRepository)
    {
        if(auth()->guest()) {
            throw new \Exception('User not authenticated');
        }

        $this->userRepository = $userRepository;
        $this->userMetaRepository = $userMetaRepository;
        $this->user = auth()->user();
    }

    public function list()
    {
        $list = [];
        $names = [];
        $phones = [];
        $this->userMetaRepository->all(['user_id', 'meta_key', 'meta_value'])->map(function($item) use(&$names, &$phones) {
            $names[$item['user_id']] = $names[$item['user_id']] ?? '';

            if($item['meta_key'] === 'first_name') {
                $names[$item['user_id']] = $item['meta_value'] . ' ' . $names[$item['user_id']];
            } elseif($item['meta_key'] === 'last_name') {
                $names[$item['user_id']] = $names[$item['user_id']] . $item['meta_value'];
            } elseif($item['meta_key'] === 'phone') {
                $phones[$item['user_id']] = $item['meta_value'];
            }
        });

        $this->userRepository->findWhereIn('role', User::getAccessRoles())->map(function($item) use(&$list, $names, $phones) {
            $list[] = [
                'id'        => $item->id,
                'name'      => $names[$item->id] ?? $item->id,
                'phone'     => $phones[$item->id] ?? '',
                'email'     => $item->email,
                'status'    => $item->status ? __('words.active') : __('words.not_active'),
                'role'      => $item->role,
                'created'   => $item->created_at->format(config('app.date_format'))
            ];
        });

        return responseData(true, ['list' => $list]);
    }

    public function params()
    {
        $roles = [];
        foreach(User::getAccessRoles() as $item) {
            $roles[$item] = ucfirst($item);
        }

        return responseData(true, ['roles' => $roles, 'statuses' => User::getStatuses()]);
    }

    public function add(AddUserRequest $request)
    {
        $metaData = $request->only(['firstName', 'lastName']);
        $userData = $request->only(['email', 'password', 'status', 'role']);
        $user = $this->userRepository->create($userData);
        $this->userMetaRepository->create([
            'user_id' => $user->id,
            'meta_format' => 'string',
            'meta_key' => 'first_name',
            'meta_value' => $metaData['firstName'],
            'lang' => 'en'
        ]);
        $this->userMetaRepository->create([
            'user_id' => $user->id,
            'meta_format' => 'string',
            'meta_key' => 'last_name',
            'meta_value' => $metaData['lastName'],
            'lang' => 'en'
        ]);
        $this->userMetaRepository->create([
            'user_id' => $user->id,
            'meta_format' => 'string',
            'meta_key' => 'full_name',
            'meta_value' => $metaData['firstName'] . ' ' . $metaData['lastName'],
            'lang' => 'en'
        ]);
        return responseData(true);
    }

    public function item($id)
    {
        $item = [];
        $user = $this->userRepository->with('metas')->find($id)->toArray();
        foreach($user as $key => $val) {
            if($key != 'metas') {
                $item[$key] = $val;
            }
        }

        foreach($user['metas'] as $val) {
            $item[$val['meta_key']] = $val['meta_value'];
        }

        return responseData(true, ['item' => $item]);
        /*return responseData(true, ['item' => $this->schoolRepository->find($id), 'regions' => $this->regionRepository->all()]);*/
    }

    public function edit($id, EditUserRequest $request)
    {
        $metaData = $request->only(['firstName', 'lastName']);
        $userData = $request->only(['email', 'password', 'status', 'role']);

        if($userData['password'] === '') {
            unset($userData['password']);
        }

        $this->userRepository->update($userData, $id);

        $this->userMetaRepository->deleteWhere(['user_id' => $id, 'meta_key' => 'first_name']);
        $this->userMetaRepository->deleteWhere(['user_id' => $id, 'meta_key' => 'last_name']);
        $this->userMetaRepository->deleteWhere(['user_id' => $id, 'meta_key' => 'full_name']);

        $this->userMetaRepository->create([
            'user_id' => $id,
            'meta_format' => 'string',
            'meta_key' => 'first_name',
            'meta_value' => $metaData['firstName'],
            'lang' => 'en'
        ]);
        $this->userMetaRepository->create([
            'user_id' => $id,
            'meta_format' => 'string',
            'meta_key' => 'last_name',
            'meta_value' => $metaData['lastName'],
            'lang' => 'en'
        ]);
        $this->userMetaRepository->create([
            'user_id' => $id,
            'meta_format' => 'string',
            'meta_key' => 'full_name',
            'meta_value' => $metaData['firstName'] . ' ' . $metaData['lastName'],
            'lang' => 'en'
        ]);

        return responseData(true);
    }

    public function delete($id)
    {
        if($id == $this->user->id) {
            return responseData(false, ['message' => __('message.you_can_not_delete_yourself')]);
        }

        $this->userRepository->delete($id);
        return responseData(true);
    }
}
