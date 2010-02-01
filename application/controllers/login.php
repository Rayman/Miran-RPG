<?php

class Login extends Controller {

	function Login()
	{
		parent::Controller();
		$this->load->helper('url');

		//Redirect if logged in
		if($this->liblogin->logged_in()){redirect('status');}
	}
	
	function index()
	{
		$data['title'] = 'Login';
		$data['logged_in'] = false;
		$this->template->load('template', array('content' => 'login/index.php'), $data);
	}

  function submit()
  {
    $email    = $this->input->post('email');
    $password = $this->input->post('pass');

    if($this->liblogin->check_email($email))
    {
      if($this->liblogin->login($email, $password))
      {
        redirect('status');
      }
      else
      {
        $this->session->set_flashdata('message', '<p>Wrong password</p>');
        redirect('login');
      }
    }
    else
    {
      $this->session->set_flashdata('message', '<p>Unknown email address</p>');
      redirect('login');
    }
  }
}
