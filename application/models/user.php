<?php

class User extends Model {

	var $user_cache;

	function User()
	{
		  parent::Model();
	}

	function getUser($id = null)
	{
		if(isset($user_cache[$id])){
			return $user_cache[$id];
		}
		$query = $this->db->get_where('users', array('id' => $id));
		$user_cache[$id] = $row = $query->row();
		return $row;
	}
}
?>
