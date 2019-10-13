<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $request;
    protected $websiteView = 'pages.home.index';

    public function __construct()
    {
        /*$this->middleware(function ($request, $next) {
            $hasAccess = $this->hasAccess();
            $actionName = $this->actionName();
            $result = true;

            if(!empty($actionName) && !empty($hasAccess)) {
                $method = $request->route()->getActionMethod();
                $access = isset($hasAccess[$method]) ? $hasAccess[$method] : false;

                if($access && $access == '*') {
                    $result = false;
                } elseif($access) {
                    $permissionModel = new UserPermission();
                    $accessArr = explode('::', $access);

                    if(count($accessArr) > 1) {
                        $access = explode(',', $accessArr[1]);
                        $actionName = $accessArr[0];
                    } else {
                        $access = explode(',', $accessArr[0]);
                    }

                    $result = !$permissionModel->check($access, $actionName);
                }
            }

            if($result) {
                abort(403, 'Forbidden');
            }

            return $next($request);
        });*/
    }

    protected function actionName() {
        return '';//'main';
    }

    protected function hasAccess() {
        return [
            /*
            //'r_index' => '*',// all have access
            //'r_test' => 'website-settings::create,update',// only for access website-settings and actions create,update
            //'r_renameFolder' => 'update',
			//'r_moveFolder' => 'delete,create',
            'r_getLoginByToken' => '*',
            'r_login' => '*',
            'r_loginByLink' => '*',
            'r_logout' => '*',
            */
        ];
    }

    protected function configuration() {
        return [];
    }

    /**
     * Get pages template path
     *
     * @param string $name
     * @return string
     */
    protected function viewPagePath(string $name): string
    {
        return 'pages.' . $name . '.index';
    }

    /**
     * Get custom templates path
     *
     * @param string $name
     * @return string
     */
    protected function viewTemplatePath(string $name): string
    {
        return 'templates.' . $name . '.index';
    }
}
