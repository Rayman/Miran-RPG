<?php

class Messaging extends Model {

	var $user_cache;

	function Messaging()
	{
		  parent::Model();
	}
	
	function send($to, $subject, $body, $from = null)
	{
		if(is_null($from))
		{
			$from = $this->session->userdata('id');
		}
		if(!$from){
			exit('Error, no id set');
		}
		
		$data = array(
			'user_id' => $to,
			'received' => time(),
			'sender_id' => $from,
			'subject' => $subject,
			'body' => $body
		);

		return $this->db->insert('ci_messages', $data);
	}
	
	function check_subject($subject)
	{
		if(strlen($subject) > 64)
		{
			return "Subject too long";
		} 
		elseif(strlen($subject) == 0)
		{
			return "Your must enter a subject";
		}
		return false;	
	}

	function check_body($body)
	{
		return false;	
	}
	
	function getMessages($id = null)
	{
		if(is_null($id))
		{
			$id = $this->session->userdata('id');
		}
		if(!$id){
			exit('Error, no id set');
		}
		
		$query = $this->db->get_where('ci_messages', array('user_id' => $id));
		return $query->result();
	}			
}
?>
