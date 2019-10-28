<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Defect extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'date',
        'region_id',
        'district_id',
        'school_id',
        'from_user_id',
        'received_user_id',
        'goods1_id',
        'goods2_id',
        'goods3_id',
        'goods4_id',
        'goods5_id',
        'goods6_id',
        'goods7_id',
        'comment',
        'replacement_of_part',
        'recovery',
        'replacement_of_pc',
        'date_of_done',
        'manager_id'
    ];

    public function region() {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    public function district() {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    public function school() {
        return $this->hasOne(School::class, 'id', 'school_id');
    }

    public function from_user() {
        return $this->hasOne(User::class, 'id', 'from_user_id');
    }

    public function received_user() {
        return $this->hasOne(User::class, 'id', 'received_user_id');
    }

    public function manager() {
        return $this->hasOne(User::class, 'id', 'manager_id');
    }
}
