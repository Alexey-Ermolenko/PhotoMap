<?php

class ControllerContacts extends Controller
{
    public function actionIndex()
	{
		$this->view->generate('contacts.php', 'template_view.php');
	}
}
