<?

Class Dashboard extends CI_Controller
{

	function __construct()
	{
	
		 parent::__construct();
		 $this->_is_login_in();

	}


//check if the session is started
	function _is_login_in()
	{

		$is_login['user_id']=$this->session->userdata('user_id');
		$is_login['status']=$this->session->userdata('is_login_in');
		if(!empty($is_login['status']) && !empty($is_login['user_id']) && isset($is_login['status'])
			&& isset($is_login['user_id']))
		{
			anchor('dashboard/logout','Logout');
		}
		else
		{
			redirect('site/login');
		}
		
	}
	//logout function
	function logout()
	{
		$this->session->unset_userdata('user_id', 'is_login_in');
		$this->session->sess_destroy();
		redirect('site/login');
	}

//home page
function dash()
{	
	$cow=$this->input->get('id', TRUE);
	$this->load->model('dashboard_model');
	$phone_no=$this->session->userdata('phone_no');

	$cow_decrypt=$this->encrypt->decode($cow);
	$result=$this->dashboard_model->dash_cow_details($cow, $phone_no);
	
	$data['result']="";
	$data['pagination']="";
	$data['data_page']=$result;
	$data['active']="home";
	
	$data['result_profile']=$this->dashboard_model->load_user_profile($phone_no);
	
	$data['main_content']='dash/home_view';
	$this->load->view('include/template', $data);

}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////LOCATION DETAILS//////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//location view
function location_view()
{
	$data['result']="";
	$data['pagination']="";
	$data['data_page']='';
	$data['active']='';
	$data['result_profile']='';
	$data['main_content']='register_farmer_view';
	$this->load->view('include/template', $data);

}
//location details posting to the database
function location_details_submit()
{
	$this->load->library('form_validation');

	$this->form_validation->set_rules('county', 'County', 'htmlspecialchars|xss_clean|max_length[30]|trim');
	$this->form_validation->set_rules('district', 'District', 'htmlspecialchars|xss_clean|max_length[40]|trim');
	$this->form_validation->set_rules('location', 'Location', 'htmlspecialchars|xss_clean|max_length[40]|trim');
	$this->form_validation->set_rules('area', 'Area/Village', 'htmlspecialchars|xss_clean|max_length[40]|trim');

	if($this->form_validation->run()==true)
	{
		$this->load->model('login_model');

		$data_location['county']=$this->input->post('county');
		$data_location['district']=$this->input->post('district');
		$data_location['location']=$this->input->post('location');
		$data_location['area']=$this->input->post('area');
		$data_location['phone_no']=$this->session->userdata('phone_no');

		
		
		if($this->login_model->location_details($data_location)==true)
		{
				$data['confirm']=1;
				$data['phone_no']=$data_location['phone_no'];
				$this->login_model->confirm_account($data);

				echo ("<SCRIPT LANGUAGE='JavaScript'>
			        window.alert('Record Saved Succesfully')
			        window.location.href='http://localhost/record/index.php/dashboard/dash'
			        </SCRIPT>");
		}
		else
		{
			$this->location_view();

		}

	}
	else
	{

		$this->location_view();
	}
}

//check Login details
function location_details()
	{
		$this->load->model('login_model');

		echo $data['fname']=$this->session->userdata('fname');
		echo $data['user_id']=$this->session->userdata('user_id');
		echo $data['phone_no']=$this->session->userdata('phone_no');

		$results=$this->login_model->get_confirm_status($data);
		$confirm=$results['confirmed_login'];
			if($confirm==0)
			{
				redirect('dashboard/location_view');	
			}
			else
			{
				redirect('dashboard/dash');
			}

	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////COW REGISTER//////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//load register cow view
function cow_register($offset=0)
{
	$limit=10;
	$this->load->model('dashboard_model');
	$phone_no=$this->session->userdata('phone_no');
	$results=$this->dashboard_model->search_cow_details($limit, $offset, $phone_no);

	$data['result_profile']=$this->dashboard_model->load_user_profile($phone_no);
	
		$data['total']=$results['num_rows'];
		$data['result']=$results['rows'];
		//pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('dashboard/cow_register');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $limit; 
		$config['uri_segment']=3;
		$config['full_tag_open'] = "<p class='well' >";
		$config['full_tag_close'] = '<p>';
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		$data['data_page']='';
		$data['active']="cow_register";
		$data['main_content']='dash/register_cow_view';
		$this->load->view('include/template', $data);
	

}

//Registering a cow
function register_cow()
{
	$this->load->model('dashboard_model');
	$this->load->library('form_validation');
	$phone_no=$this->session->userdata('phone_no');
	
	$this->form_validation->set_rules('cow_id', 'Cow id', 'max_length[10]|trim|htmlspecialchars|xss_clean|required|is_unique[cow_detail.cow_id]');
	$this->form_validation->set_rules('dob', 'Date of Birth', '|trim|max_length[10]|required|
										callback_validate_date|callback_less_today');
	$this->form_validation->set_rules('sex', 'Sex', 'trim|max_length[8]|required');
	$this->form_validation->set_rules('breed', 'Breed', 'trim|max_length[20]|required');


	if($this->form_validation->run()==FALSE)
	{
		
		/*$data['result']="";
			$data['pagination']="";
			$data['main_content']='dash/register_cow_view';
			$this->load->view('include/template', $data);*/
			$this->cow_register();
	}
	else
	{
		$cow_id=strtoupper($this->input->post('cow_id'));
		$cow_id=explode(' ', $cow_id);
		$cow_id=implode('', $cow_id);

		$dob=$this->input->post('dob');
		$sex=$this->input->post('sex');
		$breed=$this->input->post('breed');
		

		$data=array('cow_id'=>$cow_id,
			'dateofbirth'=>$dob,
			'sex'=> $sex,
			'breed'=> $breed,
			'phone_no'=>$phone_no
			);

		if($this->dashboard_model->add_cow_record($data))
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Record Added')
        window.location.href='http://localhost/record/index.php/dashboard/cow_register'
        </SCRIPT>");

		}
		else
		{
			echo "Error while Updating Check The Cow Id";
		}
		
	}



}

//Updating cow details
function update_cow_detail()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('dob', 'Date of Birth', '|trim|max_length[10]|required|callback_validate_date
										|callback_less_today');
	$this->form_validation->set_rules('sex', 'Sex', 'trim|max_length[8]|required');
	$this->form_validation->set_rules('breed', 'Breed', 'htmlspecialchars|xss_clean|trim|max_length[20]|required');

	if($this->form_validation->run()==FALSE)
	{
		redirect('dashboard/cow_register');
	}
	else
	{
		$cow_id=$this->input->post('cow_id');
		$dob=$this->input->post('dob');
		$sex=$this->input->post('sex');
		$breed=$this->input->post('breed');

		$data=array('cow_id'=>$cow_id,
			'dateofbirth'=>$dob,
			'sex'=> $sex,
			'breed'=> $breed,
			);

		if($this->dashboard_model->update_cow_details($data))
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully updated')
        window.location.href='http://localhost/record/index.php/dashboard/cow_register'
        </SCRIPT>");
		}
		else
		{
			echo "Record updated Error******";
		}


	}


}
//displaying details to update
function get_update_details()
{
	$data['cow_id']=$this->input->post('cow_id');
	$this->load->model('dashboard_model');

	$result=$this->dashboard_model->get_cow_id_details($data);

	if(!empty($result))
	{	
		
		echo "<form name='update_cow' action='http://localhost/record/index.php/dashboard/update_cow_detail' method='post'
		onsubmit='return Check_Update_Cow()' role='form' class='form-horizontal'>";
		echo form_hidden('cow_id', $result['cow_id']);
		echo "<hr/>";
		echo "<label>Sex</label>";
		echo "<select type='text' name='sex' class='form-control' hidden>
		<option value=".$result['sex'].">".$result['sex']."</option>
		</select>";
		echo "<label>Breed</label>";
		echo "<input type='text' name='breed' value=".$result['breed']." class='form-control'>";
		echo "<label>Date of Birth</label>";
		echo "<input type='date' name='dob' value=".$result['dateofbirth']." class='form-control'>";
		echo "<hr />";
		echo "<button type='submit' class='btn btn-default'>Update</button>";
		echo form_close();
	}


}

//Delete cow record
function veiw_delete_details()
{
	$data['cow_id']=$this->input->post('cow_id');
	$this->load->model('dashboard_model');

	$result=$this->dashboard_model->get_cow_id_details($data);

	if(!empty($result))
	{	
		echo form_open('dashboard/delete_cow_record');
		echo form_hidden('cow_id', $result['cow_id']);
		echo "<div class='well'>";
		echo "<label>Sex&nbsp&nbsp</label>";
		echo $result['sex'];
		echo "<label>Date Of Birth&nbsp&nbsp&nbsp</label>";
		echo $result['dateofbirth'];
		echo "<label>Breed&nbsp&nbsp&nbsp</label>";
		echo $result['breed'];
		echo "</div>";
		echo "<hr/>";
		echo "<button id='delete_cow' type='submit' class='btn btn-default'>Delete</button>";
		echo form_close();
	}


}

//delete cow record

function delete_cow_record()
{
	$data['cow_id']=$this->input->post('cow_id');
	$this->load->model('dashboard_model');

	$result=$this->dashboard_model->delete_cow_record_model($data);

	if(!empty($result))
	{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Record Deleted')
        window.location.href='http://localhost/record/index.php/dashboard/cow_register'
        </SCRIPT>");
	}
	else
	{
		echo "Problem in Deleting Record";
	}

}




function check_if_cow_id_exists()
{
	$cow_id=strtoupper($this->input->post('cow_id'));
	$this->load->model('dashboard_model');

	$result=$this->dashboard_model->check_if_cow_id_exists($cow_id);

	if(!empty($result))
	{
		echo true;
	}
	else
	{
		echo false;
	}



}


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////MILK RECORD/////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//Display Milk Page
function milk_page($offset=0)
{
	$limit=10;
	$this->load->model('dashboard_model');
	$phone_no=$this->session->userdata('phone_no');
	$results=$this->dashboard_model->search_milk_details($limit, $offset, $phone_no);

	$data['result_profile']=$this->dashboard_model->load_user_profile($phone_no);
	
		$data['total']=$results['num_rows'];
		$data['result']=$results['rows'];
		//pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('dashboard/milk_page');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $limit; 
		$config['uri_segment']=3;
		$config['full_tag_open'] = "<p class='well' >";
		$config['full_tag_close'] = '<p>';
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

	$data['data_page']=$this->dashboard_model->get_cow_milk_valid();
	$data['active']="milk_page";
	$data['main_content']='dash/milk_view';
	$this->load->view('include/template', $data);
}

//Milk add 
function milk_add()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('milk_cow_id', 'Cow Identification', 'htmlspecialchars|xss_clean|trim|max_length[10]|required');
	$this->form_validation->set_rules('evening_amount', 'Evening Amount', 'htmlspecialchars|xss_clean|trim|numeric|required');
	$this->form_validation->set_rules('morning_amount', 'Morning Amount', 'htmlspecialchars|xss_clean|trim|numeric|required');
	$this->form_validation->set_rules('milk_date', 'Date of Milk', 'htmlspecialchars|xss_clean|trim|max_length[10]|
								required|callback_validate_date|callback_less_today');

	if($this->form_validation->run()==FALSE)
	{
		$this->milk_page();
	}
	else
	{
		$cow_id=$this->input->post('milk_cow_id');
		$morning_amount=$this->input->post('morning_amount');
		$evening_amount=$this->input->post('evening_amount');
		$milk_date=$this->input->post('milk_date');

		$data=array(
			'cow_id'=> $cow_id,
			'evening_amount'=>$evening_amount,
			'morning_amount'=>$morning_amount,
			'date_cow'=> $milk_date
			);

		if($this->dashboard_model->insert_milk_record($data))
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Added')
        window.location.href='http://localhost/record/index.php/dashboard/milk_page'
        </SCRIPT>");
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Duplicate Entry....Error')
        window.location.href='http://localhost/record/index.php/dashboard/milk_page'
        </SCRIPT>");
		}
	}
}
//show Date
function show_date()
	{
		$cow_id=$this->input->post('cow_id');
		$this->load->model('dashboard_model');
		$result=$this->dashboard_model->show_date($cow_id);
		if(!empty($result))
		{
			echo "<label>Select Date</label>";

			echo "<select class='form-control' onchange='Show_milk_record(this.value, select_id.value)'>";
			echo "<option></option>";
			foreach($result as $row)
			{
				echo "<option value=".$row['date_cow'].">".$row['date_cow']."</option>";
			}
			echo "</select>";
		echo "<hr>";

		}
		else
		{
			echo "Nothing";
		}

	}

function display_milk_update()
	{	
		$data['cow_id']=$this->input->post('cow_id');
		$data['date_cow']=$this->input->post('date');
		$this->load->model('dashboard_model');
		$result=$this->dashboard_model->show_milk_update($data);
	
		if(!empty($result))
		{	
		
		echo '<form name="milk_update" action="http://localhost/record/index.php/dashboard/update_milk_record" method="post"
		onsubmit="return Check_milk_update()" role="form" class="form-horizontal">';
		echo form_hidden('cow_id', $result['cow_id']);
		echo form_hidden('milk_id', $result['milk_id']);
		echo "<label>Morning Amount</label>";
		echo "<input type='text' name='morning_amount' class='form-control' value=".$result['morning_amount']."><br/>";
		echo "<label>Evening Amount</label>";
		echo "<input type='text' name='evening_amount'class='form-control' value=".$result['evening_amount']." ><br/>";
		echo "<label>Date of Milking</label>";
		echo "<input type='date' name='date_cow' class='form-control' value=".$result['date_cow']."><br/>";
		echo "<button type='submit' class='btn btn-default'>Update</button>";
		echo validation_errors('<span class="errors" style="color: red">', '</span');
		echo form_close();
		}
		else
		{
			echo "ERROR".mysql_error();
		}	
	}

function update_milk_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('cow_id', 'Cow Identification', 'htmlspecialchars|xss_clean|trim|max_length[10]|required');
	$this->form_validation->set_rules('milk_id', 'Milk Identification', 'htmlspecialchars|xss_clean|trim|numeric|required');
	$this->form_validation->set_rules('morning_amount', 'MilK amount Morning', 'htmlspecialchars|xss_clean|trim|numeric|required');
	$this->form_validation->set_rules('date_cow', 'Date', 'htmlspecialchars|xss_clean|trim|required|
										callback_validate_date|callback_less_today');
	$this->form_validation->set_rules('evening_amount', 'MilK amount Evening', 'htmlspecialchars|xss_clean|trim|numeric|required');

	if($this->form_validation->run()==FALSE)
	{
		redirect('dashboard/milk_page');
	}
	else
	{
		$data['cow_id']=$this->input->post('cow_id');
		$milk_id=$this->input->post('milk_id');
		$data['morning_amount']=$this->input->post('morning_amount');
		$data['evening_amount']=$this->input->post('evening_amount');
		$data['date_cow']=$this->input->post('date_cow');

		$result=$this->dashboard_model->update_milk_record($data, $milk_id);
		if($result)
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Updated')
        window.location.href='http://localhost/record/index.php/dashboard/milk_page'
        </SCRIPT>");
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Unsuccesfully in  Updating Record')
        window.location.href='http://localhost/record/index.php/dashboard/milk_page'
        </SCRIPT>");
		}
	}
}

