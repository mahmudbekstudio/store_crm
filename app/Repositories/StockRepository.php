<?php

namespace App\Repositories;

class StockRepository extends AbstractRepository
{
    function model()
    {
        return "App\\Models\\Stock";
    }
}