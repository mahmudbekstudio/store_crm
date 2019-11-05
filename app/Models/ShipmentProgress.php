<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class ShipmentProgress extends Model
{
    use BelongsToUser;

    protected $fillable = [
        'user_id',
        'sheet_no',
        'num',
        'goods_id',
        'contract',
        'shipment'
    ];

    public function goods() {
        return $this->hasOne(Goods::class, 'id', 'goods_id');
    }
}
