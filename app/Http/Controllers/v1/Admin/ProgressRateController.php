<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgressRateCheckList;
use App\Models\UserMeta;
use App\Repositories\DefectRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\ProgressRateCheckListRepository;
use App\Repositories\ProgressRateRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\UserMetaRepository;
use Illuminate\Http\Request;

class ProgressRateController extends Controller
{
    private $progressRateRepository;
    private $progressRateCheckListRepository;

    public function __construct(
        ProgressRateRepository $progressRateRepository,
        ProgressRateCheckListRepository $progressRateCheckListRepository
    )
    {
        $this->progressRateRepository = $progressRateRepository;
        $this->progressRateCheckListRepository = $progressRateCheckListRepository;
    }

    public function checkList()
    {
        $checkList = $this->progressRateCheckListRepository->with(['region', 'district', 'school'])->all()->toArray();
        $list = [];

        foreach ($checkList as $item) {
            $list[] = [
                'id' => $item['id'],
                'region' => $item['region']['name'],
                'district' => $item['district']['name'],
                'school' => $item['school']['name'],
                'teacher_computer' => $item['teacher_computer'],
                'student_computer' => $item['student_computer'],
                'quantity_teacher_desk' => $item['quantity_teacher_desk'],
                'quantity_student_desk' => $item['quantity_student_desk'],
                'size_ecc_length' => $item['size_ecc_length'],
                'size_ecc_width' => $item['size_ecc_width'],
                'power_socket_l' => $item['power_socket_l'],
                'power_socket_r' => $item['power_socket_r'],
                'power_socket_f' => $item['power_socket_f'],
                'power_socket_b' => $item['power_socket_b'],
                'circuit_breaker' => $item['circuit_breaker'],
                'internet' => $item['internet'],
                'remark' => $item['remark']
            ];
        }

        return responseData(true, ['list' => $list]);
    }

    public function detail()
    {
        $details = $this->progressRateRepository->with(['region', 'district', 'school'])->all()->toArray();
        $list = [];

        foreach ($details as $item) {
            $installedQuantityEcc = empty($item['mac']) ? 0 : 1;
            $installedQuantityPc = ((int)$item['teacher_computer'] + (int)$item['student_computer']) * $installedQuantityEcc;
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
        $details = $this->progressRateRepository->with(['region', 'district', 'school'])->all()->toArray();
        $list = [];
        $region = '';
        $teachersComputer = 0;
        $studentComputer = 0;
        $survey = 0;
        $outWh = 0;
        $site_arrival_inspection = 0;
        $oat_training = 0;
        $oac = 0;
        $mac = 0;
        $warranty_completion = 0;
        $installed_quantity_pc = 0;

        foreach ($details as $item) {
            /*$installedQuantityEcc = empty($item['mac']) ? 0 : 1;
            $installedQuantityPc = ($item['teacher_computer'] + $item['student_computer']) * $installedQuantityEcc;*/
            if ($region == '') {
                $region = $item['region']['name'];
            }

            if ($region != $item['region']['name']) {
                $list[] = [
                    'id' => $item['region']['id'],
                    'region' => $region,
                    'teacher_computer' => $teachersComputer,
                    'student_computer' => $studentComputer,
                    'total_pc' => ($teachersComputer + $studentComputer),
                    'survey' => $survey,
                    'out_wh' => $outWh,
                    'site_arrival_inspection' => $site_arrival_inspection,
                    'oat_training' => $oat_training,
                    'oac' => $oac,
                    'mac' => $mac,
                    'warranty_completion' => $warranty_completion,
                    'installed_quantity_ecc' => $mac,
                    'installed_quantity_pc' => $installed_quantity_pc,
                    'progress_rate_ecc' => (round($mac / $teachersComputer * 10000) / 100) . '%',
                    'progress_rate_pc' => (round($installed_quantity_pc / ($teachersComputer + $studentComputer) * 10000) / 100) . '%'
                ];

                $teachersComputer = 0;
                $studentComputer = 0;
                $survey = 0;
                $outWh = 0;
                $site_arrival_inspection = 0;
                $oat_training = 0;
                $oac = 0;
                $mac = 0;
                $warranty_completion = 0;
                $installed_quantity_pc = 0;
                $region = $item['region']['name'];
            }

            if (!empty($item['teacher_computer'])) {
                $teachersComputer += (int)$item['teacher_computer'];
            }

            if (!empty($item['student_computer'])) {
                $studentComputer += (int)$item['student_computer'];
            }

            if (!empty($item['teacher_computer']) && !empty($item['student_computer']) && !empty($item['mac'])) {
                $installed_quantity_pc += $item['teacher_computer'] + $item['student_computer'];
            }

            if (!empty($item['survey'])) {
                $survey++;
            }

            if (!empty($item['out_wh'])) {
                $outWh++;
            }

            if (!empty($item['site_arrival_inspection'])) {
                $site_arrival_inspection++;
            }

            if (!empty($item['oat_training'])) {
                $oat_training++;
            }

            if (!empty($item['oac'])) {
                $oac++;
            }

            if (!empty($item['mac'])) {
                $mac++;
            }

            if (!empty($item['warranty_completion'])) {
                $warranty_completion++;
            }
        }

        return responseData(true, ['list' => $list]);
    }

    public function changeField(Request $request)
    {
        $data = $request->only(['id', 'key', 'val']);

        if (count($data) == 3) {
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

    public function changeFieldCheckList(Request $request)
    {
        $data = $request->only(['id', 'key', 'val']);

        if (count($data) == 3) {
            $item = $this->progressRateCheckListRepository->find($data['id']);

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


                case 'quantity_teacher_desk':
                    $item->quantity_teacher_desk = $data['val'];
                    $item->save();
                    break;
                case 'quantity_student_desk':
                    $item->quantity_student_desk = $data['val'];
                    $item->save();
                    break;
                case 'size_ecc_length':
                    $item->size_ecc_length = $data['val'];
                    $item->save();
                    break;
                case 'size_ecc_width':
                    $item->size_ecc_width = $data['val'];
                    $item->save();
                    break;
                case 'power_socket_l':
                    $item->power_socket_l = $data['val'];
                    $item->save();
                    break;
                case 'power_socket_r':
                    $item->power_socket_r = $data['val'];
                    $item->save();
                    break;
                case 'power_socket_f':
                    $item->power_socket_f = $data['val'];
                    $item->save();
                    break;
                case 'power_socket_b':
                    $item->power_socket_b = $data['val'];
                    $item->save();
                    break;
                case 'circuit_breaker':
                    $item->circuit_breaker = $data['val'];
                    $item->save();
                    break;
                case 'internet':
                    $item->internet = $data['val'];
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
