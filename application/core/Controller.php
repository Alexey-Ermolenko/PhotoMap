<?php

class Controller {
	
	public $model;
	public $view;
	public $result;
	
	function __construct()
	{
		$this->view = new View();
	}
	
	// действие (action), вызываемое по умолчанию
	function actionIndex()
	{
		// todo	
	}
}
