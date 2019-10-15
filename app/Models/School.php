<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToUser;

class School extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'region_id', 'name'];

    public function region() {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }
}
