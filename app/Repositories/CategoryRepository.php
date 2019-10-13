<?php

namespace App\Repositories;

class CategoryRepository extends AbstractRepository
{
    function model()
    {
        return "App\\Models\\Category";
    }
}