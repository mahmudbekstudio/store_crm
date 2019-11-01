<?php

namespace App\Imports;

use App\Repositories\DistrictRepository;
use App\Repositories\ProgressRateRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SchoolRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProgressRateSecondSheetImport implements ToCollection
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
        $progressRateRepository = app(ProgressRateRepository::class);
        $lastDistrict = '';

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

            $progressRateRepository->create([
                'user_id' => auth()->user()->id,
                'region_id' => $region->id,
                'district_id' => $district->id,
                'school_id' => $school->id,
                'teacher_computer' => $item[3] ?? '',
                'student_computer' => $item[4] ?? '',
                'survey' => $item[5] ?? '',
                'out_wh' => $item[6] ?? '',
                'site_arrival_inspection' => $item[7] ?? '',
                'installation' => $item[8] ?? '',
                'oat_training' => $item[9] ?? '',
                'oac' => $item[10] ?? '',
                'mac' => $item[11] ?? '',
                'warranty_completion' => $item[12] ?? '',
                //- installed_quantity_ecc
                //- installed_quantity_pc
                'remark' => $item[15] ?? ''
            ]);
        }
    }
}
