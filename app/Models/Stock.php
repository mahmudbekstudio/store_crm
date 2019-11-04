<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'goods_id',
        'wh_no',
        'in_obj',
        'out_obj',
        'in_total',
        'out_total',
        'remark'
    ];

    public function goods() {
        return $this->hasOne(Goods::class, 'id', 'goods_id');
    }
}
