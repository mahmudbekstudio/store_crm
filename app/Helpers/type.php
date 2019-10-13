<?php
if(!function_exists('isPost')) {
    /**
     * Check post type by route name
     *
     * @param string $routeName
     * @return bool
     */
    function isPost(string $routeName): bool
    {
        return getRouteType($routeName)->type == 'post';
    }
}

if(!function_exists('isCategory')) {
    /**
     * Check category type by route name
     *
     * @param string $routeName
     * @return bool
     */
    function isCategory(string $routeName): bool
    {
        return getRouteType($routeName)->type == 'category';
    }
}

if(!function_exists('getRouteType')) {
    /**
     * Get type by route name
     *
     * @param string $name
     * @return \App\Models\Type
     */
    function getRouteType(string $name): \App\Models\Type
    {
        // TODO: add to cache
        $routeRepository = app(\App\Repositories\RouteRepository::class);
        return $routeRepository->getTypeByName($name);
    }
}
