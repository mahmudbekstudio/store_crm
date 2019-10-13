<?php

namespace App\Repositories;

use App\Repositories\Traits\StaticInstance;

class UserRepository extends AbstractRepository
{
    use StaticInstance;

    function model()
    {
        return "App\\Models\\User";
    }
}