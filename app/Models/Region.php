<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToUser;

class Region extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'name'];
}
