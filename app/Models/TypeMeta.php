<?php

namespace App\Models;

use App\Models\Traits\BelongsToType;
use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class TypeMeta extends Model
{
    use
        BelongsToUser,
        BelongsToType;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'type_id',
        'label', 'name', 'field_type', 'field_params', 'description', 'required', 'default_value', 'placeholder',
        'tab', 'active', 'ordering'
    ];
}
