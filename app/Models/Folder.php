<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Folder extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'parent_id', 'name', 'path'];

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
