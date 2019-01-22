<?php

namespace controllers;


use models\Task;
use Application;
use components\{Paginator, Sorter};

class TaskController extends Controller
{
    public function actionIndex($params)
    {
        $isAdmin = Application::getInstance()->getUser()->isAdmin();
        $router = Application::getInstance()->getRouter();

        $paginator = new Paginator(Task::getTotalCount(), $params, $router);
        $sorter = new Sorter(
            $params,
            ['email' => 'Email', 'title' => 'Title', 'author' => 'Author'],
            $router
        );

        $tasks = Task::getPage($paginator->getCurrentPage(), $sorter->getSortField(), $sorter->getSortOrder());

        return $this->render('index', [
            'tasks' => $tasks,
            'router' => $router,
            'isAdmin' => $isAdmin,
            'paginator' => $paginator,
            'sorter' => $sorter,
        ]);
    }

    public function actionCreate()
    {
        $task = new Task();
        if (!empty($_POST)) {
            $task->load($_POST);
            $task->insert();

            $this->redirect(Application::getInstance()->getRouter()->createUrl('task/index'));
        }

        $isAdmin = Application::getInstance()->getUser()->isAdmin();

        return $this->render('create', [
            'isAdmin' => $isAdmin,
            'task' => $task,
        ]);
    }

    public function actionUpdate($params)
    {
        $isAdmin = Application::getInstance()->getUser()->isAdmin();
        if (!$isAdmin) {
            die('access denied');
        }

        $id = $params['id'] ?? null;
        $task = Task::getOne($id);

        if (!empty($_POST)) {
            $task->load($_POST);
            $task->update();

            $this->redirect(Application::getInstance()->getRouter()->createUrl('task/index'));
        }

        return $this->render('update', [
            'task' => $task,
        ]);
    }
}