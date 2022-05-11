<?php

namespace application\components\mvc\Router;

use components\Helper;
use ControllerMain;

class Route
{
    private array $config;
    private $controller;
    private $action;
    private $params;

    public function __construct($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return $this
     */
    public function init(): Route
    {
        $controllerName = 'Main';
        $actionName = 'index';
        $params = null;

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controllerName = $routes[1];
        }

        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }

        if (!empty($routes[3])) {
            $params = parse_url($routes[3]);

            if ($params['query'] && $params['query'] !== '') {
                parse_str($params['query'], $params);
            } else if ($params['path'] && $params['path'] !== '') {
                $params = $params['path'];
            }
        }

        $modelName = 'Model' . ucfirst($controllerName);
        $controllerName = 'Controller' . ucfirst($controllerName);
        $actionName = 'action' . ucfirst($actionName);

        $modelFile = ucfirst($modelName) . '.php';

        if (file_exists("application/models/" . $modelFile)) {
            include "application/models/" . $modelFile;
        }

        $controllerFile = $controllerName . '.php';

        if (file_exists("application/controllers/" . $controllerFile)) {
            include "application/controllers/" . $controllerFile;
        } else {
            $this->errorPage(404);
        }

        $controller = new $controllerName($this->config);
        $action = $actionName;

        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;

        return $this;
    }

    public function run() {
        $controller = $this->controller;
        $action = $this->action;

        if (method_exists($controller, $action)) {
            if (array_search('auth', $controller->filters) !== false) {
                if ($controller::isAuth() === true) {
                    $controller->$action($this->params);
                } else {
                    $this->errorPage(403);
                }
            } else {
                $controller->$action($this->params);
            }
        } else {
            $this->errorPage(404);
        }
    }

    public function errorPage($error)
    {
        Helper::redirect('/main/' . $error);
    }
}
