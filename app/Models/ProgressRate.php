<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class ProgressRate extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'region_id',
        'district_id',
        'school_id',
        'teacher_computer',
        'student_computer',
        'survey',
        'out_wh',
        'site_arrival_inspection',
        'installation',
        'oat_training',
        'oac',
        'mac',
        'warranty_completion',
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
