<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddUserRequest;
use App\Models\User;
use App\Models\UserMeta;
use App\Repositories\UserMetaRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

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
        $this->userMetaRepository->all(['user_id', 'meta_key', 'meta_value'])->map(function($item) use(&$names) {
            $names[$item['user_id']] = $names[$item['user_id']] ?? '';

            if($item['meta_key'] === 'first_name') {
                $names[$item['user_id']] = $item['meta_value'] . ' ' . $names[$item['user_id']];
            } elseif($item['meta_key'] === 'last_name') {
                $names[$item['user_id']] = $names[$item['user_id']] . $item['meta_value'];
            }
        });

        $this->userRepository->all()->map(function($item) use(&$list, $names) {
            $list[] = [
                'id'        => $item->id,
                'name'      => $names[$item->id] ?? $item->id,
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
        return responseData(true, ['roles' => User::getRoles(), 'statuses' => User::getStatuses()]);
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
        return responseData(true);
    }

    public function item($id)
    {
        $item = [];
        $user = $this->userRepository->find($id);
        foreach($user as $key => $item) {
            $item[$key] = $item;
        }

        $userMeta = $this->userMetaRepository->getMetas($id);
        foreach($userMeta as $key => $val) {
            $item[$val['meta_key']] = $val['meta_value'];
        }
        return responseData(true, ['item' => $item]);
        /*return responseData(true, ['item' => $this->schoolRepository->find($id), 'regions' => $this->regionRepository->all()]);*/
    }

    public function edit($id, Request $request)
    {
        $metaData = $request->only(['firstName', 'lastName']);
        $userData = $request->only(['email', 'password', 'status', 'role']);
        $this->userRepository->update($userData, $id);

        $this->userMetaRepository->deleteWhere(['user_id' => $id, 'meta_key' => 'first_name']);
        $this->userMetaRepository->deleteWhere(['user_id' => $id, 'meta_key' => 'last_name']);

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
