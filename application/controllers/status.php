<?php

class Status extends Controller {

  function Status()
  {
    parent::Controller();

    //Redirect if not logged in
    if(!$this->liblogin->logged_in()){redirect('login');}
  }

  function index()
  {
  	$data = $this->Users->getData();
		$data['title'] = 'Status';
		$this->template->load('template', array('content' => 'status/index'), $data);
  }

  function newuser()
  {
    // Validate all form data
    if ($this->_validate_form() == false)
    {
      $this->index();
    }
    else
    {
      $username = $this->input->post('username');
      $email    = $this->input->post('email');
      $password = $this->input->post('password');

      $register = $this->liblogin->register($username, $password, $email);

      if($register)
      {
        $this->session->set_flashdata('message', '<p class="success">You have now registered. Please login.</p>');
        redirect('register/result');
      }
      else
      {
        $this->session->set_flashdata('message', '<p class="error">Something went wrong, please try again or contact the helpdesk.</p>');
        redirect('register/result');
      }
    }
  }

  //Used for validating the post variables
  function _validate_form()
  {
    $this->form_validation->set_rules('username', 'Username',              'required|callback__username_check');
    $this->form_validation->set_rules('email',    'Email Address',         'required|callback__email_check');
    $this->form_validation->set_rules('password', 'Password',              'required|callback__password_check');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
    $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

    return $this->form_validation->run();
  }

  function _username_check($str)
  {
  	$error = $this->Registrations->check_username($str);
  	if($error)
  	{
  		$this->form_validation->set_message('_username_check', $error);
  		return false;
  	}
  	return true;
  }

  function _email_check($str)
  {
  	$error = $this->Registrations->check_email($str);  
    if($error)
    {
      $this->form_validation->set_message('_email_check', $error);
      return false;
    }
    return true;
  }
  
  function _password_check($str)
  {
  	$error = $this->Registrations->check_password($str);  
    if($error)
    {
      $this->form_validation->set_message('_password_check', $error);
      return false;
    }
    return true;
  }

  // Load the result page, the message is in a flash var
  function result()
  {    
    $data['title'] = 'Registration Result';
		$data['logged_in'] = false;
		$this->template->load('template', array('content' => 'register/result'), $data);
  }

  // Used for ajax calls
  // Returns OK or the error message
  function check()
  {
    //We dont need the result
    $this->_validate_form();

    if($this->input->post('username') !== false)
    {
      $message = form_error('username');
    }
    elseif($this->input->post('email') !== false)
    {
      $message = form_error('email');
    }
    elseif($this->input->post('password') !== false)
    {
      $message = form_error('password');
    }
    else
    {
      $message = "Error, no post variable set";
    }

    echo $message == "" ? "OK" : $message;
  }
}

/* End of file register.php */
