<?php

class Registrations extends Model {

	function Registrations()
	{
		  parent::Model();
	}
	
	function check_username($username)
	{
		$username = trim($username);
    if(strlen($username) < 3)
    {
      return "Username too short";
    }
    if(strlen($username > 16))
    {
    	return "Username too long";
    }
    if ($this->liblogin->check_username($username))
    {
      return "That username is already taken";
    }
    return false;
	}
	
	function check_email($email)
	{
		$email = trim($email);
		if(strlen($email) > 320)
		{
			return "Email too long";
		}
		if(!$this->form_validation->valid_email($email))
    {
      return "Email not Valid";
    }
    if ($this->liblogin->check_email($email))
    {
      return "Email already taken";
    }
    return false;
  }
  
  function check_password($pass)
  {
  	if(strlen($pass) < 4)
  	{
  		return "Password too short";
  	}
  	return false;
  }
}
?>