function delete_milk_record()
	{
		$milk_id=$this->input->post('milk_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->delete_milk_record($milk_id);
		if($result)
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Record Deleted')
        window.location.href='http://localhost/record/index.php/dashboard/milk_page'
        </SCRIPT>");
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Unable to delete Record')
        window.location.href='http://localhost/record/index.php/dashboard/milk_page'
        </SCRIPT>");
		}

	}

function analysis_milk_record()
	{
		$to_date=$this->input->post('to');
		$from_date=$this->input->post('from');
		$cow_id=$this->input->post('cow');
		$price=$this->input->post('price');
		$phone_no=$this->session->userdata('phone_no');

		$this->load->model('dashboard_model');
		$result=$this->dashboard_model->analysis_milk_model($to_date, $from_date, $cow_id, $price, $phone_no);

		echo "<div class='well'>";
		if(!empty($result))
		{
			echo "<div class=''></br></br>";
			echo "<b>Total Morning&Evening=</b>&nbsp".$sum=$result['t_amount'];
			echo "<br/>";
			echo "<b>AVERAGE Morning and Evening=</b>&nbsp".$result['avg_amount']/2;
			echo "<br/>";
			echo "<b>AVERAGE Evening=</b>&nbsp".$result['avge_amount'];
			echo "<br/>";
			echo "<b>AVERAGE Morning Amount=</b>&nbsp".$result['avgm_amount'];
			echo "<br/>";
			echo "<b>Total Morning Amount=</b>&nbsp".$result['sm_amount'];
			echo "<br/>";
			echo "<b>Total Evening Amount=</b>&nbsp".$result['se_amount'];
			echo "<br/>";
			echo '<b>Price Of Milk=</b>'.$price;
			echo "<br/>";
			echo "<b>Total Income Morning&Evening=</b>&nbsp".$result['t_income'];
			echo "</div>";
			
		}
		else
		{
			echo "No Record Found";
		}
		echo "</div>";
	}

	function display_milk_graph()
	{

		$cow_id=$this->input->post('cow_id');
		$cow_id_g=$this->session->userdata('Cow_id_graph');
		if(isset($cow_id_g))
		{
			$this->session->unset_userdata('Cow_id_graph');
		}

		$this->session->set_userdata('Cow_id_graph', $cow_id);

	}


