<?php

namespace App\Http\Controllers\v1\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MainController extends Controller
{
    /**
     * Route args
     *
     * @var array
     */
    private $args;

    /**
     * Current route name
     *
     * @var string
     */
    private $currentRouteName;

    /**
     * @var string
     */
    private $view = '';

    /**
     * Handle the incoming request.
     *
     * @return View
     */
    public function index()
    {
        $args = func_get_args();
        empty($args) || !isLang($args[0]) ?: app()->setLocale(array_shift($args));
        $this->args = $args;

        if(empty($this->args)) {
            return $this->getHomePage();
        }

        return validRoutesList($this->args) ? $this->getPageByRoute() : errorPageNotFound();
    }

    /**
     * Homepage response
     *
     * @return View
     */
    private function getHomePage(): View
    {
        return view($this->viewPagePath('home'));
    }

    /**
     * Return response by route
     *
     * @return View
     */
    private function getPageByRoute(): View
    {
        $this->currentRouteName = $this->args[count($this->args) - 1];
        $typeItem = getRouteType($this->currentRouteName);

        if(view()->exists($this->viewPagePath($typeItem->type . '-' . $typeItem->name))) {
            $this->view = $this->viewPagePath($typeItem->type . '-' . $typeItem->name);
        }

        return isCategory($this->currentRouteName) ? $this->getCategoryPage() : $this->getPostPage();
    }

    /**
     * Category page response
     *
     * @return View
     */
    private function getCategoryPage(): View
    {
        $view = $this->view ?: $this->viewPagePath('category');
        return view($view);
    }

    /**
     * Post page response
     *
     * @return View
     */
    private function getPostPage(): View
    {
        $view = $this->view ?: $this->viewPagePath('post');
        return view($view);
    }
}
