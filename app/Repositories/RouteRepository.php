<?php

namespace App\Repositories;

use App\Models\Route;
use App\Models\Type;

class RouteRepository extends AbstractRepository
{
    /**
     * Save routes for performance
     *
     * @var array
     */
    public static $routes = [];

    /**
     * Model
     *
     * @return string
     */
    function model()
    {
        return "App\\Models\\Route";
    }

    /**
     * Type by name
     *
     * @param string $name
     * @return Type
     */
    public function getTypeByName(string $name): Type
    {
        return $this->getRouteByName($name)->type;
    }

    public function getRouteByName(string $name): Route
    {
        $route = $this->getRouteFromCache($name);

        if(!$route) {
            $route = $this->findByField('name', $name)->first();
            $this->setRouteToCache($name, $route);
        }

        return $route;
    }

    /**
     * Get from cache
     *
     * @param string $name
     * @return bool|mixed
     */
    private function getRouteFromCache(string $name)
    {
        return isset(self::$routes[$name]) ? self::$routes[$name] : false;
    }

    /**
     * Save to cache
     *
     * @param string $name
     * @param Route $route
     */
    private function setRouteToCache(string $name, Route $route)
    {
        self::$routes[$name] = $route;
    }
}
