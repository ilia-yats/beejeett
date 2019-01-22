<?php

namespace controllers;

use Application;

abstract class Controller
{
    protected function render(string $viewName, array $variables = []): string
    {
        $view = Application::getInstance()->getView();

        return $view->render($this->getRelativeViewPath().'/'.$viewName.'.html', $variables);
    }

    protected function getRelativeViewPath(): string
    {
        $classNameParts = explode('\\', static::class);
        return strtolower(str_replace('Controller', '', end($classNameParts)));
    }

    protected function redirect(string $url): void
    {
        header("Location:".$url);
        exit();
    }
}