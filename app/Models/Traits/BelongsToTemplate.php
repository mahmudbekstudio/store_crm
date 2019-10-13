<?php

namespace App\Models\Traits;

use App\Models\Template;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTemplate
{
    /**
     * Template
     *
     * @return BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }
}
