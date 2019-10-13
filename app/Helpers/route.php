<?php
if(!function_exists('validRoutesList')) {
    /**
     * Check routes list
     *
     * @param array $args
     * @return bool
     */
    function validRoutesList(array $args): bool
    {
        // TODO: add to cache
        // list routes if exist
        $routeRepository = app(\App\Repositories\RouteRepository::class);
        $parents = [];
        $argsCount = count($args);

        for($i = $argsCount - 1; $i >= 0; $i--) {
            $routeItem = $routeRepository->getRouteByName($args[$i]);
            if(!$routeItem) {
                return false;
            } elseif($argsCount === 1) {
                return true;
            }
            $typeItem = $routeItem->type;
            $parentItem = $typeItem->type === 'post' ? $routeItem->parentPost : $routeItem->parentCategory;

            $parents[] = array_merge($parentItem->toArray(), ['parent_type' => $typeItem->toArray()]);
        }

        // check routes item by children
        $parent = array_shift($parents);
        $parentsCount = count($parents);

        for($i = 0; $i < $parentsCount; $i++) {
            if($parent['parent_type']['has_parent'] == 1) {
                if($parents[$i]['parent_id'] != $parent['id']) {
                    return false;
                }
            } elseif($parent['parent_type']['child_of'] != 0) {
                if($parent['parent_type']['child_of'] != $parents[$i]['parent_type']['id']) {
                    return false;
                }
            } else {
                return false;
            }
        }

        return true;
    }
}
