<?php
if(!function_exists('utcTime')) {
    /**
     * @return int
     */
    function utcTime(): int
    {
        $time = time();
        return $time + date("Z", $time);
    }
}
