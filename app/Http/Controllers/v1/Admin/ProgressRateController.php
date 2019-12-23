<?php

namespace App\Http\Controllers\v1\Admin;

use App\Helpers\DataFormat;
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

        $k = 0;
        foreach ($checkList as $item) {
            $k++;
            $list[] = [
                'id' => $item['id'],
                'no' => $k,
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
        $columns = getSetting('progress-rate-detail-columns');
        $firstItem = ['id' => 0];

        foreach($columns as $item) {
            $firstItem[$item->value] = $item->text;
        }

        $list[] = $firstItem;

        $k = 0;

        foreach ($details as $item) {
            $k++;
            $installedQuantityEcc = empty($item['oac']) ? 0 : 1;
            $installedQuantityPc = ((int)$item['teacher_computer'] + (int)$item['student_computer']) * $installedQuantityEcc;
            $list[] = [
                'id' => $item['id'],
                'no' => $k,
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

        return responseData(true, ['list' => $list, 'columns' => $columns]);
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
        $k = 0;
        $kk = 0;
        $detailsCount = count($details);

        foreach ($details as $item) {
            $kk++;
            /*$installedQuantityEcc = empty($item['mac']) ? 0 : 1;
            $installedQuantityPc = ($item['teacher_computer'] + $item['student_computer']) * $installedQuantityEcc;*/
            if ($region == '') {
                $region = $item['region']['name'];
            }

            if ($region != $item['region']['name'] || $kk == $detailsCount) {
                $k++;
                $list[] = [
                    'id' => $item['region']['id'],
                    'no' => $k,
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
                    'installed_quantity_ecc' => $oac,
                    'installed_quantity_pc' => $installed_quantity_pc,
                    'progress_rate_ecc' => (round($oac / $teachersComputer * 10000) / 100) . '%',
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

            if (!empty($item['teacher_computer']) && !empty($item['student_computer']) && !empty($item['oac'])) {
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

        return responseData(true, ['list' => $list, 'columns' => getSetting('progress-rate-detail-columns')]);
    }

    public function changeField(Request $request)
    {
        $data = $request->only(['id', 'key', 'val']);

        if (count($data) == 3) {
            if($data['id'] == 0) {
                $columns = getSetting('progress-rate-detail-columns');
                foreach($columns as $key => $item) {
                    if($item->value == $data['key']) {
                        $columns[$key]->text = $data['val'];
                        setSetting(auth()->user()->id, 'progress-rate-detail-columns', $columns, DataFormat::FORMAT_JSON);
                        break;
                    }
                }
                return responseData(true);
            }
            $item = $this->progressRateRepository->find($data['id']);

            switch ($data['key']) {
                case 'region':
                    $regionRepository = app(RegionRepository::class);
                    $region = $regionRepository->find($item->region_id);

                    if(count($this->progressRateRepository->findWhere(['region_id' => $item->region_id])->toArray()) > 1) {
                        $region = $regionRepository->withUser()->firstOrCreate([
                            'name' => $data['val']
                        ]);
                        $item->region_id = $region->id;
                        $item->save();
                    } else {
                        $region->name = $data['val'];
                        $region->save();
                    }
                    break;
                case 'district':
                    $districtRepository = app(DistrictRepository::class);
                    $district = $districtRepository->find($item->district_id);

                    if(count($this->progressRateRepository->findWhere(['district_id' => $item->district_id])->toArray()) > 1) {
                        $region = $districtRepository->withUser()->firstOrCreate([
                            'region_id' => $district->region_id,
                            'name' => $data['val']
                        ]);
                        $item->district_id = $region->id;
                        $item->save();
                    } else {
                        $district->name = $data['val'];
                        $district->save();
                    }
                    break;
                case 'school':
                    $schoolRepository = app(SchoolRepository::class);
                    $school = $schoolRepository->find($item->school_id);

                    if(count($this->progressRateRepository->findWhere(['school_id' => $item->school_id])->toArray()) > 1) {
                        $region = $schoolRepository->withUser()->firstOrCreate([
                            'district_id' => $school->district_id,
                            'name' => $data['val']
                        ]);
                        $item->school_id = $region->id;
                        $item->save();
                    } else {
                        $school->name = $data['val'];
                        $school->save();
                    }
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

        return responseData(true, ['columns' => getSetting('progress-rate-detail-columns')]);
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

    public function addRecord(Request $request)
    {
        $data = $request->only(['list']);
        $regionRepository = app(RegionRepository::class);
        $districtRepository = app(DistrictRepository::class);
        $schoolRepository = app(SchoolRepository::class);
        $progressRateRepository = app(ProgressRateRepository::class);

        //region_id
        $region = $regionRepository->firstOrCreate(['name' => $data['list'][0]['value']]);

        //district_id
        $district = $districtRepository->firstOrCreate(['region_id' => $region->id, 'name' => $data['list'][1]['value']]);

        //school_id
        $school = $schoolRepository->firstOrCreate(['district_id' => $district->id, 'name' => $data['list'][2]['value']]);

        $progressRateRepository->create([
            'user_id' => auth()->user()->id,
            'region_id' => $region->id,
            'district_id' => $district->id,
            'school_id' => $school->id,
            'teacher_computer' => $data['list'][3]['value'] ?? '',
            'student_computer' => $data['list'][4]['value'] ?? '',
            'survey' => $data['list'][5]['value'] ?? '',
            'out_wh' => $data['list'][6]['value'] ?? '',
            'site_arrival_inspection' => $data['list'][7]['value'] ?? '',
            'installation' => $data['list'][8]['value'] ?? '',
            'oat_training' => $data['list'][9]['value'] ?? '',
            'oac' => $data['list'][10]['value'] ?? '',
            'mac' => $data['list'][11]['value'] ?? '',
            'warranty_completion' => $data['list'][12]['value'] ?? '',
            //- installed_quantity_ecc
            //- installed_quantity_pc
            'remark' => $data['list'][13]['value'] ?? ''
        ]);
        return responseData(true, ['columns' => getSetting('progress-rate-detail-columns')]);
    }

    public function addRecordCheckList(Request $request)
    {
        $data = $request->only(['list']);
        $regionRepository = app(RegionRepository::class);
        $districtRepository = app(DistrictRepository::class);
        $schoolRepository = app(SchoolRepository::class);
        $progressRateCheckListRepository = app(ProgressRateCheckListRepository::class);

        //region_id
        $region = $regionRepository->firstOrCreate(['name' => $data['list'][0]['value']]);

        //district_id
        $district = $districtRepository->firstOrCreate(['region_id' => $region->id, 'name' => $data['list'][1]['value']]);

        //school_id
        $school = $schoolRepository->firstOrCreate(['district_id' => $district->id, 'name' => $data['list'][2]['value']]);

        $progressRateCheckListRepository->create([
            'user_id' => auth()->user()->id,
            'region_id' => $region->id,
            'district_id' => $district->id,
            'school_id' => $school->id,
            'teacher_computer' => $data['list'][3]['value'] ?? '',
            'student_computer' => $data['list'][4]['value'] ?? '',
            'quantity_teacher_desk' => $data['list'][5]['value'] ?? '',
            'quantity_student_desk' => $data['list'][6]['value'] ?? '',
            'size_ecc_length' => $data['list'][7]['value'] ?? '',
            'size_ecc_width' => $data['list'][8]['value'] ?? '',
            'power_socket_l' => $data['list'][9]['value'] ?? '',
            'power_socket_r' => $data['list'][10]['value'] ?? '',
            'power_socket_f' => $data['list'][11]['value'] ?? '',
            'power_socket_b' => $data['list'][12]['value'] ?? '',
            'circuit_breaker' => $data['list'][13]['value'] ?? '',
            'internet' => $data['list'][14]['value'] ?? '',
            'remark' => $data['list'][15]['value'] ?? '',
        ]);
        return responseData(true);
    }
}
