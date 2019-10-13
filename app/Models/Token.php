<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use BelongsToUser;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'token', 'is_one_time', 'name', 'is_unique', 'expiration'];
}
