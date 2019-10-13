<?php

namespace App\Repositories;

class UserPermissionRepository extends AbstractRepository
{
    function model()
    {
        return "App\\Models\\UserPermission";
    }
}