<?php

namespace App\Models;

use App\Models\Traits\BelongsToTemplate;
use App\Models\Traits\BelongsToType;
use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use
        BelongsToUser,
        BelongsToType,
        BelongsToTemplate;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'template_id', 'status', 'step', 'parent_id', 'type_id'];

    /**
     * List of metas
     *
     * @return HasMany
     */
    public function metas(): HasMany
    {
        return $this->hasMany(CategoryMeta::class, 'parent_id');
    }

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
