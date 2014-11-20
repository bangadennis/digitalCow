<?

class Smsmodel extends CI_MODEL{

	public function invalid_message($data)
	{
		$this->db->insert('invalidmessage', $data);

	}

	public function sent_message($data)
	{
		$this->db->insert('ozekimessageout', $data);


	}

	public function received_message($data)
	{
		$this->db->insert('ozekimessagein', $data);


	}

//show the farmers' cows
	public function farmer_cows($phone_no)
	{

		$query=$this->db->query("SELECT cow_id FROM cow_detail WHERE phone_no='$phone_no'");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();

		}
		else
		{
			return;
		}
	}





//process sms updates

	public function process_updates($datamsg, $phone_no)
		{
			$data=explode(' ', $datamsg);

			if (!isset($data[1]))
			{
				return false;
			}
			else
			{

				if($data[1]=='milk')
				{	
					$result=$this->process_milk_update($data);

					if(!empty($result))
					{
						$query=$this->milk_update($result, $phone_no);

						if(!empty($query))
						{
							return $query="Milk Information Updated Succesfully";
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}

					
				}else
				
				if ($data[1]=='expense'||$data[1]=='income') 
				{	
					$result=$this->process_income_update($data);

					if(!empty($result))
					{
						$query=$this->income_update($result, $phone_no);
						if(!empty($query))
						{
							return $query="Income/Expense Updated Succesfully";
						}
						else
						{
							return false;
						}

					}
					else
					{
						return false;
					}	
						
				}else
				
				if ($data[1]=='reminder') 
				{	
					$result=$this->process_reminder_update($datamsg);

					if(!empty($result))
					{
						$query=$this->reminder_update($result, $phone_no);
						if(!empty($query))
						{
							return $query;
						}
						else
						{
							return false;
						}

					}
					else
					{
						return false;
					}	
						
				}
		   }
	

	}





//Process Milk Update

public function process_milk_update($data)
{
				if(!isset($data[3])&&!isset($data[2]))
				{
					return false;
				}
				else
				{
					
					$msg1=explode('=', $data[2]);
					$msg2=explode('=', $data[3]);	
				
					if (count($msg1)!=2&&count($msg2)!=2)
					{

					return false;

					}
					else
					{

						if($msg1[0]=='m'||$msg1[0]=='morning')
						{
							if(is_numeric($msg1[1])&& $msg1[1]<=100)
							{
					
								$result['morning_amount']=$msg1[1];
							}
							else
							{
								return false;
							}
						}
						else
						{
							return false;
						}


						if($msg2[0]=='evening'||$msg2[0]=='e')
						{
							
							if(is_numeric($msg2[1]) && $msg2[1]<=100)
							{
								$result['evening_amount']=$msg2[1];
							}
							else
							{
								return false;
							}
						}
						else
						{
							return false;
						}


						if(!empty($data[4])&&isset($data[4]))
						{

							$result['cow_id']=strtoupper($data[4]);
						}
						else
						{
							return false;
						}


						if(!isset($data[5])&&empty($data[5]))
						{	
							$time=time();
							$result['date']=date('Y-m-d', $time);
						}
						else
						{
							$date_valid=$this->validate_date($data[5]);
							if(!empty($date_valid))
							{

							$result['date']=$data[5];
							
							}
							else
							{
								return false;
							}
							
					}
				}
			}


			return $result;
}

//income process sms



//milk update

function milk_update($data, $phone_no)
{

	$update_data['cow_id']=$data['cow_id'];
	$update_data['date_cow']=$data['date'];
	$update_data['morning_amount']=$data['morning_amount'];
	$update_data['evening_amount']=$data['evening_amount'];
	$sex='Female';

	$date=$update_data['date_cow'];
	$cow_id=$update_data['cow_id'];

	$query=$this->db->query("SELECT * FROM milkrecord where cow_id IN( select cow_id
		from cow_detail where phone_no='$phone_no' and sex='$sex') AND  cow_id='$cow_id' AND date_cow='$date'");
	if($query->num_rows()>0)
	{
		return false;
	}
	else
	{
		$query=$this->db->insert_string('milkrecord', $update_data);
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

//Income Upadate
function process_income_update($data)
{
	if(!isset($data[1]))
	{
		return false;
	}
	else
	{
		if($data[1]=='income')
		{
			$result['type_income']='Income';

		}
		else
			if($data[1]=='expense')
			{
				$result['type_income']='Expense';
			}
			else
			{
			  return false;
			}

	}


	if(!isset($data[2]))
	{
		return false;
	}
	else
	{
		if(is_numeric($data[2]))
		{
			$result['amount']=$data[2];

		}
		else
		{
			return false;
		}

	}

	if(!isset($data[3]))
	{
		return false;
	}
	else
	{
		if(!empty($data[3]))
		{
			$result['description']=$data[3];

		}
		else
			{
				return false;
			}
	}

	if(!isset($data[4]))
	{
		$time=time();
		$result['date']=date('Y-m-d', $time);
	}
	else
	{

		$date_valid=$this->validate_date($data[4]);
		if(!empty($date_valid))
		{

		$result['date']=$data[4];

		}
		else
		{
			return false;
		}

	}


return $result;

}

//insert income updates

function income_update($data, $phone_no)
{
		$data_update['description']=$data['description'];
		$data_update['phone_no']=$phone_no;
		$data_update['amount']=$data['amount'];
		$data_update['type_income']=$data['type_income'];
		$data_update['date']=$data['date'];

		$query=$this->db->query("SELECT phone_no FROM users WHERE phone_no='$phone_no'");
		if($query->num_rows()==1)
		{
			$query=$this->db->insert_string('income', $data_update);

			if(mysql_query($query))
			{
				return true;
			}
			else

			{
				return false;
			}

		}
		else
		{
			return false;
		}	


}



//Process Reminder update
function process_reminder_update($datamsg)
{
	//explode
	$data=explode(' ', $datamsg, 5);

	//date
	if(!isset($data[2]))
	{
		return false;
	}
	else
	{
		$date_valid=$this->validate_date($data[2]);

			if(!empty($date_valid))
			{
				$date_reminder=$this->date_valid_reminder($data[2]);
				if(empty($date_reminder))
				{
					return false;
				}
				else
				{

					$result['date_remind']=$data[2];
					$time=time();
					$result['date_set']=date('Y-m-d', $time);
				}
	
			}
			else
			{
			  return false;
			}

	}

//activity subject
	if(!isset($data[3]))
	{
		return false;
	}
	else
	{
		$result['activity']=$data[3];

	}

//description
	if(!isset($data[4]))
	{
		return false;
	}
	else
	{
		$result['description']=$data[4];
	
	}


return $result;

}

//insert reminders in the database;

function reminder_update($data, $phone_no)
{
		$data_update['description']=$data['description'];
		$data_update['phone_no']=$phone_no;
		$data_update['activity']=$data['activity'];
		$data_update['date_set']=$data['date_set'];
		$data_update['date_remind']=$data['date_remind'];
		$date_remind=$data['date_remind'];
		$date_set=$data['date_set'];

		//check the total reminders set for the day must be a total of 3
		$query=$this->db->query("SELECT count(*) as reminder_set from reminder where date_remind='$date_remind' and 
			date_set= '$date_set'");
		$result=$query->row();
		$rows=$result->reminder_set;

		if($rows<=3)
		{
			$query=$this->db->insert_string('reminder', $data_update);

			if(mysql_query($query))
			{
				return $result="Reminder Updated Succesfully";
			}
			else

			{
				return false;
			}

		}
		else
		{
			return $result="Total Reminder Set limit Reached";
		}	


}

//validate date
public function validate_date($date)
{
	$parts = explode("-", $date);

    if (count($parts) == 3 && isset($parts[2]))
     {      
      if (checkdate($parts[1], $parts[2], $parts[0]))
      {
        return true;
      }
    }
    return false;
}

public function date_valid_reminder($date)
	{
		$day_today=time();
		$date=strtotime($date);
		
		if($date>$day_today)
		{
			return true;

		}

		return false;
	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////PROCESS QUERIES////////////////////////

	function process_queries($datamsg, $phone_no, $fname)
	{
			$data=explode(' ', $datamsg);

			if (!isset($data[1])&& empty($data[1]))
			{
				return false;
			}
			else
			{

				if($data[1]=='milk')
				{	
				
					$result=$this->process_milk_query($datamsg);

					if(!empty($result))
					{
						$query=$this->milk_query($result, $phone_no);

						if(!empty($query))
						{
							return $query="Query Information ".$fname.", ".$query;
						}
						else
						{
							return $query='No Information Received';
						}
					}
					else
					{
						return false;
					}
				}

				else
				if ($data[1]=='expense'||$data[1]=='income'||$data[1]=='all') 
				{	
					$result=$this->process_income_expense_query($datamsg);

					if(!empty($result))
					{
						$query=$this->income_expense_query($result, $phone_no);

						if(!empty($query))
						{
							return $query="Query Information ".$fname.", ".$query;
						}
						else
						{
							return $query='No Information Received';
						}

					}
					else
					{
						return false;
					}	
						
				}
				else
				{

					return false;
				}
		   }
	


		}


//process milk queries

public function process_milk_query($datamsg)
{
	//explode
	$data=explode(' ', $datamsg);

	//specified computation in the message 
	if(!isset($data[2]))
	{
		return false;
	}
	else
	{
		if($data[2]=='total'||$data[2]=='ttl')
		{
			$result['computation']='total';
		}
		else
		if ($data[2]=='average'||$data[2]=='avg') 
		{
			
			$result['computation']='average';
		}
		else
		{
			return false;
		}
	}

//Checking up the specified time for the milk query
	//either specific date, weekly, daily and week=??? is the specified week.
	if(!isset($data[3]))
	{
		return false;
	}
	else
	{
		$date=$this->validate_date($data[3]);
		
		if(!empty($date))
		{
			$result['date']=$data[3];
			$result['today']=$data[3];
		}
		else
		if ($data[3]=='monthly') 
		{
				
			$result['date']=date('Y-m-d', strtotime('-1 month'));
			$time=time();
			$result['today']=date('Y-m-d', $time);
		}
		else
		if ($data[3]=='weekly') 
		{
			$result['date']=date('Y-m-d', strtotime('-1 week'));
			$time=time();
			$result['today']=date('Y-m-d', $time);
		}
		else
		if ($data[3]=='daily') {
			
			$time=time();
			$result['date']=date('Y-m-d', $time);
			$result['today']=date('Y-m-d', $time);
		}
		else
		{
			$week=explode('=', $data[3]);
			if(count($week)==2)
			{
				if(isset($week[0])&&isset($week[1]))
				{
					if($week[0]=='week')
					{
						$week_number=$week[1];
						if(is_numeric($week_number))
						{	
							$week_number='-'.$week_number;
							$result['date']=date('Y-m-d', strtotime($week_number.' week'));
							$time=time();
							$result['today']=date('Y-m-d', $time);
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}

				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

	}

//checking the specified cow_id in the message

	if(!isset($data[4]))
	{
		$result['cow_id']='all';
	}
	else
	{
		if($data[4]=='all')
		{
			$result['cow_id']='all';
		}
		else
		{

		$result['cow_id']=strtoupper($data[4]);
		}
	
	}


return $result;
			
}
//end


//milk query
//Running queries in the database for the milk record.
function milk_query($data, $phone_no)
{

	$date=$data['date'];
	$today=$data['today'];
	$computation=$data['computation'];
	$cow_id=$data['cow_id'];
	$sex='Female';
	if($computation=='total')
	{
		if($cow_id=='all')
		{

			$query=$this->db->query("SELECT sum(morning_amount+evening_amount) as total FROM milkrecord WHERE cow_id IN
				(select cow_id from cow_detail WHERE phone_no='$phone_no' and sex='$sex') and
				date_cow BETWEEN '$date' AND '$today' ");
			
			if($query->num_rows()>0)
			{
				$result=$query->row();
				$info="Sum morning and evening for all Cows";
				return $result_query['total']=$info.' is '.$result->total;
			}
			else
			{

				return false;
			}

		}
		else
		{
			$query=$this->db->query("SELECT sum(morning_amount+evening_amount) as total FROM milkrecord where cow_id IN ( select cow_id
			from cow_detail where phone_no='$phone_no' and sex='$sex') and cow_id='$cow_id' AND date_cow BETWEEN '$date' AND '$today'");
			if($query->num_rows()>0)
			{
				$result=$query->row();
				$info='Sum morning and evening for Cow '.$cow_id;
				return $result_query['total']=$info.' is '.$result->total;
			}
			else
			{
				return false;
			}

		}
	}
	else
	if ($computation=='average')
	 {
	 	if($cow_id=='all')
		{

			$query=$this->db->query("SELECT AVG(morning_amount+evening_amount) as average FROM milkrecord WHERE cow_id IN
				(select cow_id from cow_detail WHERE phone_no='$phone_no' and sex='$sex') and
				date_cow BETWEEN '$date' AND '$today' ");
			
			if($query->num_rows()>0)
			{
				$result=$query->row();
				$info="Average morning and evening for all Cow ";
				return $result_query['average']=$info.' is '.$result->average;
			}
			else
			{

				return false;
			}

		}
		else
		{
			$query=$this->db->query("SELECT AVG(morning_amount+evening_amount) as average FROM milkrecord where cow_id IN ( select cow_id
			from cow_detail where phone_no='$phone_no' and sex='$sex') and cow_id='$cow_id' AND date_cow BETWEEN '$date' AND '$today'");
			if($query->num_rows()>0)
			{
				$result=$query->row();
				$info="Average morning and evening for Cow ".$cow_id;
				return $result_query['average']=$info.' is '.$result->average;
			}
			else
			{
				return false;
			}

		}
		
		
	}
	else
	{
		return false;
	}

}



public function process_income_expense_query($datamsg)
{
	//explode
	$data=explode(' ', $datamsg);

	//checking the type of income

	if(!isset($data[1]))
	{
		return false;
	}
	else
	{
		if($data[1]=='income')
		{
			$result['type_income']='income';
		}
		else
		if ($data[1]=='expense') 
		{
			
			$result['type_income']='expense';
		}
		else
			if ($data[1]=='all') 
			{

				$result['type_income']='all';
			}
		else
		{
			return false;
		}
	}

//Checking up the specified time for the income/expense query
	//either specific date, weekly, daily and week=??? is the specified week.
	if(!isset($data[2]))
	{
		return false;
	}
	else
	{
		$date=$this->validate_date($data[2]);
		
		if(!empty($date))
		{
			$result['date']=$data[2];
			$result['today']=$data[2];
		}
		else
		if ($data[2]=='monthly') 
		{
				
			$result['date']=date('Y-m-d', strtotime('-1 month'));
			$time=time();
			$result['today']=date('Y-m-d', $time);
		}
		else
		if ($data[2]=='weekly') 
		{
			$result['date']=date('Y-m-d', strtotime('-1 week'));
			$time=time();
			$result['today']=date('Y-m-d', $time);
		}
		else
		if ($data[2]=='daily') {
			
			$time=time();
			$result['date']=date('Y-m-d', $time);
			$result['today']=date('Y-m-d', $time);
		}
		else
		{
			$week=explode('=', $data[2]);

			if(count($week)==2)
			{
				if(isset($week[0])&&isset($week[1]))
				{
					if($week[0]=='week')
					{
						$week_number=$week[1];
						if(is_numeric($week_number))
						{	
							$week_number='-'.$week_number;
							$result['date']=date('Y-m-d', strtotime($week_number.' week'));
							$time=time();
							$result['today']=date('Y-m-d', $time);
						}
						else
						{
							return false;
						}
					}
					else
					{
						return false;
					}

				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

	}


return $result;
			

}


//run the queries of income/expense in the database

public function income_expense_query($data, $phone_no)
{

	$date=$data['date'];
	$today=$data['today'];
	$type_income=$data['type_income'];
	$sex='Cow';

	if($type_income=='all')
		{

			$query_income=$this->db->query("SELECT sum(amount) as income_total
				FROM income WHERE phone_no='$phone_no' and type_income='Income' AND
				date BETWEEN '$date' AND '$today' ");

			$query_expense=$this->db->query("SELECT sum(amount) as expense_total
				FROM income WHERE phone_no='$phone_no' and type_income='Expense' AND
				date BETWEEN '$date' AND '$today' ");

			
			if(($query_income->num_rows()>0)|| ($query_expense->num_rows()>0))
			{
				$result=$query_income->row();
				$income=$result->income_total;
				
				$result=$query_expense->row();
				$expense=$result->expense_total;
				$profit=$income-$expense;

				return $info='Total Income='.$income.' Total Expense='.$expense.' Profit='.$profit;
				
			}
			else
			{

				return false;
			}

		}
		else
		if($type_income=='income')
		{

			$query_income=$this->db->query("SELECT sum(amount) as income_total
				FROM income WHERE phone_no='$phone_no' and type_income='Income' AND
				date BETWEEN '$date' AND '$today' ");
			
			if($query_income->num_rows()>0)
			{
				$result=$query_income->row();
				$income=$result->income_total;
		
				return $info='Total Income='.$income;
				
			}
			else
			{

				return false;
			}


		}
		else
			if ($type_income=='expense') {


			$query_expense=$this->db->query("SELECT sum(amount) as expense_total
				FROM income WHERE phone_no='$phone_no' and type_income='Expense' AND
				date BETWEEN '$date' AND '$today' ");

			
			if($query_expense->num_rows()>0)
			{
				
				$result=$query_expense->row();
				$expense=$result->expense_total;

				return $info='Total Expense='.$expense;
			}
			else
			{

				return false;
			}

		}
		else
		{
			return false;
		}

}






//check if the phone number exists
 public function check_if_user_exists($phone_no)
 {
 	$query=$this->db->query("SELECT fname FROM users WHERE phone_no='$phone_no'");

 	if($query->num_rows()>0)
 	{
 		$result=$query->row();
		return $result_query['fname']=$result->fname;
 	}
 return false;

 }



















//Reminder Query

	public function get_reminder_details($date)
	{
		$query=$this->db->query("SELECT phone_no,activity, description FROM reminder WHERE date_remind='$date'");

		if($query->num_rows()>0)
		{
			return $result=$query->result_array();
		}
		else

		{
			return;
		}

	}
	


	}
