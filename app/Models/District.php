<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'name', 'region_id'];

    public function region() {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }
}
