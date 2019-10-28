<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToUser;

class School extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'district_id', 'name'];

    public function district() {
        return $this->hasOne(Region::class, 'id', 'district_id');
    }
}
