<?php

namespace App\Repositories;

class UserMetaRepository extends AbstractRepository
{
    function model()
    {
        return "App\\Models\\UserMeta";
    }

    public function getMetas($userId, $keys = [], $columns = ['*'])
    {
        return $this
            ->withUser($userId)
            ->findWhereIn('meta_key', $keys, $columns);
    }
}