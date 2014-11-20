<?php

class Login_model extends CI_MODEL{

	function insert_data($data)
	{
		
	$str = $this->db->insert_string('users', $data);
	if(mysql_query($str))
	{
		return true;
	}
	else
	{
		return false;
	}
	}

	function get_login_data($data)
	{	

		$this->db->select('user_id, confirmed_login, fname, phone_no');
		$this->db->from('users');
		$this->db->where($data);
		$query=$this->db->get();


			if($query->num_rows()>0)
			{
				return $data=$query->row_array();
			}
			else
			{	
				return; 
			}

	}

	function get_confirm_status($data)
	{
		$this->db->select('confirmed_login, phone_no');
		$this->db->from('users');
		$this->db->where($data);
		$query=$this->db->get();

		if($query->num_rows()>0)
			{
				return $data=$query->row_array();
			}
			else
			{	
				return; 
			}

	}


	function confirm_account($data)
	{
		$update=array('confirmed_login'=>$data['confirm']);

		$this->db->where('phone_no', $data['phone_no']);
		$this->db->update('users', $update);

	}

	function location_details($data)
	{

	$str = $this->db->insert_string('users_location', $data);
	if(mysql_query($str))
	{
		return true;
	}
	else
	{
		return false;
	}

	}

	function checkuser($data)
	{
		$phone_no=$data['phone_no'];
		$fname=$data['fname'];
		$sname=$data['sname'];

		$query=$this->db->query("SELECT * FROM users WHERE fname='$fname'
		 AND sname='$sname' AND phone_no='$phone_no'");
		
		if($query->num_rows()>0)
		{
	
			return 'true';
		}
		else
		{
			return 'false';
		}
		
	}

	function update_reset_password($data)
	{
		$this->db->where('phone_no', $data['phone_no']);
		if($this->db->update('users', array('password'=>$data['password'])))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	

}