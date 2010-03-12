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
	
	function timeago($date_from, $date_to = null)
	{
		if(is_null($date_to))
		{
			$date_to = time();
		}
		
		$diff = $date_to - $date_from;
		if($diff < 60)
		{
			return ($diff==1) ? $diff.' second ago' : $diff.' seconds ago';
		} elseif($diff < 3600)
		{
			$datediff = floor($diff / 60);
			return ($datediff==1) ? $datediff.' minute ago' : $datediff.' minutes ago';
		}
		elseif($diff < 86400)
		{
			$datediff = floor($diff / 60 / 60);
      return ($datediff==1) ? $datediff.' hour ago' : $datediff.' hours ago';
		}
		else
		{
			return date("Y-m-d H:i", $date_from);
		}	
	}
	
	function printUsername($id)
	{
		$user = $this->get($id);
		return "<a href=\"" . site_url("users/" . $id) . "\">" . $user->username . "</a>";
	}
}
?>
