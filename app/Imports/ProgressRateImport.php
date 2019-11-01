<?php

namespace App\Imports;

use App\Models\Defect;
use App\Models\ProgressRate;
use App\Models\User;
use App\Models\UserMeta;
use App\Repositories\DefectRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\UserMetaRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProgressRateImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            null,
            new ProgressRateSecondSheetImport()
        ];
    }

    public function collection11(Collection $rows)
    {
        dd($rows);
        $rowsCount = count($rows);
        //print_R($rows->toArray());exit;
        /*$regionRepository = app(RegionRepository::class);
        $districtRepository = app(DistrictRepository::class);
        $schoolRepository = app(SchoolRepository::class);
        $userRepository = app(UserRepository::class);
        $userMetaRepository = app(UserMetaRepository::class);
        $defectRepository = app(DefectRepository::class);*/

        ProgressRate::where('id', 'like', '%%')->delete();

        for($i = 5; $i < $rowsCount; $i++) {
            $item = $rows[$i]->toArray();
            /*if(
                empty($item[1]) || empty($item[2]) || empty($item[3]) || empty($item[4]) || empty($item[5]) ||
                is_null($item[1]) || is_null($item[2]) || is_null($item[3]) || is_null($item[4]) || is_null($item[5])
            ) {
                break;
            }

            $date = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[1])->getTimestamp());
            $region = $regionRepository->firstOrCreate(['name' => $item[2]]);
            $district = $districtRepository->firstOrCreate(['region_id' => $region->id, 'name' => $item[3]]);
            $school = $schoolRepository->firstOrCreate(['district_id' => $district->id, 'name' => $item[4]]);
            $userMeta = UserMeta::where(['meta_key' => 'full_name', 'meta_value' => $item[5]])->first();
            if(!$userMeta) {
                $user = $userRepository->firstOrCreate(['status' => 1, 'email' => $item[5] . '@gmail.com', 'password' => '123456']);
                $userName = explode(' ', $item[5]);
                $userName[1] = $userName[1] ?? '';
                $userMetaRepository->firstOrCreate(['user_id' => $user->id, 'meta_format' => 'string', 'meta_key' => 'full_name', 'meta_value' => $item[5], 'lang' => 'en']);
                $userMetaRepository->firstOrCreate(['user_id' => $user->id, 'meta_format' => 'string', 'meta_key' => 'first_name', 'meta_value' => $userName[0], 'lang' => 'en']);
                $userMetaRepository->firstOrCreate(['user_id' => $user->id, 'meta_format' => 'string', 'meta_key' => 'last_name', 'meta_value' => $userName[1], 'lang' => 'en']);
                $userMetaRepository->firstOrCreate(['user_id' => $user->id, 'meta_format' => 'string', 'meta_key' => 'phone', 'meta_value' => $item[6], 'lang' => 'en']);
                $userId = $user->id;
            } else {
                $userId = $userMeta->user_id;
            }
            //$userName = $item[5];
            //$userPhone = $item[6];
            $receivedUserMeta = UserMeta::where(['meta_key' => 'full_name', 'meta_value' => $item[7]])->first();
            if(!$receivedUserMeta) {
                $user = $userRepository->firstOrCreate(['status' => 1, 'email' => $item[7] . '@gmail.com', 'password' => '123456']);
                $userName = explode(' ', $item[7]);
                $userName[1] = $userName[1] ?? '';
                $userMetaRepository->firstOrCreate(['user_id' => $user->id, 'meta_format' => 'string', 'meta_key' => 'full_name', 'meta_value' => $item[7], 'lang' => 'en']);
                $userMetaRepository->firstOrCreate(['user_id' => $user->id, 'meta_format' => 'string', 'meta_key' => 'first_name', 'meta_value' => $userName[0], 'lang' => 'en']);
                $userMetaRepository->firstOrCreate(['user_id' => $user->id, 'meta_format' => 'string', 'meta_key' => 'last_name', 'meta_value' => $userName[1], 'lang' => 'en']);
                $receivedUserId = $user->id;
            } else {
                $receivedUserId = $receivedUserMeta->user_id;
            }
            //$receivedUserName = $item[7];

            $product1 = !empty($item[8]);
            $product2 = !empty($item[9]);
            $product3 = !empty($item[10]);
            $product4 = !empty($item[11]);
            $product5 = !empty($item[12]);
            $product6 = !empty($item[13]);
            $product7 = !empty($item[14]);

            $comment = $item[15] ?? '';
            $replacementOfPart = !empty($item[16]);
            $recovery = !empty($item[17]);
            $replacementOfPc = !empty($item[18]);
            $dateOfDone = date("Y-m-d", \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item[19])->getTimestamp());


            if(empty($item[20]) || is_null($item[20])) {
                $managerUserId = 0;
            } else {
                $managerUserMeta = UserMeta::where(['meta_key' => 'full_name', 'meta_value' => $item[20]])->first();
                if(!$managerUserMeta) {
                    $user = $userRepository->firstOrCreate(['status' => 1, 'email' => $item[20] . '@gmail.com', 'password' => '123456', 'role' => 'manager']);
                    $userName = explode(' ', $item[20]);
                    $userName[1] = $userName[1] ?? '';
                    $userMetaRepository->firstOrCreate(['user_id' => $user->id, 'meta_format' => 'string', 'meta_key' => 'full_name', 'meta_value' => $item[20], 'lang' => 'en']);
                    $userMetaRepository->firstOrCreate(['user_id' => $user->id, 'meta_format' => 'string', 'meta_key' => 'first_name', 'meta_value' => $userName[0], 'lang' => 'en']);
                    $userMetaRepository->firstOrCreate(['user_id' => $user->id, 'meta_format' => 'string', 'meta_key' => 'last_name', 'meta_value' => $userName[1], 'lang' => 'en']);
                    $managerUserId = $user->id;
                } else {
                    $managerUserId = $managerUserMeta->user_id;
                }
            }
            //$manager = $item[20];

            $defectRepository->create([
                'user_id' => auth()->user()->id,
                'date' => $date,
                'region_id' => $region->id,
                'district_id' => $district->id,
                'school_id' => $school->id,
                'from_user_id' => $userId,
                'received_user_id' => $receivedUserId,
                'goods1_id' => $product1,
                'goods2_id' => $product2,
                'goods3_id' => $product3,
                'goods4_id' => $product4,
                'goods5_id' => $product5,
                'goods6_id' => $product6,
                'goods7_id' => $product7,
                'comment' => $comment,
                'replacement_of_part' => $replacementOfPart,
                'recovery' => $recovery,
                'replacement_of_pc' => $replacementOfPc,
                'date_of_done' => $dateOfDone,
                'manager_id' => $managerUserId
            ]);*/
        }
        /*foreach ($rows as $row)
        {
            User::create([
                'name' => $row[0],
            ]);
        }*/
    }
}
