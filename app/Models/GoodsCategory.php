<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'name'];
}
