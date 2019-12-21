<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class DocumentRegion extends Model
{
    use BelongsToUser;

    protected $fillable = ['parent_id', 'type_id', 'name'];
}
