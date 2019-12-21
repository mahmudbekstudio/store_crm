<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'district_id', 'file', 'type_id'];

    public function region() {
        return $this->hasOne(DocumentRegion::class, 'id', 'district_id');
    }
}
