<?php
if (!function_exists('getSetting')) {
    /**
     * Get setting item value by key
     *
     * @param string $key
     * @param string $lang
     * @return mixed
     */
    function getSetting(string $key, string $lang = '')
    {
        return \App\Repositories\SettingRepository::getInstance()->getValue($key, $lang);
    }
}

if (!function_exists('setSetting')) {
    /**
     * Set setting item value by key
     *
     * @param int $userId
     * @param string $key
     * @param mixed $val
     * @param string $format
     * @param string $lang
     * @return mixed
     */
    function setSetting(int $userId, string $key, $val, string $format = '', string $lang = '')
    {
        return \App\Repositories\SettingRepository::getInstance()->setValue($userId, $key, $val, $format, $lang);
    }
}

if (!function_exists('getLang')) {
    /**
     * Get language code
     *
     * @param string $lang
     * @return string
     */
    function getLang(string $lang = ''): string
    {
        return isLang($lang) ? $lang : app()->getLocale();
    }
}

if (!function_exists('isLang')) {
    /**
     * Check language code
     *
     * @param string $lang
     * @return string
     */
    function isLang(string $lang = ''): string
    {
        return in_array($lang, config('app.locale_list'));
    }
}

