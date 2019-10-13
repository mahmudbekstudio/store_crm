<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use BelongsToUser;
    
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'access_action', 'action_create', 'action_read', 'action_update', 'action_delete', 'only_own'];
}
