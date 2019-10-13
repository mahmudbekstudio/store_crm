<?php

namespace App\Models;

use App\Models\Traits\BelongsToType;
use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use
        BelongsToUser,
        BelongsToType;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'type_id', 'name'];
}
