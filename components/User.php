<?php

namespace components;


class User
{
    /** @var AuthManager $authManager */
    private $authManager;

    /** @var \Aura\Auth\Auth $auth */
    private $auth;

    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
        $this->auth = $this->authManager->authFactory->newInstance();
    }

    public function resumeSession(): void
    {
        $this->authManager->resumeService->resume($this->auth);
    }

    public function login(string $username, string $password): void
    {
        $this->authManager->loginService->login($this->auth, ['username' => $username, 'password' => $password]);
    }

    public function logout(): void
    {
        $this->authManager->logoutService->logout($this->auth);
    }

    public function isAdmin(): bool
    {
        return 'admin' === $this->auth->getUserName();
    }
}