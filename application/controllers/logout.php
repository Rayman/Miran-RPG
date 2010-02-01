<?php

class Logout extends Controller {

  function Logout()
  {
    parent::Controller();
  }
  
  function index()
  {
    //Destroy session variables
    $this->liblogin->logout();
    
    //Display some nice stuff
    $data['title'] = "Logout";
 		$data['logged_in'] = false;
		$this->template->load('template', array('content' => 'logout/index'), $data);
  }
}

/* End of file logout.php */
