<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'district_id', 'file', 'type_id'];

    public function district() {
        return $this->hasOne(District::class, 'id', 'district_id');
    }
}
