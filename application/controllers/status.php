<?php

class Status extends Controller {

	var $data;

  function Status()
  {
    parent::Controller();
    
    $this->data = $this->Users->getData();
  }

  function index()
  {
		$this->data['title'] = 'Status';
		$this->template->load('template', array('content' => 'status/index'), $this->data);
  }
}
