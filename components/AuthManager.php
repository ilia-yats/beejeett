<?php

namespace components;

use \Aura\Auth\AuthFactory;
use Aura\Auth\Verifier\PasswordVerifier;

class AuthManager
{
    public $authFactory;
    public $loginService;
    public $logoutService;
    public $resumeService;

    public function __construct($pdo)
    {
        $this->authFactory = new AuthFactory($_COOKIE);
        $hash = new PasswordVerifier('md5');
        $cols = ['username', 'password'];
        $from = 'users';
        $adapter = $this->authFactory->newPdoAdapter($pdo, $hash, $cols, $from);

        $this->loginService = $this->authFactory->newLoginService($adapter);
        $this->logoutService = $this->authFactory->newLogoutService($adapter);
        $this->resumeService = $this->authFactory->newResumeService($adapter);
    }
}