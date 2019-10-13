<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use BelongsToUser;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'meta_key', 'meta_value', 'meta_format', 'lang'];
}
