<?php

namespace App\Models\Traits;

use App\Models\Type;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToType
{
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
