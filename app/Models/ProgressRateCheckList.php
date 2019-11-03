<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class ProgressRateCheckList extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'region_id',
        'district_id',
        'school_id',
        'teacher_computer',
        'student_computer',
        'quantity_teacher_desk',
        'quantity_student_desk',
        'size_ecc_length',
        'size_ecc_width',
        'power_socket_l',
        'power_socket_r',
        'power_socket_f',
        'power_socket_b',
        'circuit_breaker',
        'internet',
        'remark'
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
}
