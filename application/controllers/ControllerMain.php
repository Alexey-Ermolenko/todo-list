<?php

use application\models\Task;
use components\Helper;
use application\models\User;

class ControllerMain extends Controller
{
    public function setTemplate(): void
    {
        $this->view->setTemplateView('template_view.php');
    }

    public function actionIndex($params = null)
    {
        $limit = 4;
        $page = isset($params['page']) && is_numeric($params['page']) ? $params['page'] : 1;
        $calc_page = ($page - 1) * $limit;

        $total = Task::count();
        $tasks = Task::findAll($params['order'], $params['sort'], $calc_page, $limit);

        $this->view->generate('main/index.php', [
            'tasks' => $tasks,
            'page' => $page,
            'count' => $total,
            'limit' => $limit
        ]);
    }

    /**
     * @param $id
     */
    public function actionEdit($id)
    {
        $statusList = Task::getStatusList();
        $userList = Task::getUserList();
        $saved = false;

        if ($id && !$_POST) {
            $task = Task::findOne($id);
        } else {
            $task = Task::findOne((int)$_POST['id']);
            $this->setSaveParams($task);

            if (Controller::isAuth() && $task->save()) {
                $saved = true;
            } else {
                $GLOBALS['app']->errorPage(403);
            }
        }

        $this->view->generate('main/edit.php', [
            'task' => $task,
            'statusList' => $statusList,
            'userList' => $userList,
            'saved' => $saved,
        ]);
    }

    public function actionDel($id)
    {
        if (Controller::isAuth()) {
            Task::delete($id);
        } else {
            $GLOBALS['app']->errorPage(403);
        }
    }

    public function actionAdd()
    {
        $statusList = Task::getStatusList();
        $userList = Task::getUserList();
        $saved = false;

        if ($_POST) {
            $task = new Task();
            $this->setSaveParams($task);

            if (Controller::isAuth() && $task->save()) {
                $saved = true;
            } else {
                $GLOBALS['app']->errorPage(403);
            }
        }

        $this->view->generate('main/add.php', [
            'statusList' => $statusList,
            'userList' => $userList,
            'saved' => $saved,
        ]);
    }

    public function actionAbout()
    {
        $this->view->generate('main/about.php');
    }

    public function actionContacts()
    {
        $this->view->generate('main/contacts.php');
    }
    public function action403()
    {
        $this->view->generate('main/403.php');
    }
    public function action404()
    {
        $this->view->generate('main/404.php');
    }

    public function actionLogout()
    {
        User::toLogout();
        Helper::redirect('/main/index');
    }

    public function actionLogin()
    {
        $loginParams = [];

        if ($_POST['name'] && $_POST['pass']) {

            $loginParams['name'] = trim($_POST['name']);
            $loginParams['pass'] = trim($_POST['pass']);

            $user = new User($loginParams);
            if ($user->toLogin() === true) {
                Helper::redirect('/admin/index');
            } else {
                $GLOBALS['app']->errorPage(403);
            }
        } else {
            $this->view->generate('main/login.php');
        }
    }

    /**
     * @param Task $task
     */
    public function setSaveParams(Task $task): void
    {
        if (trim(htmlspecialchars($_POST['name']))) {
            $task->setName(trim(htmlspecialchars($_POST['name'])));
        }

        if (trim(htmlspecialchars($_POST['email']))) {
            $task->setEmail(trim(htmlspecialchars($_POST['email'])));
        }

        if (trim(htmlspecialchars($_POST['text']))) {
            $task->setText(trim(htmlspecialchars($_POST['text'])));
        }

        if ((int)$_POST['status']) {
            $task->setStatus((int)$_POST['status']);
        }

        if ((int)$_POST['user']) {
            $task->setUser((int)$_POST['user']);
        }
    }
}
