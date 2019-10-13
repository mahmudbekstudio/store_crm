<?php

namespace App\Repositories;

class UserMetaRepository extends AbstractRepository
{
    function model()
    {
        return "App\\Models\\UserMeta";
    }

    public function getMetas($userId, $keys = [])
    {
        return $this
            ->withUser($userId)
            ->findWhereIn('meta_key', $keys, ['meta_key', 'meta_value']);
    }
}