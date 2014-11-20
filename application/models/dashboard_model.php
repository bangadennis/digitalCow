<?
class Dashboard_model extends CI_MODEL
{

//Get the username of user logged in
function get_username($phone)
	{
		$query=$this->db->query("SELECT fname FROM users WHERE phone_no='$phone'");

		if($query->num_rows()>0)
		{
			return $results=$query->row_array();
		}
		else
		{
			return;
		}

	}

//to get user profile details
function load_user_profile($phone_no)
{

	$query=$this->db->query("SELECT * FROM users where phone_no='$phone_no'");

		if($query->num_rows()>0)
		{
			$results['user']=$query->row_array();
		}
		else
		{
			return false;
		}


	$query=$this->db->query("SELECT * FROM users_location where phone_no='$phone_no'");

		if($query->num_rows()>0)
		{
			$results['location']=$query->row_array();
		}
		else
		{
			return false;
		}

	$query=$this->db->query("SELECT count(*) as number_cows FROM cow_detail where phone_no='$phone_no'");

		if($query->num_rows()>0)
		{
			$results['cows']=$query->row_array();
		}
		else
		{
			return false;
		}

	return $results;

}
//get the cow ids to display on the home page
function get_cows($phone_no)
{
	$query=$this->db->query("SELECT cow_id FROM cow_detail where phone_no='$phone_no'");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		}
		else
		{
			return false;
		}
}
//loading cow details for the dashboard
function dash_cow_details($cow, $phone_no)
{
	$query=$this->db->query("SELECT * FROM cow_detail where cow_id='".$this->db->escape_str($cow)."' 
		and phone_no='".$this->db->escape_str($phone_no)."'");

		if($query->num_rows()>0)
		{
			$result['cow_detail']=$query->row_array();
		}
		else
		{
			$result['cow_detail']='';
		}

	$query=$this->db->query("SELECT * FROM milkrecord where cow_id='".$this->db->escape_str($cow)."'
	 and cow_id IN(select cow_id
		from cow_detail where phone_no='".$this->db->escape_str($phone_no)."' and cow_id='".$this->db->escape_str($cow)."' ) ");

		if($query->num_rows()>0)
		{
			$result['milk']=$query->result_array();
		}
		else
		{
			$result['milk']='';
		}

	$query=$this->db->query("SELECT * FROM insemination where cow_id='".$this->db->escape_str($cow)."'
		and cow_id IN(select cow_id
		from cow_detail where phone_no='".$this->db->escape_str($phone_no)."' and cow_id='".$this->db->escape_str($cow)."' ) ");

		if($query->num_rows()>0)
		{
			$result['insemination']=$query->result_array();
		}
		else
		{
			$result['insemination']='';
		}

	$query=$this->db->query("SELECT * FROM feedingrecord where cow_id='".$this->db->escape_str($cow)."'
		and cow_id IN(select cow_id
		from cow_detail where phone_no='".$this->db->escape_str($phone_no)."' and cow_id='".$this->db->escape_str($cow)."' ) ");

		if($query->num_rows()>0)
		{
			$result['feed']=$query->result_array();
		}
		else
		{
			$result['feed']='';
		}

	$query=$this->db->query("SELECT * FROM calving_register where cow_id='".$this->db->escape_str($cow)."' and cow_id IN(select cow_id
		from cow_detail where phone_no='".$this->db->escape_str($phone_no)."' and cow_id='".$this->db->escape_str($cow)."' ) ");

		if($query->num_rows()>0)
		{
			$result['calving']=$query->result_array();
		}
		else
		{
			$result['calving']='';
		}

	$query=$this->db->query("SELECT * FROM health where cow_id='".$this->db->escape_str($cow)."' and cow_id IN(select cow_id
		from cow_detail where phone_no='".$this->db->escape_str($phone_no)."' and cow_id='".$this->db->escape_str($cow)."') ");

		if($query->num_rows()>0)
		{
			$result['health']=$query->result_array();
		}
		else
		{
			$result['health']='';
		}


		$query=$this->db->query("SELECT * FROM income where phone_no='".$this->db->escape_str($phone_no)."'");

		if($query->num_rows()>0)
		{
			$result['finance']=$query->result_array();
		}
		else
		{
			$result['finance']='';
		}

return $result;

}

//load sms updates

function get_invalid_sms()
	{
		$phone_no=$this->session->userdata('phone_no');
		$query=$this->db->query("SELECT * from invalidmessage WHERE sender='$phone_no' order by date desc");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();

		}
		else
		{
			return;
		}

	}

//responses sent from the system
	function get_response_sms()
	{
		$phone_no=$this->session->userdata('phone_no');
		$query=$this->db->query("SELECT * from ozekimessageout WHERE receiver='$phone_no' order by date desc");
  
		if($query->num_rows()>0)
		{
			return $result=$query->result_array();

		}
		else
		{
			return;
		}

	}

	//received sms 
	function get_received_sms()
	{
		$phone_no=$this->session->userdata('phone_no');
		$query=$this->db->query("SELECT * from ozekimessagein WHERE sender='$phone_no' order by date desc");
  
		if($query->num_rows()>0)
		{
			return $result=$query->result_array();

		}
		else
		{
			return;
		}

	}

//count the number of responses
function get_count_response_sms()
	{
		$phone_no=$this->session->userdata('phone_no');
		$query=$this->db->query("SELECT count(*) as count_response from ozekimessageout WHERE receiver='$phone_no' ");
  
		if($query->num_rows()>0)
		{
			$result=$query->row_array();
			$result_count['count_response']=$result['count_response'];

		}
		else
		{
			$result_count['count_response']=0;
		}


		$query=$this->db->query("SELECT count(*) as count_received from ozekimessagein WHERE sender='$phone_no' ");
  
		if($query->num_rows()>0)
		{
			$result=$query->row_array();
			$result_count['count_received']=$result['count_received'];

		}
		else
		{
			$result_count['count_received']=0;
		}


		$query=$this->db->query("SELECT count(*) as count_invalid from invalidmessage WHERE sender='$phone_no' ");
  
		if($query->num_rows()>0)
		{
			$result=$query->row_array();
			$result_count['count_invalid']=$result['count_invalid'];

		}
		else
		{
			$result_count['count_invalid']=0;
		}

	return $result_count;
	}






///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////COW REGISTER RECORDS//////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	function add_cow_record($data)
	{
		if($this->db->insert('cow_detail', $data))
		{
			return true;
		}
		else
		{
			return false;
		}


	}

	function get_cow_record($data)
	{
		$data['phone_no']=$data['phone_no'];
		$query=$this->db->get_where('cow_detail', $data);

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();

		}
		else
		{
			return;
		}

	}

	function get_cow_id($data)
	{
		$data['phone_no']=$data['phone_no'];
		$query=$this->db->get_where('cow_detail', $data);

		if($query->num_rows()>0)
		{
			return $results=$query->result_array();
		}
		else
		{
			return;
		}

	}

	function get_cow_id_details($data)
	{
		$data['cow_id']=$data['cow_id'];
		$query=$this->db->get_where('cow_detail', $data);

		if($query->num_rows()>0)
		{
			return $results=$query->row_array();
		}
		else
		{
			return;
		}

	}

	function update_cow_details($data)
	{
		$cow_id=$data['cow_id'];
		$data=array(
			'sex'=> $data['sex'],
			'breed'=>$data['breed'],
			'dateofbirth'=>$data['dateofbirth']
			);
		$this->db->where('cow_id', $cow_id);
		if($this->db->update('cow_detail',$data))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function search_cow_details($limit, $offset, $phone_no)
	{
		/*$query=$this->db->select('*')
		->from('cow_detail')
		->where('phone_no', $phone_no)
		->limit($limit, $offset);*/
		$query=$this->db->query("SELECT * from cow_detail where phone_no='$phone_no' LIMIT $offset, $limit");
		if($query->num_rows()>0)
		{
			$result['rows']=$query->result_array();
		}
		else
		{
			return;
		}

		$query=$this->db->select('COUNT(*) as count', FALSE)
				->from('cow_detail');

		$temp=$query->get()->result();


		$result['num_rows']=$temp[0]->count;

		return $result;
	}

	function delete_cow_record_model($data)
	{
		if($this->db->delete('cow_detail', $data))
		{
			return $data='Record deleted';
		}
		else
		{
			return false;
		}

	}

function check_if_cow_id_exists($cow_id)
{
	$query=$this->db->query("SELECT * FROM cow_detail WHERE cow_id='$cow_id'");

		if($query->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////MILK RECORD//////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////


	function get_cow_id_milk($phone_no, $sex)
	{

		if($sex==='')
		{
		$sort_sex='';
		}
		else
		{
			$sort_sex="AND sex='$sex'";
		}

		$query=$this->db->query("SELECT distinct cow_id FROM cow_detail WHERE 
			phone_no='$phone_no' $sort_sex ");

		if($query->num_rows()>0)
		{
			return $results=$query->result_array();
		}
		else
		{
		return;

		}

	}

	//Display a cow a cow that can be milked
  function get_cow_milk_valid()
	{
		$phone_no=$this->session->userdata('phone_no'); 

		$query=$this->db->query("SELECT cow_id FROM cow_detail WHERE phone_no='$phone_no' and sex='Female' and dateofbirth
		 <(DATE_SUB(curdate(), INTERVAL 2.5 YEAR))");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		
		}
		else
		{
			return;
		}

	}




//////////////////////////////////////////////////////////////////////////////////

//for getting update cow_id values for all tables
	function get_cow_id_update($phone_no, $table, $sex)
	{
		if($sex==='')
		{
			$sort_sex='';
		}
		else
		{
			$sort_sex="AND sex='$sex'";
		}
		$query=$this->db->query("SELECT distinct cow_id FROM $table WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no' $sort_sex )");
		if($query->num_rows()>0)
		{
			return $result['rows']=$query->result_array();
		}
		else
		{
			return;
		}

	}
///////////////////////////////////////////////////////////////////////////////////
	function insert_milk_record($data)
	{
		$cow_id=$data['cow_id'];
		$date=$data['date_cow'];
		$query=$this->db->query("SELECT cow_id, date_cow FROM milkrecord 
			WHERE cow_id='$cow_id' AND date_cow='$date'");
		if($query->num_rows()>0)
		{
			return false;
		}
		else
		{
		$query=$this->db->insert_string('milkrecord', $data);
			if(mysql_query($query))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	function search_milk_details($limit, $offset, $phone_no)
	{
		/*$query=$this->db->select('*')
		->from('cow_detail')
		->where('phone_no', $phone_no)
		->limit($limit, $offset);*/
		$query=$this->db->query("SELECT * FROM milkrecord WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no') ORDER BY date_cow desc limit $offset, $limit");
		if($query->num_rows()>0)
		{
			$result['rows']=$query->result_array();
		}
		else
		{
			return;
		}

		$query=$this->db->query("SELECT COUNT(*) as count FROM milkrecord WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no')");

		if($query->num_rows()>0)
		{
			$tmp=$query->row();
			$result['num_rows']=$tmp->count;
		}
		else
		{
			return;
		}

		
		return $result;
	}

	function show_date($cow_id)
	{
		$query=$this->db->query("SELECT date_cow FROM milkrecord WHERE cow_id='$cow_id' ORDER BY date_cow desc");

		if($query->num_rows()>0)
		{
			return $result['dates']=$query->result_array();
		
		}
		else
		{
			return;
		}

	}

	function show_milk_update($data)
	{
		//$query=$this->db->query("SELECT * FROM milkrecord WHERE cow_id='$cow_id'");
		$query=$this->db->get_where('milkrecord', $data);

		if($query->num_rows()>0)
		{
			return $results=$query->row_array();
		}
		else
		{
			return;
		}

	}

	function update_milk_record($data, $milk_id)
	{
		$this->db->where('milk_id', $milk_id);
		if($this->db->update('milkrecord',$data))
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	function delete_milk_record($milk_id)
	{
		$this->db->where('milk_id', $milk_id);

		if($this->db->delete('milkrecord'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function analysis_milk_model($to_date, $from_date, $cow_id, $price, $phone_no)
	{
		if($cow_id=='ALL')
		{
			$query=$this->db->query("SELECT SUM(morning_amount+evening_amount) as t_amount,
			AVG(morning_amount+evening_amount) as avg_amount, AVG(morning_amount) as avgm_amount,
			 AVG(evening_amount) as avge_amount, SUM(morning_amount) as sm_amount, 
			 SUM(evening_amount) as se_amount, SUM((morning_amount+evening_amount)*'$price') as t_income
			FROM milkrecord WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no') and  date_cow between '$from_date' and '$to_date' ");

			if($query->num_rows()>0)
			{
				return $result=$query->row_array();
			}
			else
			{
				return false;
			}

		}
		else
		{
			$query=$this->db->query("SELECT SUM(morning_amount+evening_amount) as t_amount,
			AVG(morning_amount+evening_amount) as avg_amount, AVG(morning_amount) as avgm_amount,
			 AVG(evening_amount) as avge_amount, SUM(morning_amount) as sm_amount, 
			 SUM(evening_amount) as se_amount, SUM((morning_amount+evening_amount)*'$price') as t_income
			FROM milkrecord WHERE cow_id='$cow_id' and date_cow between '$from_date' and '$to_date' ");



			if($query->num_rows()>0)
			{
				return $result=$query->row_array();
			}
			else
			{
				return false;
			}

		}
		
	}


//Plotting the milk data graph

	function graph_data()
	{

	$cow_id=$this->session->userdata('Cow_id_graph');
	$phone_no=$this->session->userdata('phone_no');

	if(!empty($cow_id))
	{
		if($cow_id=='ALL')
		{
			$query=$this->db->query("SELECT date_cow, evening_amount, 
				morning_amount FROM milkrecord where cow_id in
				(SELECT cow_id from cow_detail where phone_no='$phone_no') order by date_cow asc");
			
			$table=array();
			$rows=array();
			$table['cols'] = array(
		    array('label' => 'Date', 'type' => 'string'),
		    array('label' => 'Morning', 'type' => 'number'),
		    array('label' => 'Evening', 'type' => 'number')
			);

			if($query->num_rows()>0)
			{
				$result=$query->result_array();
			
				foreach ($result as $r) {
					$temp=array();
					//$date=explode('-', $r['date_cow']);
					//$r['date']=$date[2];
					$temp[]=array('v' => (string) $r['date_cow']);
					$temp[]=array('v' => (float) $r['morning_amount']);  
					$temp[]=array('v' => (float) $r['evening_amount']);
					
					$rows[] = array('c' => $temp);
				}

				$table['rows'] = $rows;
			return	$jsonTable = json_encode($table);

			}
			else
			{
				return;
			
			}
		}
		else
		{
			$query=$this->db->query("SELECT date_cow, evening_amount, 
				morning_amount FROM milkrecord where cow_id='$cow_id' order by date_cow asc");
			
			$table=array();
			$rows=array();
			$table['cols'] = array(
		    array('label' => 'Date', 'type' => 'string'),
		    array('label' => 'Morning', 'type' => 'number'),
		    array('label' => 'Evening', 'type' => 'number')
			);

			if($query->num_rows()>0)
			{
				$result=$query->result_array();
			
				foreach ($result as $r) {
					$temp=array();
					$temp[]=array('v' => (string) $r['date_cow']);
					$temp[]=array('v' => (float) $r['morning_amount']);  
					$temp[]=array('v' => (float) $r['evening_amount']);
					
					$rows[] = array('c' => $temp);
				}

				$table['rows'] = $rows;
			return	$jsonTable = json_encode($table);

			}
			else
			{
				return;
			
			}

		}

	}
	else
	{
		return;
	}

	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////FEED RECORD//////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//Models for Feed Page
	function add_feed_record($data)
	{
		
		$cow_id=$data['cow_id'];
		$feed_date=$data['feed_date'];

		$query=$this->db->query("SELECT cow_id, feed_date FROM feedingrecord
			WHERE cow_id='$cow_id' AND feed_date='$feed_date'");
		if($query->num_rows()>0)
		{
			return false;
		}
		else
		{

			$query=$this->db->insert_string('feedingrecord', $data);

			if(mysql_query($query))
			{
				return true;
			}

			else
			{
				return false;
			}
		}

	}


//display a specific date for a cow

	function show_feed_date($cow_id)
	{
		$query=$this->db->query("SELECT feed_date FROM feedingrecord WHERE cow_id='$cow_id'");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		
		}
		else
		{
			return;
		}

	}

//update feed data to display

	function update_feed_data($data)
	{

		$query=$this->db->get_where('feedingrecord', $data);

		if($query->num_rows()>0)
		{
			return $results=$query->row_array();
		}
		else
		{
			return;
		}

	}

// Update the feeding record

function update_feed_record($data, $feed_id)
{
		$this->db->where('feed_id', $feed_id);

		if($this->db->update('feedingrecord',$data))
		{
			return true;
		}
		else
		{
			return false;
		}

}

//get feed details for pagination
function search_feed_details($limit, $offset, $phone_no)
	{

		$query=$this->db->query("SELECT * FROM feedingrecord WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no') ORDER BY feed_date desc limit $offset, $limit");
		if($query->num_rows()>0)
		{
			$result['rows']=$query->result_array();
		}
		else
		{
			return;
		}

		$query=$this->db->query("SELECT COUNT(*) as count FROM feedingrecord WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no')");

		if($query->num_rows()>0)
		{
			$tmp=$query->row();
			$result['num_rows']=$tmp->count;
		}
		else
		{
			return;
		}

		return $result;
	}

	//Delete feed record

	function delete_feed_record($feed_id)
	{
		$this->db->where('feed_id', $feed_id);

		if($this->db->delete('feedingrecord'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////INSEMINATION//////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//get a valid cow for insemination records
function get_cow_insemination_valid()
	{
		$phone_no=$this->session->userdata('phone_no'); 

		$query=$this->db->query("SELECT cow_id FROM cow_detail WHERE phone_no='$phone_no' and sex='Female' and dateofbirth
		 <(DATE_SUB(curdate(), INTERVAL 2 YEAR))");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		
		}
		else
		{
			return;
		}

	}
//add insemination record
	function add_insemination_record($data)
	{
		$cow_id=$data['cow_id'];
		$date=$data['date_insemination'];
		$query=$this->db->query("SELECT cow_id, date_insemination FROM insemination 
			WHERE cow_id='$cow_id' AND date_insemination='$date'");
		if($query->num_rows()>0)
		{
			return false;
		}
		else
		{
			$query=$this->db->insert_string('insemination', $data);

			if(mysql_query($query))
			{
				return true;
			}

			else
			{
				return false;
			}
		}

	}

	//display a specific insemination date for a cow

	function show_insemination_date($cow_id)
	{
		$query=$this->db->query("SELECT date_insemination FROM insemination WHERE cow_id='$cow_id'");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		
		}
		else
		{
			return;
		}

	}

	//get data to display
	function update_insemination_data($data)
	{

		$query=$this->db->get_where('insemination', $data);

		if($query->num_rows()>0)
		{
			return $results=$query->row_array();
		}
		else
		{
			return;
		}

	}

	//Update insemination Record

	function update_insemination_record($data, $insemination_id)
	{
		$this->db->where('insemination_id', $insemination_id);

		if($this->db->update('insemination',$data))
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	//get Cow Insemination details for pagination
function search_insemination_details($limit, $offset, $phone_no)
	{

		$query=$this->db->query("SELECT * FROM insemination WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no') ORDER BY date_insemination desc limit $offset, $limit");
		if($query->num_rows()>0)
		{
			$result['rows']=$query->result_array();
		}
		else
		{
			return;
		}

		$query=$this->db->query("SELECT COUNT(*) as count FROM insemination WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no')");

		if($query->num_rows()>0)
		{
			$tmp=$query->row();
			$result['num_rows']=$tmp->count;
		}
		else
		{
			return;
		}

		return $result;
	}

	//Delete Insemination Record

	function delete_Insemination_record($insemination_id)
	{
		$this->db->where('insemination_id', $insemination_id);

		if($this->db->delete('insemination'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}



///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////HEALTH RECORDS//////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//add Health record
	function add_health_record($data)
	{
		$cow_id=$data['cow_id'];
		$date=$data['date_treatment'];
		$query=$this->db->query("SELECT cow_id, date_treatment FROM health
			WHERE cow_id='$cow_id' AND date_treatment='$date'");
		if($query->num_rows()>0)
		{
			return false;
		}
		else
		{
			$query=$this->db->insert_string('health', $data);

			if(mysql_query($query))
			{
				return true;
			}

			else
			{
				return false;
			}
		}

	}

	//display a specific health date for a cow

	function show_health_date($cow_id)
	{
		$query=$this->db->query("SELECT date_treatment FROM health WHERE cow_id='$cow_id'");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		
		}
		else
		{
			return;
		}

	}

	//get Health data to display for update
	function update_health_data($data)
	{

		$query=$this->db->get_where('health', $data);

		if($query->num_rows()>0)
		{
			return $results=$query->row_array();
		}
		else
		{
			return;
		}

	}

//Update insemination Record

	function update_health_record($data, $health_id)
	{
		$this->db->where('health_id', $health_id);

		if($this->db->update('health',$data))
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	//get Cow Insemination details for pagination
function search_health_details($limit, $offset, $phone_no)
	{

		$query=$this->db->query("SELECT * FROM health WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no') ORDER BY date_treatment desc limit $offset, $limit");
		if($query->num_rows()>0)
		{
			$result['rows']=$query->result_array();
		}
		else
		{
			return;
		}

		$query=$this->db->query("SELECT COUNT(*) as count FROM health WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no')");

		if($query->num_rows()>0)
		{
			$tmp=$query->row();
			$result['num_rows']=$tmp->count;
		}
		else
		{
			return;
		}

		return $result;
	}

	//Delete Health Record

	function delete_health_record($health_id)
	{
		$this->db->where('health_id', $health_id);

		if($this->db->delete('health'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////CALVING RECORDS//////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//Display a valid cow for calving
  function get_cow_calving_valid()
	{
		$phone_no=$this->session->userdata('phone_no'); 

		$query=$this->db->query("SELECT cow_id FROM cow_detail WHERE phone_no='$phone_no' and sex='Female' and dateofbirth
		 <(DATE_SUB(curdate(), INTERVAL 3 YEAR))");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		
		}
		else
		{
			return;
		}

	}

//add calving record
	function add_calving_record($data)
	{
		$cow_id=$data['cow_id'];
		$calf_id=$data['calf_id'];
		$query=$this->db->query("SELECT cow_id, calf_id FROM calving_register
			WHERE cow_id='$cow_id' AND calf_id='$calf_id'");
		if($query->num_rows()>0)
		{
			return false;
		}
		else
		{
			$query=$this->db->insert_string('calving_register', $data);

			if(mysql_query($query))
			{
				return true;
			}

			else
			{
				return false;
			}
		}

	}

//Display valid calf id
  function show_calf_id_valid($cow_id)
	{
		$phone_no=$this->session->userdata('phone_no'); 

		$query=$this->db->query("SELECT cow_id FROM cow_detail WHERE phone_no='$phone_no' and dateofbirth
			>(SELECT DATE_ADD(dateofbirth, INTERVAL 2.5 YEAR) as dob
			FROM cow_detail where cow_id='$cow_id')");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		
		}
		else
		{
			return;
		}

	}

//Display calf id
  function show_calf_id($cow_id)
	{
		$query=$this->db->query("SELECT calf_id FROM calving_register WHERE cow_id='$cow_id'");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		
		}
		else
		{
			return;
		}

	}


	//get Calving data to display for update
	function update_calving_data($data)
	{

		$query=$this->db->get_where('calving_register', $data);

		if($query->num_rows()>0)
		{
			return $results=$query->row_array();
		}
		else
		{
			return;
		}

	}

	//Update Calving Record

	function update_calving_record($data, $calf_id)
	{
		$this->db->where('calf_id', $calf_id);

		if($this->db->update('calving_register',$data))
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	//get Cow calving details for pagination
function search_calving_details($limit, $offset, $phone_no)
	{

		$query=$this->db->query("SELECT * FROM calving_register WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no') ORDER BY calf_id desc limit $offset, $limit");
		if($query->num_rows()>0)
		{
			$result['rows']=$query->result_array();
		}
		else
		{
			return;
		}

		$query=$this->db->query("SELECT COUNT(*) as count FROM calving_register WHERE cow_id IN(SELECT cow_id
			FROM cow_detail where phone_no='$phone_no')");

		if($query->num_rows()>0)
		{
			$tmp=$query->row();
			$result['num_rows']=$tmp->count;
		}
		else
		{
			return;
		}

		return $result;
	}

	//Delete Calving Record

	function delete_calving_record($calf_id)
	{
		$this->db->where('calf_id', $calf_id);

		if($this->db->delete('calving_register'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////REMINDERS RECORDS//////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//add reminder record
	function add_reminder_record($data)
	{
		
			$query=$this->db->insert_string('reminder', $data);

			if(mysql_query($query))
			{
				return true;
			}

			else
			{
				return false;
			}

	}

//get the reminder id
	function get_reminder_number($phone_no)
	{

		$query=$this->db->query("SELECT reminder_id FROM reminder WHERE phone_no='$phone_no' order by date_remind desc");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		
		}
		else
		{
			return;
		}

	}
//get Reminder data to display for update
	function update_reminder_data($data)
	{

		$query=$this->db->get_where('reminder', $data);

		if($query->num_rows()>0)
		{
			return $results=$query->row_array();
		}
		else
		{
			return;
		}

	}

//Update reminder record
	function update_reminder_record($data, $reminder_id)
	{
		$this->db->where('reminder_id', $reminder_id);

		if($this->db->update('reminder',$data))
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	//get reminder details for pagination
function search_reminder_details($limit, $offset, $phone_no)
	{

		$query=$this->db->query("SELECT * FROM reminder WHERE phone_no='$phone_no' ORDER BY date_remind
			desc limit $offset, $limit");
		if($query->num_rows()>0)
		{
			$result['rows']=$query->result_array();
		}
		else
		{
			return;
		}

		$query=$this->db->query("SELECT COUNT(*) as count FROM reminder WHERE phone_no='$phone_no'");

		if($query->num_rows()>0)
		{
			$tmp=$query->row();
			$result['num_rows']=$tmp->count;
		}
		else
		{
			return;
		}

		return $result;
	}

	//Delete reminder Record

	function delete_reminder_record($reminder_id)
	{
		$this->db->where('reminder_id', $reminder_id);

		if($this->db->delete('reminder'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////INCOME AND EXPENSE RECORDS//////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//add income expense record
	function add_income_expense_record($data)
	{
		
			$query=$this->db->insert_string('income', $data);

			if(mysql_query($query))
			{
				return true;
			}

			else
			{
				return false;
			}

	}


	//get the income id
	function get_income_number($phone_no)
	{

		$query=$this->db->query("SELECT income_id FROM income WHERE phone_no='$phone_no'");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		
		}
		else
		{
			return;
		}
	}

//get income and expense data to display for update
	function update_income_expense_data($data)
	{

		$query=$this->db->get_where('income', $data);

		if($query->num_rows()>0)
		{
			return $results=$query->row_array();
		}
		else
		{
			return;
		}

	}

//Update expense and income record
	function update_income_expense_record($data, $income_id)
	{
		$this->db->where('income_id', $income_id);

		if($this->db->update('income',$data))
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	//get income and expense details for pagination
function search_income_expense_details($limit, $offset, $phone_no)
	{

		$query=$this->db->query("SELECT * FROM income WHERE phone_no='$phone_no' ORDER BY date 
			desc limit $offset, $limit");
		if($query->num_rows()>0)
		{
			$result['rows']=$query->result_array();
		}
		else
		{
			return;
		}

		$query=$this->db->query("SELECT COUNT(*) as count FROM income WHERE phone_no='$phone_no'");

		if($query->num_rows()>0)
		{
			$tmp=$query->row();
			$result['num_rows']=$tmp->count;
		}
		else
		{
			return;
		}

		return $result;
	}

	//Delete reminder Record

	function delete_income_expense_record($income_id)
	{
		$this->db->where('income_id', $income_id);

		if($this->db->delete('income'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}



function analysis_income_model($to_date, $from_date, $phone_no)
	{
		
			$query=$this->db->query("SELECT SUM(amount) as expense from income where phone_no='$phone_no' AND
				type_income='Expense' and  date between '$from_date' and '$to_date'");

			if($query->num_rows()>0)
			{
				$ret=$query->row_array();
				$result['expense']=$ret['expense'];
			}
			else
			{
				
			}

			$query=$this->db->query("SELECT SUM(amount) as income from income where phone_no='$phone_no' AND
				type_income='Income' and  date between '$from_date' and '$to_date'");

			if($query->num_rows()>0)
			{
				$ret=$query->row_array();
				$result['income']=$ret['income'];
			}
			else
			{
				
			}

			$query=$this->db->query("SELECT AVG(amount) as expense_avg from income where phone_no='$phone_no' AND
				type_income='Expense' and  date between '$from_date' and '$to_date'");

			if($query->num_rows()>0)
			{
				$ret=$query->row_array();
				$result['expense_avg']=$ret['expense_avg'];
			}
			else
			{
				
			}

			$query=$this->db->query("SELECT AVG(amount) as income_avg from income where phone_no='$phone_no' AND
				type_income='Income' and  date between '$from_date' and '$to_date'");

			if($query->num_rows()>0)
			{
				$ret=$query->row_array();
				$result['income_avg']=$ret['income_avg'];
			}
			else
			{
				
			}

		return $result;
		
	}


//Plotting the milk data graph

	function graph_data_expense()
	{

	$phone_no=$this->session->userdata('phone_no');

			$query=$this->db->query("SELECT date, amount as expense
				FROM income where phone_no='$phone_no' and type_income='Expense' order by date asc");

		
			$table=array();
			$rows=array();
			$table['cols'] = array(
		    array('label' => 'Date_Expense', 'type' => 'string'),
		   // array('label' => 'Income', 'type' => 'number'),
		    array('label' => 'Expense', 'type' => 'number')
			);

			if($query->num_rows()>0)
			{
				$result=$query->result_array();
			
				foreach ($result as $r) {
					$temp=array();
					//$date=explode('-', $r['date']);
					//$r['date']=$date[2];
					$temp[]=array('v' => (string) $r['date']);
					$temp[]=array('v' => (float) $r['expense']);  
					//$temp[]=array('v' => (float) $r['income']);
					
					$rows[] = array('c' => $temp);
				}

				$table['rows'] = $rows;
			return	$jsonTable = json_encode($table);

			}
			else
			{
				return;
			
			}
		
	}




	function graph_data_income()
	{

	$phone_no=$this->session->userdata('phone_no');

			$query=$this->db->query("SELECT date, amount as income
				FROM income where phone_no='$phone_no' and type_income='Income' order by date asc");

		
			$table=array();
			$rows=array();
			$table['cols'] = array(
		    array('label' => 'Date_Income', 'type' => 'string'),
		   array('label' => 'Income', 'type' => 'number'),
		    
			);

			if($query->num_rows()>0)
			{
				$result=$query->result_array();
			
				foreach ($result as $r) {
					$temp=array();
					//$date=explode('-', $r['date']);
					//$r['date']=$date[2];
					$temp[]=array('v' => (string) $r['date']);
					
					$temp[]=array('v' => (float) $r['income']);
					
					$rows[] = array('c' => $temp);
				}

				$table['rows'] = $rows;
			return	$jsonTable = json_encode($table);

			}
			else
			{
				return;
			
			}
		
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////

//admin panel

	//active users
	function active_users()
	{

		$query=$this->db->query("SELECT * FROM users WHERE confirmed_login=1 and phone_no!='+254731053591' ORDER BY fname 
			asc ");
		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		}
		else
		{
			return;
		}

	}

	//inactive users
	function inactive_users()
	{

		$query=$this->db->query("SELECT * FROM users WHERE confirmed_login=0 ORDER BY fname 
			asc ");
		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		}
		else
		{
			return;
		}

	}

//delete user 

	//Delete reminder Record

	function delete_user($user_id)
	{
		$this->db->where('user_id', $user_id);

		if($this->db->delete('users'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


//get cow and farmers details
	function get_admin_details()
	{

		$query=$this->db->query("SELECT count(cow_id) as number_cows FROM cow_detail ");

		if($query->num_rows()>0)
		{
			$res=$query->row_array();
			$result['number_cows']=$res['number_cows'];
		
		}
		else
		{
			return;
		}

		$query=$this->db->query("SELECT count(user_id) as number_users  FROM users");

		if($query->num_rows()>0)
		{
			$res=$query->row_array();
			$result['number_users']=$res['number_users'];
		
		}
		else
		{
			return;
		}
	
	return $result;

	}






}