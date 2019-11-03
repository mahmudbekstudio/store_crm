<?php

namespace App\Imports;

use App\Models\ProgressRateCheckList;
use App\Repositories\DistrictRepository;
use App\Repositories\ProgressRateCheckListRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SchoolRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProgressRateThirdSheetImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        //dd(count($rows));
        // dd($rows[2877]->toArray());
        $regionBottom = 'Sub-Total';// second column
        $totalBottom = 'Total';// first column
        $rowsCount = count($rows);
        $regionRepository = app(RegionRepository::class);
        $districtRepository = app(DistrictRepository::class);
        $schoolRepository = app(SchoolRepository::class);
        $progressRateCheckListRepository = app(ProgressRateCheckListRepository::class);
        $lastDistrict = '';

        ProgressRateCheckList::where('id', 'like', '%%')->delete();

        for($i = 4; $i < $rowsCount; $i++) {
            $item = $rows[$i]->toArray();
            if($item[0] == $totalBottom) {
                break;
            }

            if($item[1] == $regionBottom) {
                continue;
            }

            //region_id
            $region = $regionRepository->firstOrCreate(['name' => $item[0]]);

            $lastDistrict = $item[1] ?? $lastDistrict;

            //district_id
            $district = $districtRepository->firstOrCreate(['region_id' => $region->id, 'name' => $lastDistrict]);

            //school_id
            $school = $schoolRepository->firstOrCreate(['district_id' => $district->id, 'name' => $item[2]]);

            $progressRateCheckListRepository->create([
                'user_id' => auth()->user()->id,
                'region_id' => $region->id,
                'district_id' => $district->id,
                'school_id' => $school->id,
                'teacher_computer' => $item[3] ?? '',
                'student_computer' => $item[4] ?? '',
                'quantity_teacher_desk' => $item[5] ?? '',
                'quantity_student_desk' => $item[6] ?? '',
                'size_ecc_length' => $item[7] ?? '',
                'size_ecc_width' => $item[8] ?? '',
                'power_socket_l' => $item[9] ?? '',
                'power_socket_r' => $item[10] ?? '',
                'power_socket_f' => $item[11] ?? '',
                'power_socket_b' => $item[12] ?? '',
                'circuit_breaker' => $item[13] ?? '',
                'internet' => $item[14] ?? '',
                'remark' => $item[15] ?? '',
            ]);
        }
    }
}
