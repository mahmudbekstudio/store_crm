<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserMeta;
use App\Repositories\DefectRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\ProgressRateRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\UserMetaRepository;
use Illuminate\Http\Request;

class ProgressRateController extends Controller
{
    private $progressRateRepository;

    public function __construct(
        ProgressRateRepository $progressRateRepository
    ) {
        $this->progressRateRepository = $progressRateRepository;
    }

    public function detail()
    {
        $details = $this->progressRateRepository->with(['region', 'district', 'school'])->all()->toArray();
        $list = [];

        foreach($details as $item) {
            $installedQuantityEcc = empty($item['mac']) ? 0 : 1;
            $installedQuantityPc = ($item['teacher_computer'] + $item['student_computer']) * $installedQuantityEcc;
            $list[] = [
                'id' => $item['id'],
                'region' => $item['region']['name'],
                'district' => $item['district']['name'],
                'school' => $item['school']['name'],
                'teacher_computer' => $item['teacher_computer'],
                'student_computer' => $item['student_computer'],
                'survey' => $item['survey'],
                'out_wh' => $item['out_wh'],
                'site_arrival_inspection' => $item['site_arrival_inspection'],
                'installation' => $item['installation'],
                'oat_training' => $item['oat_training'],
                'oac' => $item['oac'],
                'mac' => $item['mac'],
                'warranty_completion' => $item['warranty_completion'],
                'installed_quantity_ecc' => $installedQuantityEcc,//
                'installed_quantity_pc' => $installedQuantityPc,//
                'remark' => $item['remark']
            ];
        }

        return responseData(true, ['list' => $list]);
    }

    public function list()
    {
        /*$defects = $this->defectRepository->with(['region', 'district', 'school', 'from_user.metas', 'received_user.metas', 'manager.metas'])->all()->toArray();
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

        return responseData(true, ['list' => $list]);*/
    }

    public function changeField(Request $request)
    {
        $data = $request->only(['id', 'key', 'val']);

        if(count($data) == 3) {
            $item = $this->progressRateRepository->find($data['id']);

            switch ($data['key']) {
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
                case 'teacher_computer':
                    $item->teacher_computer = $data['val'];
                    $item->save();
                    break;
                case 'student_computer':
                    $item->student_computer = $data['val'];
                    $item->save();
                    break;
                case 'survey':
                    $item->survey = $data['val'];
                    $item->save();
                    break;
                case 'out_wh':
                    $item->out_wh = $data['val'];
                    $item->save();
                    break;
                case 'site_arrival_inspection':
                    $item->site_arrival_inspection = $data['val'];
                    $item->save();
                    break;
                case 'installation':
                    $item->installation = $data['val'];
                    $item->save();
                    break;
                case 'oat_training':
                    $item->oat_training = $data['val'];
                    $item->save();
                    break;
                case 'oac':
                    $item->oac = $data['val'];
                    $item->save();
                    break;
                case 'mac':
                    $item->mac = $data['val'];
                    $item->save();
                    break;
                case 'warranty_completion':
                    $item->warranty_completion = $data['val'];
                    $item->save();
                    break;
                case 'remark':
                    $item->remark = $data['val'];
                    $item->save();
                    break;
            }
        }

        return responseData(true);
    }
}
