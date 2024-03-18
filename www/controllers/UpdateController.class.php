<?php

namespace Controller;


class UpdateController extends \_Controller{
	
	public function action_index()
	{
		include 'db_update.php';
		$this->redirect('/');
	}
	
}