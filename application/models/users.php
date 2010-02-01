<?php

class Users extends Model {

	var $user_cache;

	function Users()
	{
		  parent::Model();
	}

	function get($id = null)
	{
		if(is_null($id))
		{
			$id = $this->session->userdata('id');
		}
		if(!$id){
			exit('Error, no id set');
		}
		
		if(isset($user_cache[$id])){
			return $user_cache[$id];
		}
		$query = $this->db->get_where('users', array('id' => $id));
		$user_cache[$id] = $row = $query->row();
		return $row;
	}
	
	function getData()
	{
		$data['user'] = $this->get();
		$data['logged_in'] = true;
		return $data;
	}
}
?>
