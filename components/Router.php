<?php

namespace components;

use exceptions\RouteException;

class Router
{
    const ROUTE_PARAM = 'r';

    public $currentRoute;

    public $currentParams;

    public $defaultRoute;

    public function __construct($defaultRoute)
    {
        $this->defaultRoute = $defaultRoute;
    }

    public function resolveRequest(array $request): array
    {
        $this->currentRoute = $request[self::ROUTE_PARAM] ?? $this->defaultRoute;
        unset($request[self::ROUTE_PARAM]);
        $this->currentParams = $request;

        if (empty($this->currentRoute)) {
            throw new RouteException('Unknown route.');
        }

        // create controller instance
        [$controllerName, $actionName] = explode('/', $this->currentRoute);
        $controllerClass = '\\controllers\\' . ucfirst($controllerName) . 'Controller';
        $actionMethodName = 'action' . $actionName;
        $controller = new $controllerClass();

        if (!method_exists($controller, $actionMethodName)) {
            throw new RouteException('Unknown action.');
        }

        return [$controller, $actionMethodName, $this->currentParams];
    }

    public function createUrl(string $route, array $params = []): string
    {
        $params[self::ROUTE_PARAM] = $route;

        return '/?' . http_build_query($params);
    }

    public function complementUrl(array $params): string
    {
        return $this->createUrl($this->currentRoute, array_merge($this->currentParams, $params));
    }
}