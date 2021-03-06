<?php

use application\components\mvc\interface\FilterInterface;
use application\components\mvc\view\View;
use application\components\mvc\model\Model;

class Controller implements FilterInterface
{
	public Model $model;
	public View $view;
	public $result;
    public array $config;
    protected string $template;

    public array $filters = [];
	
	function __construct($config) {
        $this->config = $config;
		$this->view = new View();
        $this->setTemplate();
        $this->setFilters();
	}

    public function setTemplate(): void
    {
        $this->view->setTemplateView('template_view.php');
    }

    /**
     * @return bool
     */
    public static function isAuth(): bool
    {
        if (isset($_SESSION['user']) === true) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function setFilters()
    {
        $this->filters[] = null;
    }
}
