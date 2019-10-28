<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\DefectRepository;
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
}
