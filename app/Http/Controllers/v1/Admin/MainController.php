<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Requests\SettingsRequest;
use App\Repositories\SettingRepository;
use App\Repositories\TypeRepository;
use App\Services\UserService;

class MainController extends Controller
{
    private $settingRepository;
    private $typeRepository;
    private $userService;
    public $websiteAllSettings = ['name', 'logo'];

    public function __construct(
        TypeRepository $typeRepository,
        SettingRepository $settingRepository,
        UserService $userService
    ) {
        $this->settingRepository = $settingRepository;
        $this->userService = $userService;
        $this->typeRepository = $typeRepository;
    }

    public function settings() {
        $settings = $this->userService->getActiveUserData();
        $settings['website'] = $this->allSettings();
        $settings['types'] = $this->typeRepository->findByField('status', 1, ['id', 'title', 'name', 'type', 'has_parent', 'child_of'])->all();

        return responseData(true, ['settings' => $settings]);
    }

    public function metas($keys = []) {
        $result = [];
        $settingRepositoryList =
            !empty($keys) ?
            $this->settingRepository->findWhereIn('meta_key', $keys) :
            $this->settingRepository->all();

        foreach($settingRepositoryList as $val) {
            $result[$val->meta_key] = $val->meta_value;
        }

        return $result;
    }

    public function allSettings() {
        return $this->metas($this->websiteAllSettings);
    }

    public function saveSettings(SettingsRequest $request) {
        $data = $request->only($this->websiteAllSettings);
        $this->updateAllMetas($data);

        return responseMessage(true, 'Success');
    }

    private function updateAllMetas($data) {
        $this->settingRepository->deleteWhere([]);

        foreach($data as $key => $val) {
            $this->settingRepository->create(['meta_key' => $key, 'meta_value' => $val]);
        }
    }
}
