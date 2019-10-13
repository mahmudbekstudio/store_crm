<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use BelongsToUser;

    protected $fillable = ['user_id', 'folder_id', 'name', 'extension', 'size'];

    public function folder() {
        return $this->hasOne(Folder::class, 'id', 'folder_id');
    }
}
