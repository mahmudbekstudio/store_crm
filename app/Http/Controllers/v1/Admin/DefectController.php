<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserMeta;
use App\Repositories\DefectRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\UserMetaRepository;
use Illuminate\Http\Request;

class DefectController extends Controller
{
    private $defectRepository;

    public function __construct(
        DefectRepository $defectRepository
    ) {
        $this->defectRepository = $defectRepository;
    }

    public function list()
    {
        $defects = $this->defectRepository->with(['region', 'district', 'school', 'from_user.metas', 'received_user.metas', 'manager.metas'])->all()->toArray();
        $list = [];

        foreach($defects as $item) {
            $fromUserName = '';
            $fromUserPhone = '';
            $receivedUserName = '';
            $managerName = '';

            foreach($item['from_user']['metas'] ?? [] as $meta) {
                if($meta['meta_key'] === 'full_name') {
                    $fromUserName = $meta['meta_value'];
                }

                if($meta['meta_key'] === 'phone') {
                    $fromUserPhone = $meta['meta_value'];
                }
            }

            foreach($item['received_user']['metas'] ?? [] as $meta) {
                if($meta['meta_key'] === 'full_name') {
                    $receivedUserName = $meta['meta_value'];
                }
            }

            foreach($item['manager']['metas'] ?? [] as $meta) {
                if($meta['meta_key'] === 'full_name') {
                    $managerName = $meta['meta_value'];
                }
            }

            $list[] = [
                'id' => $item['id'],
                'date' => $item['date'],
                'region' => $item['region']['name'],
                'district' => $item['district']['name'],
                'school' => $item['school']['name'],
                'from_user_name' => $fromUserName,
                'from_user_phone' => $fromUserPhone,
                'received_user_name' => $receivedUserName,
                'product1' => $item['goods1_id'] ? 'O' : '',
                'product2' => $item['goods2_id'] ? 'O' : '',
                'product3' => $item['goods3_id'] ? 'O' : '',
                'product4' => $item['goods4_id'] ? 'O' : '',
                'product5' => $item['goods5_id'] ? 'O' : '',
                'product6' => $item['goods6_id'] ? 'O' : '',
                'product7' => $item['goods7_id'] ? 'O' : '',
                'comment' => $item['comment'],
                'replacement_part' => $item['replacement_of_part'] ? 'O' : '',
                'recovery' => $item['recovery'] ? 'O' : '',
                'replacement_pc' => $item['replacement_of_pc'] ? 'O' : '',
                'date_done' => $item['date_of_done'],
                'manager_name' => $managerName
            ];
        }

        return responseData(true, ['list' => $list]);
    }

    public function changeField(Request $request)
    {
        $data = $request->only(['id', 'key', 'val']);

        if(count($data) == 3) {
            $item = $this->defectRepository->find($data['id']);

            switch ($data['key']) {
                case 'date':
                    $item->date = $data['val'];
                    $item->save();
                    break;
                case 'region':
                    $regionRepository = app(RegionRepository::class);
                    $region = $regionRepository->find($item->region_id);
                    $region->name = $data['val'];
                    $region->save();
                    break;
                case 'district':
                    $districtRepository = app(DistrictRepository::class);
                    $district = $districtRepository->find($item->district_id);
                    $district->name = $data['val'];
                    $district->save();
                    break;
                case 'school':
                    $schoolRepository = app(SchoolRepository::class);
                    $school = $schoolRepository->find($item->school_id);
                    $school->name = $data['val'];
                    $school->save();
                    break;
                case 'from_user_name':
                    $vals = explode(' ', $data['val']);
                    $vals[1] = $vals[1] ?? '';
                    $fullName = implode(' ', $vals);
                    $userRepository = app(UserMetaRepository::class);
                    $userMetas = $userRepository->findWhere(['user_id' => $item->from_user_id]);
                    foreach($userMetas as $item) {
                        if($item->meta_key === 'first_name') {
                            $item->meta_value = $vals[0];
                        }

                        if($item->meta_key === 'last_name') {
                            $item->meta_value = $vals[1];
                        }

                        if($item->meta_key === 'full_name') {
                            $item->meta_value = $fullName;
                        }

                        $item->save();
                    }
                    break;
                case 'from_user_phone':
                    $userRepository = app(UserMetaRepository::class);
                    $userMetas = $userRepository->findWhere(['user_id' => $item->from_user_id]);
                    foreach($userMetas as $item) {
                        if($item->meta_key === 'phone') {
                            $item->meta_value = $data['val'];
                            $item->save();
                        }
                    }
                    break;
                case 'received_user_name':
                    $vals = explode(' ', $data['val']);
                    $vals[1] = $vals[1] ?? '';
                    $fullName = implode(' ', $vals);
                    $userRepository = app(UserMetaRepository::class);
                    $userMetas = $userRepository->findWhere(['user_id' => $item->received_user_id]);
                    foreach($userMetas as $item) {
                        if($item->meta_key === 'first_name') {
                            $item->meta_value = $vals[0];
                        }

                        if($item->meta_key === 'last_name') {
                            $item->meta_value = $vals[1];
                        }

                        if($item->meta_key === 'full_name') {
                            $item->meta_value = $fullName;
                        }

                        $item->save();
                    }
                    break;
                case 'product1':
                    $item->goods1_id = $data['val'] == 'O';
                    $item->save();
                    break;
                case 'product2':
                    $item->goods2_id = $data['val'] == 'O';
                    $item->save();
                    break;
                case 'product3':
                    $item->goods3_id = $data['val'] == 'O';
                    $item->save();
                    break;
                case 'product4':
                    $item->goods4_id = $data['val'] == 'O';
                    $item->save();
                    break;
                case 'product5':
                    $item->goods5_id = $data['val'] == 'O';
                    $item->save();
                    break;
                case 'product6':
                    $item->goods6_id = $data['val'] == 'O';
                    $item->save();
                    break;
                case 'product7':
                    $item->goods7_id = $data['val'] == 'O';
                    $item->save();
                    break;
                case 'comment':
                    $item->comment = $data['val'];
                    $item->save();
                    break;
                case 'replacement_part':
                    $item->replacement_of_part = $data['val'] == 'O';
                    $item->save();
                    break;
                case 'recovery':
                    $item->recovery = $data['val'] == 'O';
                    $item->save();
                    break;
                case 'replacement_pc':
                    $item->replacement_of_pc = $data['val'] == 'O';
                    $item->save();
                    break;
                case 'date_done':
                    $item->date_of_done = $data['val'];
                    $item->save();
                    break;
                case 'manager_name':
                    $vals = explode(' ', $data['val']);
                    $vals[1] = $vals[1] ?? '';
                    $fullName = implode(' ', $vals);
                    $userRepository = app(UserMetaRepository::class);
                    $userMetas = $userRepository->findWhere(['user_id' => $item->manager_id]);
                    foreach($userMetas as $item) {
                        if($item->meta_key === 'first_name') {
                            $item->meta_value = $vals[0];
                        }

                        if($item->meta_key === 'last_name') {
                            $item->meta_value = $vals[1];
                        }

                        if($item->meta_key === 'full_name') {
                            $item->meta_value = $fullName;
                        }

                        $item->save();
                    }
                    break;
            }
        }

        return responseData(true);
    }
}
