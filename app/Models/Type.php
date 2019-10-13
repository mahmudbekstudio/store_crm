<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    use BelongsToUser;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'status', 'name', 'type', 'has_parent', 'child_of'];

    /**
     * Metas
     *
     * @return HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(TypeMeta::class);
    }

    /**
     * Child of category only for post type
     *
     * @return BelongsTo
     */
    public function childOf(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id', 'child_of');
    }
}
