<?php
use Application\components\DB\Database;

class ControllerAdmin extends Controller
{
    public function setTemplate(): void
    {
        $this->view->setTemplateView('template_admin_view.php');
    }

    public function setFilters() {
        $this->filters[] = 'auth';
    }

    public function actionIndex()
    {
        $sql = 'SELECT * FROM task';
        $params = [];
        $items = (new Database())->queryValues($sql, $params);

        $this->view->generate('admin/index.php', [
            'config' => $this->config,
            'items' => $items,
        ]);
    }
}
