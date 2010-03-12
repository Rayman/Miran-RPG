<?php

class Messaging extends Model {

	var $user_cache;

	function Messaging()
	{
		  parent::Model();
	}
	
	function send($to, $subject, $body, $from = null, $html_allowed = false)
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
			'subject' => htmlspecialchars($subject),
			'body' => $this->prepare_body($body)
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

	function getMessage($id = null, $check_from = true)
	{
		if(!$id){
			exit('Error, no id set');
		}
		
		$user_id = $this->session->userdata('id');
		if(!$user_id){
			exit('Error, no id set');
		}
		
		$query = $this->db->get_where('ci_messages', array('id' => $id));
		
		if($query->num_rows() == 0)
			return null;
		
		$message = $query->row();

		if($check_from && $message->user_id != $user_id)
			return null;
		
		return $message;
	}
	
	function prepare_body($body)
	{
		//TODO, add some bb code
		return htmlspecialchars($body);
	}
	
	function delete($id)
	{
		$from = $this->session->userdata('id');
		if(!$from){
			exit('Error, no id set');
		}
		
		if($this->getMessage($id)) //Check if the user owns the message
		{
			$this->db->delete('ci_messages', array('id' => $id));
			return $this->db->affected_rows() == 1 ? true : false;
		}
		
		return false;
	}
}
?>
