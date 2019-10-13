<?php

namespace App\Repositories;

class PostRepository extends AbstractRepository
{
    function model()
    {
        return "App\\Models\\Post";
    }
}