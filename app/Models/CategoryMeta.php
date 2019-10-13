<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use App\Models\Traits\FormatValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryMeta extends Model
{
    use
        BelongsToUser,
        FormatValue;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'parent_id', 'meta_format', 'meta_key', 'meta_value', 'lang'];

    /**
     * Parent
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id', 'parent_id');
    }
}
