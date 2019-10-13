<?php

namespace App\Repositories\Traits;

trait RemoveAllTrait
{
    /**
     * Remove all
     *
     * @return int
     */
    public function removeAll(): int
    {
        return $this->deleteWhere([]);
    }
}