////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////FEED RECORDS //////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//main page
function feed_page($offset=0)
{
	$limit=5;
	$this->load->model('dashboard_model');
	$phone_no=$this->session->userdata('phone_no');
	$results=$this->dashboard_model->search_feed_details($limit, $offset, $phone_no);

	$data['result_profile']=$this->dashboard_model->load_user_profile($phone_no);
	
		$data['total']=$results['num_rows'];
		$data['result']=$results['rows'];
		//pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('dashboard/feed_page');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $limit; 
		$config['uri_segment']=3;
		$config['full_tag_open'] = "<p class='well' >";
		$config['full_tag_close'] = '<p>';
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

	$data['data_page']=$this->dashboard_model->get_cow_id_milk($phone_no, '');
	$data['active']="feed_page";
	$data['main_content']='dash/feed_view';
	$this->load->view('include/template', $data);
}

// add feed record

function add_feed_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('cow_id', 'Cow Identification', 'htmlspecialchars|xss_clean||trim|max_length[10]|required');
	$this->form_validation->set_rules('type_feed', 'Feed Type', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('amount_feed', 'Feed Amount', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('date_feed', 'Date of Feeding', 'htmlspecialchars|xss_clean|trim|max_length[10]|
		required|callback_validate_date|callback_less_today');

	if($this->form_validation->run()==FALSE)
	{
		$this->feed_page();
	}
	else
	{
		$cow_id=$this->input->post('cow_id');
		$type_feed=$this->input->post('type_feed');
		$amount_feed=$this->input->post('amount_feed');
		$date_feed=$this->input->post('date_feed');

		$data=array(
			'cow_id'=> $cow_id,
			'type_feed'=>$type_feed,
			'amount_feed'=>$amount_feed,
			'feed_date'=> $date_feed
			);

		if($this->dashboard_model->add_feed_record($data))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Added')
        window.location.href='http://localhost/record/index.php/dashboard/feed_page'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Duplicated Error...')
        window.location.href='http://localhost/record/index.php/dashboard/feed_page'
        </SCRIPT>");
		}
	}
}

//show date for the feed record

function show_feed_date()
	{
		$cow_id=$this->input->post('cow_id');
		$this->load->model('dashboard_model');
		$result=$this->dashboard_model->show_feed_date($cow_id);
		if(!empty($result))
		{
			echo "<label>Select Date</label>";

			echo "<select class='form-control' onchange='Update_feed_record(this.value, cow_id_feed.value)'>";
			echo "<option></option>";
			foreach($result as $row)
			{
				echo "<option value=".$row['feed_date'].">".$row['feed_date']."</option>";
			}
			echo "</select>";
		echo "<hr>";

		}
		else
		{
			echo "Nothing";
		}

	}


//function to display update the feed record after editing

function display_feed_update()
{
	
		$data['cow_id']=$this->input->post('cow_id');
		$data['feed_date']=$this->input->post('date_feed');
		$this->load->model('dashboard_model');
		$result=$this->dashboard_model->update_feed_data($data);
	
		if(!empty($result))
		{	
		
		echo "<form name='feed_update' action='http://localhost/record/index.php/dashboard/update_feed_record' method='post'
		onsubmit='return Check_feed_update()' role='form' class='form-horizontal'>";
		echo form_hidden('feed_id', $result['feed_id']);
		echo "<label>Type of Feed</label>";
		echo "<input type='text' name='type_feed' class='form-control' value=".$result['type_feed']."><br/>";
		echo "<label>Amount of Feed</label>";
		echo "<input type='text' name='amount_feed'class='form-control' value=".$result['amount_feed']." ><br/>";
		echo "<label>Date of Feeding</label>";
		echo "<input type='date' name='feed_date' class='form-control' value=".$result['feed_date']."><br/>";
		echo "<button type='submit' class='btn btn-default'>Update</button>";
		echo form_close();
		}
		else
		{
			echo "ERROR".mysql_error();
		}	

}

//function to update the feed record after editing

	function update_feed_record()
	{

	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('type_feed', 'Feed Type', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('amount_feed', 'Feed Amount', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('feed_date', 'Date of Feeding', 'htmlspecialchars|xss_clean|trim|
		max_length[10]|required|callback_validate_date|callback_less_today');

	if($this->form_validation->run()==FALSE)
	{
		redirect('dashboard/feed_page');
	}
	else
	{
		$feed_id=$this->input->post('feed_id');
		$type_feed=$this->input->post('type_feed');
		$amount_feed=$this->input->post('amount_feed');
		$date_feed=$this->input->post('feed_date');

		$data=array(

			'type_feed'=>$type_feed,
			'amount_feed'=>$amount_feed,
			'feed_date'=> $date_feed
			);

		if($this->dashboard_model->update_feed_record($data, $feed_id))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Updated')
        window.location.href='http://localhost/record/index.php/dashboard/feed_page'
        </SCRIPT>");
			
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Error in Updating')
        window.location.href='http://localhost/record/index.php/dashboard/feed_page'
        </SCRIPT>");
		}
	}

	}

	//Delete feed record

	function delete_feed_record()
	{
		$feed_id=$this->input->post('feed_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->delete_feed_record($feed_id);
		if($result)
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Record Deleted')
        window.location.href='http://localhost/record/index.php/dashboard/milk_page'
        </SCRIPT>");
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Unable to delete Record')
        window.location.href='http://localhost/record/index.php/dashboard/milk_page'
        </SCRIPT>");
		}

	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////INSEMINATION////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//main page
function insemination_page($offset=0)
{
	$limit=5;
	$this->load->model('dashboard_model');
	$phone_no=$this->session->userdata('phone_no');
	$results=$this->dashboard_model->search_insemination_details($limit, $offset, $phone_no);

	$data['result_profile']=$this->dashboard_model->load_user_profile($phone_no);
	
		$data['total']=$results['num_rows'];
		$data['result']=$results['rows'];
		//pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('dashboard/insemination_page');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $limit; 
		$config['uri_segment']=3;
		$config['full_tag_open'] = "<p class='well' >";
		$config['full_tag_close'] = '<p>';
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

	$data['data_page']=$this->dashboard_model->get_cow_insemination_valid();
	$data['active']="health_page";
	$data['main_content']='dash/insemination_view';
	$this->load->view('include/template', $data);
}

//Add a new Insemination record
function add_insemination_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('cow_id', 'Cow Identification', 'htmlspecialchars|xss_clean||trim|max_length[10]|required');
	$this->form_validation->set_rules('date_insemination', 'Insemination Date', 'htmlspecialchars|xss_clean|trim|required
		|callback_validate_date|callback_less_today');
	$this->form_validation->set_rules('time_insemination', 'Insemination Time', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('method_insemination', 'Insemination Method', 'htmlspecialchars|xss_clean|trim|max_length[10]|required');
	$this->form_validation->set_rules('bull_breed_source', 'Bull Breed Source', 'htmlspecialchars|xss_clean|trim|required|max_length[20]');
	$this->form_validation->set_rules('doctor', 'Inseminator name', 'htmlspecialchars|xss_clean|trim|max_length[20]|required');

	if($this->form_validation->run()==FALSE)
	{
		$this->insemination_page();
	}
	else
	{
		$cow_id=$this->input->post('cow_id');
		$date=$this->input->post('date_insemination');
		$time=$this->input->post('time_insemination');
		$method=$this->input->post('method_insemination');
		$bull_source=$this->input->post('bull_breed_source');
		$doctor=$this->input->post('doctor');

		$data=array(
			'cow_id'=> $cow_id,
			'date_insemination'=>$date,
			'time_insemination'=>$time,
			'method_insemination'=> $method,
			'bull_breed_source'=> $bull_source,
			'doctor'=> $doctor
			);

		if($this->dashboard_model->add_insemination_record($data))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Added')
        window.location.href='http://localhost/record/index.php/dashboard/insemination_page'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Duplicated Error...')
        window.location.href='http://localhost/record/index.php/dashboard/insemination_page'
        </SCRIPT>");
		}
	}
}

//show date for the INSEMINATION record

function show_insemination_date()
	{
		$cow_id=$this->input->post('cow_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->show_insemination_date($cow_id);
		if(!empty($result))
		{
			echo "<label>Select Date</label>";

			echo "<select class='form-control' 
			onchange='Update_insemination_record(this.value, cow_id_insemination.value)'>";
			echo "<option></option>";
			foreach($result as $row)
			{
				echo "<option value=".$row['date_insemination'].">".$row['date_insemination']."</option>";
			}
			echo "</select>";
		echo "<hr>";

		}
		else
		{
			echo "Nothing";
		}

	}


//function to display update the feed record after editing

function display_insemination_update()
{
	
		$data['cow_id']=$this->input->post('cow_id');
		$data['date_insemination']=$this->input->post('date_insemination');
		$this->load->model('dashboard_model');
		$result=$this->dashboard_model->update_insemination_data($data);
	
		if(!empty($result))
		{	

		
		echo "<form name='ins_update' action='http://localhost/record/index.php/dashboard/update_insemination_record' method='post'
		onsubmit='return Check_ins_update()' role='form' class='form-horizontal'>";

		echo form_hidden('insemination_id', $result['insemination_id']);
		echo "<div>
		<div class='col-md-6'>";
		echo "<label>Date Of Insemination</label>";
		echo "<input type='date' name='date_insemination' value=".$result['date_insemination']." 
		class='form-control col-sm-4' required placeholder='Insemination Date' />
		<br />";
		echo "</div> 
		<div class='col-md-6'>";
		echo "<label>Time of Insemination</label>";
		echo "<input type='time' name='time_insemination' value=".$result['time_insemination']."
		class='form-control col-sm-4' required placeholder='Insemination Time' />";
		echo "</div>";
		echo "</div>";

		echo "<label>Method Of Insemination : </label>";
		echo "<label>Natural</label>";
		echo "<input type='radio' name='method_insemination' value='Natural'  />";
		echo "<label>Artificial</label>";
		echo "<input type='radio' name='method_insemination' value='Artificial' checked='true' /><br />";
		echo "<label>Bull Breed Source</label>";
		echo "<input type='text' name='bull_breed_source' value=".$result['bull_breed_source']."
		class='form-control col-sm-4' required placeholder='Bull Breed Source' /><br />";

		echo "<label>Inseminator</label>";
		echo "<input type='text' name='doctor' value=".$result['doctor']."
		class='form-control col-sm-4' required placeholder='Inseminator Name'  />
		<br /><br /><br />";
		echo "<button type='submit' class='btn btn-default'>Update</button>";
		echo form_close();
		
		}
		else
		{
			echo "ERROR".mysql_error();
		}	

}

//function to update the feed record after editing

function update_insemination_record()
{

	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('date_insemination', 'Insemination Date', 'htmlspecialchars|xss_clean|trim|
		required|callback_validate_date|callback_less_today');
	$this->form_validation->set_rules('time_insemination', 'Insemination Time', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('method_insemination', 'Insemination Method', 'htmlspecialchars|xss_clean|trim|max_length[10]|required');
	$this->form_validation->set_rules('bull_breed_source', 'Bull Breed Source', 'htmlspecialchars|xss_clean|trim|required|max_length[20]');
	$this->form_validation->set_rules('doctor', 'Inseminator name', 'htmlspecialchars|xss_clean|trim|max_length[20]|required');

	if($this->form_validation->run()==FALSE)
	{
		$this->insemination_page();
	}
	else
	{
		$insemination_id=$this->input->post('insemination_id');
		$date=$this->input->post('date_insemination');
		$time=$this->input->post('time_insemination');
		$method=$this->input->post('method_insemination');
		$bull_source=$this->input->post('bull_breed_source');
		$doctor=$this->input->post('doctor');

		$data=array(
			'date_insemination'=>$date,
			'time_insemination'=>$time,
			'method_insemination'=> $method,
			'bull_breed_source'=> $bull_source,
			'doctor'=> $doctor
			);

		if($this->dashboard_model->update_insemination_record($data, $insemination_id))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Updated')
        window.location.href='http://localhost/record/index.php/dashboard/insemination_page'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Error Updating...')
        window.location.href='http://localhost/record/index.php/dashboard/insemination_page'
        </SCRIPT>");
		}
	}
	
}

//Delete Insemination Record

function delete_insemination_record()
	{
		$insemination_id=$this->input->post('insemination_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->delete_insemination_record($insemination_id);
		if($result)
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Record Deleted')
        window.location.href='http://localhost/record/index.php/dashboard/insemination_page'
        </SCRIPT>");
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Unable to delete Record')
        window.location.href='http://localhost/record/index.php/dashboard/insemination_page'
        </SCRIPT>");
		}

	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////HEALTH RECORDS//////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////

//main page
function health_page($offset=0)
{
	$limit=5;
	$this->load->model('dashboard_model');
	$phone_no=$this->session->userdata('phone_no');
	$results=$this->dashboard_model->search_health_details($limit, $offset, $phone_no);

	$data['result_profile']=$this->dashboard_model->load_user_profile($phone_no);

	
		$data['total']=$results['num_rows'];
		$data['result']=$results['rows'];
		//pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('dashboard/health_page');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $limit; 
		$config['uri_segment']=3;
		$config['full_tag_open'] = "<p class='well' >";
		$config['full_tag_close'] = '<p>';
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
	

	$data['data_page']=$this->dashboard_model->get_cow_id_milk($phone_no,'');
	
	$data['active']="health_page";
	$data['main_content']='dash/health_view';
	$this->load->view('include/template', $data);
}

//Add a health record
function add_health_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('cow_id', 'Cow Identification', 'htmlspecialchars|xss_clean|trim|max_length[10]|required');
	$this->form_validation->set_rules('date_treatment', 'Treatment Date', 'htmlspecialchars|xss_clean|trim|required
		|callback_validate_date|callback_less_today');
	$this->form_validation->set_rules('symptoms', 'Symptoms', 'htmlspecialchars|xss_clean|trim');
	$this->form_validation->set_rules('type_treatment', 'Treatment Type', 'htmlspecialchars|xss_clean|trim|max_length[15]|required');
	$this->form_validation->set_rules('remarks', 'Remarks', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('treatment', 'Treatment', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('veterinary', 'Veterinary Name', 'htmlspecialchars|xss_clean|trim|required');

	if($this->form_validation->run()==FALSE)
	{
		$this->health_page();
	}
	else
	{
		$data=array();
		$data['cow_id']=$this->input->post('cow_id');
		$data['symptoms']=$this->input->post('symptoms');
		$data['type_treatment']=$this->input->post('type_treatment');
		$data['treatment']=$this->input->post('treatment');
		$data['remarks']=$this->input->post('remarks');
		$data['date_treatment']=$this->input->post('date_treatment');
		$data['veterinary']=$this->input->post('veterinary');


		if($this->dashboard_model->add_health_record($data))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Added')
        window.location.href='http://localhost/record/index.php/dashboard/health_page'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Duplicated Error...')
        window.location.href='http://localhost/record/index.php/dashboard/health_page'
        </SCRIPT>");
		}
	}
}
//show date for the INSEMINATION record

function show_health_date()
	{
		$cow_id=$this->input->post('cow_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->show_health_date($cow_id);
		if(!empty($result))
		{
			echo "<label>Select Date</label>";

			echo "<select class='form-control' 
			onchange='Update_health_record(this.value, cow_id_health.value)'>";
			echo "<option></option>";
			foreach($result as $row)
			{
				echo "<option value=".$row['date_treatment'].">".$row['date_treatment']."</option>";
			}
			echo "</select>";
		echo "<hr>";

		}
		else
		{
			echo "Nothing";
		}

	}


//function to display update the feed record after editing

function display_health_update()
{
	
	
		$data['cow_id']=$this->input->post('cow_id');
		$data['date_treatment']=$this->input->post('date_treatment');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->update_health_data($data);
	
		if(!empty($result))
		{	

		echo "<form name='health_update' action='http://localhost/record/index.php/dashboard/update_health_record' method='post'
		onsubmit='return Check_health_update()' role='form' class='form-horizontal'>";

		echo form_hidden('health_id', $result['health_id']);
		
		echo "<fieldset class='form-horizontal'>";

		echo "<div class='form-group'>";

		echo "<div class='col-md-6'>";
		echo "<label>Symptoms</label>";
		echo "<textarea class='form-control' rows='2' name='symptoms'  required>
		".$result['symptoms']."
		</textarea>
		</div>";

		echo "<div class='col-md-6'>
		<label >Type of Treatment</label>
		<select class='form-control' name='type_treatment' required>
			<option value='Normal'>Normal</option>
			<option value='Vaccination'>Vaccination</option>
		</select>";

		echo "</div>
		</div>

		<div class='form-group'>

		<div class='col-md-6'>
		<label >Treatment</label>
		<textarea class='form-control' rows='2'name='treatment' required
		>".$result['treatment']."
		</textarea>
		</div>

		<div class='col-md-6'>
		<label>Remarks</label>
		<textarea class='form-control' rows='2' name='remarks' required
		 >".$result['remarks']."</textarea>
		</div>
		</div>
		<br />

		<div class='form-group'>

		<div class='col-md-6'>
		<label>Veterinary Name</label>
		<input type='text' name='veterinary'class='form-control col-sm-4' 
		required placeholder='Veterinary Name' value=".$result['veterinary']." />
		</div>

		<div class='col-md-6'>
		<label>Date Of Treatment</label>
		<input type='date' name='date_treatment' 
		class='form-control col-sm-4' required placeholder='Treatment Date' 
		value=".$result['date_treatment']."
		/>
		</div>
		</div>";

		echo "<button type='submit' class='btn btn-default'>Update</button>";
		echo form_close();
		
		}
		else
		{
			echo "ERROR".mysql_error();
		}	

}


function update_health_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	
	$this->form_validation->set_rules('date_treatment', 'Treatment Date', 'htmlspecialchars|xss_clean|trim
		|required|callback_validate_date|callback_less_today');
	$this->form_validation->set_rules('symptoms', 'Symptoms', 'htmlspecialchars|xss_clean|trim');
	$this->form_validation->set_rules('type_treatment', 'Treatment Type', 'htmlspecialchars|xss_clean|trim|max_length[15]|required');
	$this->form_validation->set_rules('remarks', 'Remarks', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('treatment', 'Treatment', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('veterinary', 'Veterinary Name', 'htmlspecialchars|xss_clean|trim|required');

	if($this->form_validation->run()==FALSE)
	{
		$this->health_page();
	}
	else
	{
		$data=array();
		$health_id=$this->input->post('health_id');
		$data['symptoms']=$this->input->post('symptoms');
		$data['type_treatment']=$this->input->post('type_treatment');
		$data['treatment']=$this->input->post('treatment');
		$data['remarks']=$this->input->post('remarks');
		$data['date_treatment']=$this->input->post('date_treatment');
		$data['veterinary']=$this->input->post('veterinary');


		if($this->dashboard_model->update_health_record($data, $health_id))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Added')
        window.location.href='http://localhost/record/index.php/dashboard/health_page'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Duplicated Error...')
        window.location.href='http://localhost/record/index.php/dashboard/health_page'
        </SCRIPT>");
		}
	}
}


//Delete Health Record

function delete_health_record()
	{
		$health_id=$this->input->post('health_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->delete_health_record($health_id);
		if($result)
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Record Deleted')
        window.location.href='http://localhost/record/index.php/dashboard/health_page'
        </SCRIPT>");
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Unable to delete Record')
        window.location.href='http://localhost/record/index.php/dashboard/health_page'
        </SCRIPT>");
		}

	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////CALVING RECORDS///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

//main page
function calving_page($offset=0)
{
	$limit=5;

	$this->load->model('dashboard_model');
	$phone_no=$this->session->userdata('phone_no');
	$results=$this->dashboard_model->search_calving_details($limit, $offset, $phone_no);

	$data['result_profile']=$this->dashboard_model->load_user_profile($phone_no);
	
		$data['total']=$results['num_rows'];
		$data['result']=$results['rows'];
		//pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('dashboard/calving_page');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $limit; 
		$config['uri_segment']=3;
		$config['full_tag_open'] = "<p class='well' >";
		$config['full_tag_close'] = '<p>';
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
	
	$data['data_page']=$this->dashboard_model->get_cow_calving_valid();
	$data['active']="health_page";
	$data['main_content']='dash/calving_view';
	$this->load->view('include/template', $data);
}

//Add a calving record
function add_calving_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('cow_id', 'Cow Identification', 'htmlspecialchars|xss_clean|trim|max_length[10]|required');
	$this->form_validation->set_rules('calf_id', 'Calf Identification', 'htmlspecialchars|xss_clean|trim|required|max_length[10]');
	$this->form_validation->set_rules('method_calving', 'calving Method', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('remarks', 'Remarks', 'htmlspecialchars|xss_clean|trim|required');
	

	if($this->form_validation->run()==FALSE)
	{
		$this->calving_page();
	}
	else
	{
		$data=array();
		$data['cow_id']=$this->input->post('cow_id');
		$data['calf_id']=$this->input->post('calf_id');
		$data['method_calving']=$this->input->post('method_calving');
		$data['remarks']=$this->input->post('remarks');


		if($this->dashboard_model->add_calving_record($data))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Added')
        window.location.href='http://localhost/record/index.php/dashboard/calving_page'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Duplicated Error...')
        window.location.href='http://localhost/record/index.php/dashboard/calving_page'
        </SCRIPT>");
		}
	}
}


//SHOW CALF IDS 

function show_calf_id_valid()
	{
		$cow_id=$this->input->post('cow_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->show_calf_id_valid($cow_id);
		if(!empty($result))
		{

			foreach($result as $row)
			{
				echo "<option value=".$row['cow_id'].">".$row['cow_id']."</option>";
			}

		}
		else
		{
			echo "<option class='text-danger'>None</option>";
		}

	}



//SHOW CALF IDS 

function show_calf_id()
	{
		$cow_id=$this->input->post('cow_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->show_calf_id($cow_id);
		if(!empty($result))
		{
			echo "<label>Select Calf Id</label>";

			echo "<select class='form-control' 
			onchange='Update_calving_record(this.value, cow_id_calving.value)'>";
			echo "<option></option>";
			foreach($result as $row)
			{
				echo "<option value=".$row['calf_id'].">".$row['calf_id']."</option>";
			}
			echo "</select>";
		echo "<hr>";

		}
		else
		{
			echo "Nothing";
		}

	}

//display update calving record


function display_calving_update()
{
	
	
		$data['cow_id']=$this->input->post('cow_id');
		$data['calf_id']=$this->input->post('calf_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->update_calving_data($data);
	
		if(!empty($result))
		{	

		echo form_open('dashboard/update_calving_record');
		echo form_hidden('calf_id', $result['calf_id']);
		echo "<fieldset class='form-horizontal'>";
		echo "<label>Method of Calving</label>
		<select name='method_calving' class='form-control'>
		<option value=".$result['method_calving'].">current:".$result['method_calving']."</option>
			<option value='Natural'>Natural</option>
			<option value='Surgery'>Ceaserian</option>
		</select>

		<label>Remarks</label>
		<textarea class='form-control' rows='2' name='remarks' value='N/A' required>
		".$result['remarks']."</textarea>

		</fieldset> <br/> 
		";

		echo "<button type='submit' class='btn btn-default'>Update</button>";
		echo form_close();
		
		}
		else
		{
			echo "ERROR".mysql_error();
		}	

}

//Update Calving record
function update_calving_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');

	$this->form_validation->set_rules('calf_id', 'Calf Identification', 'htmlspecialchars|xss_clean|trim|required|max_length[10]');
	$this->form_validation->set_rules('method_calving', 'calving Method', 'htmlspecialchars|xss_clean|trim|required');
	$this->form_validation->set_rules('remarks', 'Remarks', 'htmlspecialchars|xss_clean|trim|required');
	

	if($this->form_validation->run()==FALSE)
	{
		$this->calving_page();
	}
	else
	{
		$data=array();
		$calf_id=$this->input->post('calf_id');
		$data['calf_id']=$this->input->post('calf_id');
		$data['method_calving']=$this->input->post('method_calving');
		
		$data['remarks']=$this->input->post('remarks');


		if($this->dashboard_model->update_calving_record($data, $calf_id))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Added')
        window.location.href='http://localhost/record/index.php/dashboard/calving_page'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Duplicated Error...')
        window.location.href='http://localhost/record/index.php/dashboard/calving_page'
        </SCRIPT>");
		}
	}
}

//Delete Calving Record

function delete_calving_record()
	{
		$calf_id=$this->input->post('calf_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->delete_calving_record($calf_id);
		if($result)
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Record Deleted')
        window.location.href='http://localhost/record/index.php/dashboard/calving_page'
        </SCRIPT>");
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Unable to delete Record')
        window.location.href='http://localhost/record/index.php/dashboard/calving_page'
        </SCRIPT>");
		}

	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////REMINDER RECORDS///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

//main page
function reminders_page($offset=0)
{

	$limit=5;

	$this->load->model('dashboard_model');
	$phone_no=$this->session->userdata('phone_no');

	$results=$this->dashboard_model->search_reminder_details($limit, $offset, $phone_no);

	$data['result_profile']=$this->dashboard_model->load_user_profile($phone_no);
	
		$data['total']=$results['num_rows'];
		$data['result']=$results['rows'];
		//pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('dashboard/reminders_page');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $limit; 
		$config['uri_segment']=3;
		$config['full_tag_open'] = "<p class='well' >";
		$config['full_tag_close'] = '<p>';
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

	$data['data_page']=$this->dashboard_model->get_reminder_number($phone_no);
	$data['active']="reminder";

	$data['main_content']='dash/reminders_view';
	$this->load->view('include/template', $data);
}

//Add a reminder record
function add_reminder_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('activity', 'Activity-Subject', 'htmlspecialchars|xss_clean|trim|max_length[20]|required');
	$this->form_validation->set_rules('description', 'Description', 'htmlspecialchars|xss_clean|trim|required|max_length[50]');
	$this->form_validation->set_rules('activity_date', 'Date of Activity', 'htmlspecialchars|xss_clean|trim|required|
		callback_validate_date|callback_date_valid_reminder');


	if($this->form_validation->run()==FALSE)
	{
		$this->reminders_page();
	}
	else
	{
		$data=array();
		$date=time();
		$set_date=date('Y-m-d', $date);
		$phone_no=$this->session->userdata('phone_no');

		$data['phone_no']=$phone_no;
		$data['date_set']=$set_date;
		$data['date_remind']=$this->input->post('activity_date');
		$data['description']=$this->input->post('description');
		$data['activity']=$this->input->post('activity');


		if($this->dashboard_model->add_reminder_record($data))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Added')
        window.location.href='http://localhost/record/index.php/dashboard/reminders_page'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Duplicated Error...')
        window.location.href='http://localhost/record/index.php/dashboard/reminders_page'
        </SCRIPT>");
		}
	}
}


//validation of date

public function validate_date($date)
{
	$parts = explode("-", $date);

    if (count($parts) == 3) {      
      if (checkdate($parts[1], $parts[2], $parts[0]))
      {
        return TRUE;
      }
    }
    $this->form_validation->set_message('validate_date', 'The Date field must be YYYY-MM-DD');
    return false;
}

//date 
public function less_today($date)
	{
		$day_today=time();
		$date=strtotime($date);
		
		if($date<=$day_today)
		{
			return true;

		}

		 $this->form_validation->set_message('less_today', 'The Date field should be less than today');
		return false;
	}


//check that the activity date is greater than date today
public function date_valid_reminder($date)
	{
		$day_today=time();
		$date=strtotime($date);
		
		if($date>$day_today)
		{
			return true;

		}

		 $this->form_validation->set_message('date_valid_reminder', 'The Date field should be greater than today');
		return false;
	}

//display update remind record


function display_reminder_update()
{
	
	
		$data['reminder_id']=$this->input->post('reminder_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->update_reminder_data($data);
	
		if(!empty($result))
		{	

		
		echo "<form name='reminder_update' action='http://localhost/record/index.php/dashboard/update_reminder_record' method='post'
		onsubmit='return Check_reminder_update()' role='form' class='form-horizontal'>";
		echo form_hidden('reminder_id', $result['reminder_id']);

		echo "<fieldset class='form-horizontal'>
			<label>Activity</label>
			<input type='text' name='activity' value=". $result['activity']." 
			class='form-control col-sm-4' required placeholder='Subject' />		
			<br/>
			<label>Description</label>
			<textarea class='form-control' rows='3'  name='description' required>
			".$result['description']."
			</textarea>

			<label>Activity Date</label>
			<input type='date' name='activity_date' value=".$result['date_remind']." 
			class='form-control col-sm-4' required placeholder='Activity Date' />
			<br /><br /><br />";

		echo "<button type='submit' class='btn btn-default'>Update</button> </fieldset>";
		echo form_close();
		
		}
		else
		{
			echo "ERROR".mysql_error();
		}	

}

//Update reminder record
function update_reminder_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('activity', 'Activity-Subject', 'htmlspecialchars|xss_clean|trim|max_length[20]|required');
	$this->form_validation->set_rules('description', 'Description', 'htmlspecialchars|xss_clean|trim|required|max_length[50]');
	$this->form_validation->set_rules('activity_date', 'Date of Activity', 'htmlspecialchars|xss_clean|trim|required|
		callback_validate_date|callback_date_valid_reminder');


	if($this->form_validation->run()==FALSE)
	{
		$this->reminders_page();
	}
	else
	{
		
		$date=time();
		$set_date=date('Y-m-d', $date);

		$reminder_id=$this->input->post('reminder_id');
		$data=array();
		$data['date_set']=$set_date;
		$data['date_remind']=$this->input->post('activity_date');
		$data['description']=$this->input->post('description');
		$data['activity']=$this->input->post('activity');


		if($this->dashboard_model->update_reminder_record($data, $reminder_id))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Added')
        window.location.href='http://localhost/record/index.php/dashboard/reminders_page'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Duplicated Error...')
        window.location.href='http://localhost/record/index.php/dashboard/reminders_page'
        </SCRIPT>");
		}
	}
}


//Delete Reminder Record
function delete_reminder_record()
	{
		$reminder_id=$this->input->post('reminder_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->delete_reminder_record($reminder_id);
		if($result)
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Record Deleted')
        window.location.href='http://localhost/record/index.php/dashboard/calving_page'
        </SCRIPT>");
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Unable to delete Record')
        window.location.href='http://localhost/record/index.php/dashboard/calving_page'
        </SCRIPT>");
		}

	}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////INCOME AND EXPENSE RECORDS///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

//main page
function income_expense($offset=0)
{

	$limit=5;

	$this->load->model('dashboard_model');
	$phone_no=$this->session->userdata('phone_no');
	
	$results=$this->dashboard_model->search_income_expense_details($limit, $offset, $phone_no);

	$data['result_profile']=$this->dashboard_model->load_user_profile($phone_no);
	
		$data['total']=$results['num_rows'];
		$data['result']=$results['rows'];
		//pagination
		$this->load->library('pagination');

		$config['base_url'] = site_url('dashboard/income_expense');
		$config['total_rows'] = $data['total'];
		$config['per_page'] = $limit; 
		$config['uri_segment']=3;
		$config['full_tag_open'] = "<p class='well' >";
		$config['full_tag_close'] = '<p>';
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

	$data['data_page']=$this->dashboard_model->get_income_number($phone_no);
	$data['active']="income_expense";
	$data['main_content']='dash/income_expense_view';
	$this->load->view('include/template', $data);
}


//Add a income expense record
function add_income_expense_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('type_income', 'Type of Income', 'htmlspecialchars|xss_clean|trim|max_length[20]|required');
	$this->form_validation->set_rules('description', 'Description', 'htmlspecialchars|xss_clean|trim|required|max_length[70]');
	$this->form_validation->set_rules('amount', 'Amount', 'htmlspecialchars|xss_clean|trim|required|numeric');
	$this->form_validation->set_rules('income_date', 'Date', 'htmlspecialchars|xss_clean|trim|required|
		callback_validate_date|callback_less_today');


	if($this->form_validation->run()==FALSE)
	{
		$this->income_expense();
	}
	else
	{
		
		$phone_no=$this->session->userdata('phone_no');

		$data['phone_no']=$phone_no;
		$data['date']=$this->input->post('income_date');
		$data['type_income']=$this->input->post('type_income');
		$data['description']=$this->input->post('description');
		$data['amount']=$this->input->post('amount');


		if($this->dashboard_model->add_income_expense_record($data))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Added')
        window.location.href='http://localhost/record/index.php/dashboard/income_expense'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Duplication Error...')
        window.location.href='http://localhost/record/index.php/dashboard/income_expense'
        </SCRIPT>");
		}
	}
}


function display_income_expense_update()
{
	
	
		$data['income_id']=$this->input->post('income_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->update_income_expense_data($data);
	
		if(!empty($result))
		{	

		echo "<form name='income_update' action='http://localhost/record/index.php/dashboard/update_income_expense_record' method='post'
		onsubmit='return Check_income_update()' role='form' class='form-horizontal'>";
		echo form_hidden('income_id', $result['income_id']);

		echo "<fieldset class='form-horizontal'>

			<legend>Income&Expense</legend>
			<label>Type of income</label>
			<select class='form-control' name='type_income' required autofocus>
				<option value=".$result['type_income']."> current:".$result['type_income']."</option>
				<option value='Income'>Income</option>
				<option value='Expense'>Expense</option>
			</select>
			<br/>
			<label>Description</label>
			<textarea class='form-control' rows='3'  name='description' required>
			".$result['description']."
			</textarea>

			<label>Amount</label>
			<input type='text' name='amount' value=".$result['amount']." 
			class='form-control col-sm-4' required placeholder='Amount' />
			<br />
			<br />
			<label>Date</label>
			<input type='date' name='income_date' value=".$result['date']." 
			class='form-control col-sm-4' required placeholder='Date' />
			<br />
			<br />
		</fieldset>";

		echo "<button type='submit' class='btn btn-default'>Update</button> </fieldset>";
		echo form_close();
		
		}
		else
		{
			echo "ERROR".mysql_error();
		}	

}

//Update income /expense record
function update_income_expense_record()
{
	$this->load->library('form_validation');
	$this->load->model('dashboard_model');
	$this->form_validation->set_rules('type_income', 'Type of Income', 'htmlspecialchars|xss_clean|trim|max_length[20]|required');
	$this->form_validation->set_rules('income_id', 'Income', 'htmlspecialchars|xss_clean|trim|numeric|required');
	$this->form_validation->set_rules('description', 'Description', 'htmlspecialchars|xss_clean|trim|required|max_length[70]');
	$this->form_validation->set_rules('amount', 'Amount', 'htmlspecialchars|xss_clean|trim|required|numeric');
	$this->form_validation->set_rules('income_date', 'Date', 'htmlspecialchars|xss_clean|trim|required|
		callback_validate_date|callback_less_today');


	if($this->form_validation->run()==FALSE)
	{
		redirect('dashboard/income_expense');
	}
	else
	{
		
		$income_id=$this->input->post('income_id');
		$data=array();
		$data['date']=$this->input->post('income_date');
		$data['type_income']=$this->input->post('type_income');
		$data['description']=$this->input->post('description');
		$data['amount']=$this->input->post('amount');


		if($this->dashboard_model->update_income_expense_record($data, $income_id))
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Succesfully Updated')
        window.location.href='http://localhost/record/index.php/dashboard/income_expense'
        </SCRIPT>");
		}
		else
		{
		echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Error...')
        window.location.href='http://localhost/record/index.php/dashboard/income_expense'
        </SCRIPT>");
		}
	}
	
}


//Delete Reminder Record
function delete_income_expense_record()
	{
		$income_id=$this->input->post('income_id');
		$this->load->model('dashboard_model');

		$result=$this->dashboard_model->delete_income_expense_record($income_id);
		if($result)
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Record Deleted')
        window.location.href='http://localhost/record/index.php/dashboard/calving_page'
        </SCRIPT>");
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Unable to delete Record')
        window.location.href='http://localhost/record/index.php/dashboard/calving_page'
        </SCRIPT>");
		}

	}

//analysis for income record
function analysis_income_record()
	{
		
		$to_date=$this->input->post('to');
		$from_date=$this->input->post('from');
		$phone_no=$this->session->userdata('phone_no');

		$this->load->model('dashboard_model');
		$result=$this->dashboard_model->analysis_income_model($to_date, $from_date, $phone_no);

		if(!empty($result))
		{
		

			$Profit=$result['income']-$result['expense'];
			$ProfitAVG=$result['income_avg']-$result['expense_avg'];

			echo "<div class='background_home'>";
			echo "<br/>";
			echo "<b>Total Expense Amount=</b>&nbsp".$result['expense'];
			echo "<br/>";
			echo "<b>Total Income Amount=</b>&nbsp".$result['income'];
			echo "<br/>";
			echo "<b>AVERAGE Income Amount=</b>&nbsp".$result['income_avg'];
			echo "<br/>";
			echo "<b>AVERAGE Expense Amount=</b>&nbsp".$result['expense_avg'];
			echo "<br/>";
			echo "<b>Profit =</b>&nbsp".$Profit;
			echo "<br/>";
			echo "<b>AVERAGE Profit=</b>&nbsp".$ProfitAVG;
			echo "<br/>";
			
			echo "</div>";
		}
		else
		{
			echo "No Record Found";
		}
	}


//admin page
function admin()
{	
	$phone_no=$this->session->userdata('phone_no');

	if($phone_no!='+254731053591')
	{
		redirect('dashboard/dash');
	}

	$this->load->model('dashboard_model');
	
	
	$data['result']="";
	$data['pagination']="";
	$data['data_page']='';
	$data['active']="";
	$data['result_profile']=$this->dashboard_model->load_user_profile($phone_no);
	
	$data['main_content']='dash/admin_view';
	$this->load->view('include/template', $data);


}



//Delete  user
function delete_user()
	{
		$phone_no=$this->input->post('phone_no');
		$this->load->model('dashboard_model');
		
		$result=$this->dashboard_model->delete_user($phone_no);
		if($result)
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Record Deleted')
        window.location.href='http://localhost/record/index.php/dashboard/admin'
        </SCRIPT>");
		}
		else
		{
			echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Unable to delete Record')
        window.location.href='http://localhost/record/index.php/dashboard/admin'
        </SCRIPT>");
		}

	}












}



