<?php

use Illuminate\Database\Seeder;

class ProgressRateDetailColumnsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settingKey = 'progress-rate-detail-columns';

        if(!getSetting($settingKey)) {
            $columnsList = [
                [
                    'text' => 'No',
                    'align' => 'center',
                    'value' => 'no',
                    'width' => 50
                ],
                [
                    'text' => 'Region',
                    'align' => 'center',
                    'value' => 'region'
                ],
                [
                    'text' => 'District',
                    'align' => 'center',
                    'value' => 'district'
                ],
                [
                    'text' => 'School',
                    'align' => 'center',
                    'value' => 'school'
                ],
                [
                    'text' => 'T-PC',
                    'align' => 'center',
                    'value' => 'teacher_computer'
                ],
                [
                    'text' => 'S-PC',
                    'align' => 'center',
                    'value' => 'student_computer'
                ],
                [
                    'text' => 'Survey',
                    'align' => 'center',
                    'value' => 'survey'
                ],
                [
                    'text' => 'Site Arrived Inspection',
                    'align' => 'center',
                    'value' => 'site_arrival_inspection'
                ],
                [
                    'text' => 'Installation',
                    'align' => 'center',
                    'value' => 'installation'
                ],
                [
                    'text' => 'OAT/Training',
                    'align' => 'center',
                    'value' => 'oat_training'
                ],
                [
                    'text' => 'OAC',
                    'align' => 'center',
                    'value' => 'oac'
                ],
                [
                    'text' => 'MAC',
                    'align' => 'center',
                    'value' => 'mac'
                ],
                [
                    'text' => 'Warranty Completion',
                    'align' => 'center',
                    'value' => 'warranty_completion'
                ],
                [
                    'text' => 'ECC Done',
                    'align' => 'center',
                    'value' => 'installed_quantity_ecc'
                ],
                [
                    'text' => 'PC Done',
                    'align' => 'center',
                    'value' => 'installed_quantity_pc'
                ],
                [
                    'text' => 'Remark',
                    'align' => 'center',
                    'value' => 'remark'
                ]
            ];

            $user = \App\Models\User::first();
            setSetting($user->id, $settingKey, $columnsList, \App\Helpers\DataFormat::FORMAT_JSON);
        }
    }
}
