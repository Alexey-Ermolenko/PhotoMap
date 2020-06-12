<?php

class View
{

    public $templateView = 'template_view.php';

    /**
     * @param      $contentView  - виды отображающие контент страниц;
     * @param      $templateView - общий для всех страниц шаблон;
     * @param null $data         - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
     */
    function generate($contentView, $templateView, $data = null)
    {
        if (is_array($data)) {
            // преобразуем элементы массива в переменные
            extract($data);
        }

        include 'application/views/' . $templateView;
    }
}
