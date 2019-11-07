<?php

namespace App\Repositories;

class DocumentRepository extends AbstractRepository
{
    function model()
    {
        return "App\\Models\\Document";
    }
}