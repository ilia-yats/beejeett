<?php

use Aura\Sql\ExtendedPdo;
use components\{View, AuthManager, User, Router};
use controllers\Controller;
use exceptions\{RouteException, ConfigException};

class Application
{
    /** @var self */
    private static $instance;

    /** @var array $config */
    private $config = [];

    /** @var ExtendedPdo $pdo */
    private $pdo;

    /** @var Router $router */
    private $router;

    /** @var View $view */
    private $view;

    /** @var Controller $controller */
    private $controller;

    /** @var string $action */
    private $action;

    /** @var array $params */
    private $params;

    /** @var User $user */
    private $user;

    public static function getInstance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    public function run($config): void
    {
        $this->config = $config;

        $this->init();

        $this->runAction();
    }

    private function init(): void
    {
        $this->pdo = $this->createPdo();

        $this->user = new User(new AuthManager($this->getPdo()));

        $this->router = new Router($this->config['defaultRoute'] ?? '');

        [$this->controller, $this->action, $this->params] = $this->router->resolveRequest($_GET);

        $this->view = new View();
    }

    private function runAction(): void
    {
        //try {
            $this->user->resumeSession();

            echo $this->controller->{$this->action}($this->params);
        //} catch (\Exception $e) {
            // todo: error handler
        //}
    }

    private function createPdo(): ExtendedPdo
    {
        if (empty($this->config['dsn'])) {
            throw new ConfigException('App config must contain dsn for database connection.');
        }

        return new ExtendedPdo($this->config['dsn']);
    }

    /**
     * @return mixed
     */
    public function getView(): ?View
    {
        return $this->view;
    }

    /**
     * @return mixed
     */
    public function getController(): ?Controller
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction(): ?string
    {
        return $this->action;
    }

    public function getPdo(): ExtendedPdo
    {
        return $this->pdo;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}