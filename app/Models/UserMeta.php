<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use App\Models\Traits\FormatValue;
use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    use
        BelongsToUser,
        FormatValue;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'meta_format', 'meta_key', 'meta_value', 'lang'];
}
