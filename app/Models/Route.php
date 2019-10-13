<?php

namespace App\Models;

use App\Models\Traits\BelongsToType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Route extends Model
{
    use BelongsToType;

    /**
     * @var array
     */
    protected $fillable = ['parent_id', 'name', 'type_id'];

    /**
     * Parent post
     *
     * @return BelongsTo
     */
    public function parentPost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_id', 'id');
    }

    /**
     * Parent category
     *
     * @return BelongsTo
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    /**
     * Type
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
}
