<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToUser;

class Goods extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'name', 'goods_category_id'];
}
