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
		
		if(isset($this->user_cache[$id])){
			return $this->user_cache[$id];
		}
		$query = $this->db->get_where('users', array('id' => $id));
		$this->user_cache[$id] = $row = $query->row();
		return $row;
	}
	
	function getData()
	{
		//Redirect if not logged in
    if(!$this->liblogin->logged_in()){
    	redirect('login');
    }
	
		$data['user'] = $this->get();
		$data['logged_in'] = true;
		return $data;
	}
	
	function findUser($username)
	{
		$result = $this->db
			->from('ci_users')
			->where('username', $username)
			->get();

    return ($result->num_rows() > 0) ? $result->row() : false;
	}
}
?>
