<?php

namespace App\Repositories\Traits;

trait Vars
{
    /**
     * All saved vars
     *
     * @var array
     */
    private $_vars = [];

    /**
     * Set var item
     *
     * @param string $key
     * @param $val
     */
    public function setVar(string $key, $val): void
    {
        $this->_vars[$key] = $val;
    }

    /**
     * Get var item
     *
     * @param string $key
     * @param mixed $defaultVal
     * @return mixed
     */
    public function getVar(string $key, $defaultVal = null)
    {
        return $this->hasVar($key) ? $this->_vars[$key] : $defaultVal;
    }

    /**
     * Check existing var item
     *
     * @param string $key
     * @return bool
     */
    public function hasVar(string $key): bool
    {
        return isset($this->_vars[$key]);
    }
}
