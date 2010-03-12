<?php

class Messages extends Controller {

	var $data;

  function Messages()
  {
    parent::Controller();
    
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->load->model('messaging');
    
    $this->data = $this->Users->getData();
  }

  function _load($view)
  {
		$this->template->load('template', array('content' => 'messages/'.$view), $this->data);
  }
  
  function inbox()
  {
  	$this->data['title'] = 'Inbox';
  	
  	$parsed = array();
  	$messages = $this->messaging->getMessages();
  	foreach($messages as $message)
  	{
  		$message->received	= $this->Users->timeago($message->received);
  		$message->sender_id	= $this->Users->printUsername($message->sender_id);
  		$parsed[] = $message;
  	}
  	
  	$this->data['messages'] = $parsed;
  	$this->_load('inbox');
  }
  
  function compose()
  {
    $this->data['title'] = 'Compose';
  	$this->_load('compose');
  }
  
  function send()
  {
    // Validate all form data
    if ($this->_validate_form() == false)
    {
      $this->compose();
    }
    else
    {
      $to				= $this->input->post('to');
      $subject	= $this->input->post('subject');
      $body			= $this->input->post('body');

			$to = $this->Users->findUser($to)->id;

      $success = $this->messaging->send($to, $subject, $body);
      if($success)
      {
        $this->session->set_flashdata('message', '<p class="success">Your message has been sent</p>');
        redirect('messages/inbox');
      }
      else
      {
        $this->session->set_flashdata('message', '<p class="error">An error occured</p>');
        redirect('messages/inbox');
      }      	
    }
  }
  
  function view($id)
  {
  	$message = $this->messaging->getMessage($id);
  	if(!$message)
		{
			$this->session->set_flashdata('message', '<p class="error">That message is not available</p>');
			redirect('messages/inbox');
		}
		else
		{
			$message->from = $this->Users->printUsername($message->sender_id);
			$message->received = $this->Users->timeago($message->received);
			
			$this->data['title'] = 'Messages :: ' . $message->subject;
			$this->data['message'] = $message;
  		$this->_load('view');
  	}
  }
  
  function delete($id)
  {
  	$success = $this->messaging->delete($id);
  	if($success)
    {
      $this->session->set_flashdata('message', '<p class="success">That message has been deleted</p>');
      redirect('messages/inbox');
    }
    else
    {
      $this->session->set_flashdata('message', '<p class="error">An error occured</p>');
      redirect('messages/inbox');
    }    
  }

  //Used for validating the post variables
  function _validate_form()
  {
    $this->form_validation->set_rules('to', 'Recipient', 'required|callback__to_check');
    $this->form_validation->set_rules('subject', 'Subject', 'required|callback__subject_check');
    $this->form_validation->set_rules('body', 'Body', 'required|callback__body_check');
    $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

    return $this->form_validation->run();
  }

  function _to_check($username)
  {
  	if(!$this->liblogin->check_username($username)){
  		$this->form_validation->set_message('_to_check', 'That username is not used');
  		return false;
  	}
  	return true;
  }
  
  function _subject_check($subject)
  {
  	if($this->messaging->check_subject($subject))
  	{
  		$this->form_validation->set_message('_subject_check', $subject);
  		return false;
  	}
  	return true;
  }
  
  function _body_check($body)
  {
  	if($this->messaging->check_body($body))
  	{
  		$this->form_validation->set_message('_subject_check', $body);
  		return false;
  	}
  	return true;
  }
}
