<?php

class Login extends Controller {

	function Login()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$data['title'] = 'Title';
		$data['content'] = 'Content';
		$data['logged_in'] = true;
		$data['username'] = 'Rayman';
		$this->template->load('template', null, $data);
	}
}
