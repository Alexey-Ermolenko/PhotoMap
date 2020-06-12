<?php

class Controller404 extends Controller
{
    public function actionIndex()
    {
        $this->view->generate('main/404.php', 'template_view.php');
    }
}
