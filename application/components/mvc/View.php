<?php
namespace Application\components\mvc\View;

class View
{
    public string $templateView = 'template_view.php';

    /**
     * @return string
     */
    public function getTemplateView(): string
    {
        return $this->templateView;
    }

    /**
     * @param string $templateView
     */
    public function setTemplateView(string $templateView): void
    {
        $this->templateView = $templateView;
    }

    /**
     * @param      $contentView - виды отображающие контент страниц;
     * @param null $data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
     */
    function generate($contentView, $data = null) {
        if (is_array($data)) {
            extract($data);
        }

        include 'application/views/' . $this->getTemplateView();
    }
}
