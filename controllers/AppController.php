<?php

namespace controllers;

use Application;
use Aura\Auth;
use helpers\Router;

class AppController extends Controller
{
    public function actionLogin()
    {
        if (!empty($_POST)) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = Application::getInstance()->getUser();
            try {
                $user->login($username, $password);

                $this->redirect(Application::getInstance()->getRouter()->createUrl('task/index'));

            } catch (Auth\Exception $e) {
                // do nothing in case of unsuccessful attempt to login
            }
        }

        return $this->render('login');
    }

    public function actionLogout()
    {
        $user = Application::getInstance()->getUser();
        $user->logout();
        $this->redirect(Application::getInstance()->getRouter()->createUrl('task/index'));
    }
}