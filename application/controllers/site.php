<?php
class Site extends CI_Controller{

 	function __construct()
	{
	
		 parent::__construct();
		 $this->_is_login_in();
	}


	function _is_login_in()
	{

		$is_login['user_id']=$this->session->userdata('user_id');
		$is_login['status']=$this->session->userdata('is_login_in');
		if(!empty($is_login['status']) && !empty($is_login['user_id']) && isset($is_login['status'])
			&& isset($is_login['user_id']))
		{
			redirect('dashboard/dash');
		}
		
		

	}

	
	

	//home page
	public function home()
	{
	$data['result']="";
	$data['data_page']='';
	$data['pagination']="";
	$data['main_content']='home_view';
	$data['active']='home';
	$this->load->view('include/template', $data);
	}

	//information page

	public function information()
	{
	$data['result']="";
	$data['data_page']='';
	$data['pagination']="";
	$data['main_content']='information';
	$data['active']='info';
	$this->load->view('include/template', $data);
	}


	///////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Register function///////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	public function register()
	{
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('fname', 'first name', 'htmlspecialchars|xss_clean|trim|required|max_length[20]');
		$this->form_validation->set_rules('sname', 'second name', 'htmlspecialchars|xss_clean|trim|required|max_length[20]');
		$this->form_validation->set_rules('phoneno', 'phone number', 'htmlspecialchars|xss_clean|trim|required|exact_length[9]|numeric|is_unique[users.phone_no]');
		if($this->form_validation->run()==FALSE)
		{
			$data['result']="";
			$data['pagination']="";
			$data['data_page']='';
			$data['main_content']='register_view';
			$data['active']='';
			$this->load->view('include/template', $data);
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		}
		else
		{
			$fname=$this->input->post('fname' );
			$sname=$this->input->post('sname');
			$gender=$this->input->post('gender');
			$phoneno='+254'.$this->input->post('phoneno');
			$password=rand(10000,99999);

			$this->load->helper('date');
			$format='DATE_RFC850';
			$time=time();
			$time=standard_date($format, $time);
			$msg='Your password to login is '.$password.' Thank you '.$fname.'for signing up Dairy records at '.$time.'^Admin';
			
			$data = array(
   				'phone_no' => $phoneno ,
				 'fname' => $fname ,
				  'sname' => $sname,
				  'gender'=> $gender,
				  'password' => md5($password));

			$this->load->model('login_model');

			if($this->login_model->insert_data($data))
			{
				$this->load->model('sendsms');
				if($this->sendsms->ozekiSend($phoneno, $msg, true))
				{
					echo ("<SCRIPT LANGUAGE='JavaScript'>
			        window.alert('Password Has been Sent to Your Phone!....Login')
			        window.location.href='http://localhost/record/index.php/site/login'
			        </SCRIPT>");

				}
			}
			else
			{
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			        window.alert('User Already Registered!')
			        window.location.href='http://localhost/record/index.php/site/login'
			        </SCRIPT>");
			}
			


		}
	}

	///////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Login function////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function login()
		{

			$this->load->model('login_model');
			$this->load->library('form_validation');

			$this->form_validation->set_rules('phoneno', 'Phone Number', 'htmlspecialchars|xss_clean|numeric|exact_length[9]|trim');
			$this->form_validation->set_rules('password', 'Password', 'htmlspecialchars|xss_clean||trim|numeric|exact_length[5]|md5');

			if($this->form_validation->run()==FALSE)
			{
				$data['result']="";
				$data['pagination']="";
				$data['main_content']='login_view';
				$data['data_page']='';
				$data['active']='login';
				$this->load->view('include/template', $data);

			}
			else
			{
				$data['phone_no']='+254'.$this->input->post('phoneno');
				$data['password']=$this->input->post('password');
				$results=$this->login_model->get_login_data($data);

				if(!empty($results))
				{
					$user_id=$results['user_id'];
					$fname=$results['fname'];
					$phoneno=$results['phone_no'];
					
					$sessiondata=array('user_id' => $user_id , 'is_login_in' => 'true', 'fname'=>$fname, 
						'phone_no'=>$phoneno);
					$this->session->set_userdata($sessiondata);
					
					redirect('dashboard/location_details');
					
						
					
				}
				else
				{
					echo "<script type='text/javascript'>
					
					alert('Invalid Password or Phone Number Combination');

					</script>";
					$data['result']="";
					$data['pagination']="";
					$data['data_page']='';
					$data['active']='login';
					$data['main_content']='login_view';
					$this->load->view('include/template', $data);
				}
				
			}	
		}
	


	///////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////Forgot password function///////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////
		function forgot_password()
		{	
			//$this->load->view('forgotpassword_view');
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('fname', 'first name', 'htmlspecialchars|xss_clean|trim|required|max_length[20]');
			$this->form_validation->set_rules('sname', 'second name', 'htmlspecialchars|xss_clean|trim|required|max_length[20]');
			$this->form_validation->set_rules('phoneno', 'phone number', 'htmlspecialchars|xss_clean|trim|required|exact_length[9]|numeric');
			if($this->form_validation->run()==FALSE)
			{
				$data['result']="";
				$data['data_page']='';
				$data['pagination']="";
				$data['main_content']='forgotpassword_view';
				$data['active']='';
				$this->load->view('include/template', $data);
			}
			else
			{
				$data['fname']=$this->input->post('fname' );
				$data['sname']=$this->input->post('sname');
				$data['phone_no']='+254'.$this->input->post('phoneno');
				$this->load->model('login_model');
				$result=$this->login_model->checkuser($data);

				if($result=='true')
				{
					$password=rand(10000,99999);
					$this->load->helper('date');
					$format='DATE_RFC850';
					$time=time();
					$time=standard_date($format, $time);
					$msg='Your password has been reset. New Password is '.$password.' Thank you '.$data['fname'].'
					for using  Dairy Online records. '.$time.'^Admin';
					$data_reset = array(
	   				'phone_no' => $data['phone_no'] ,
					  'password' => md5($password));

					if(($this->login_model->update_reset_password($data_reset))==true)
					{
						
						$this->load->model('sendsms');
						$this->sendsms->ozekiSend($data_reset['phone_no'], $msg, true);	

					echo ("<SCRIPT LANGUAGE='JavaScript'>
			        window.confirm('Password Reset sent successfully');
			        window.location.href='http://localhost/record/index.php/site/login'
			        </SCRIPT>");

						
					}
				}
				else
				{
					echo "Invalid User details";
					echo ("<SCRIPT LANGUAGE='JavaScript'>
			        window.confirm('Invalid User details');
			        window.location.href='http://localhost/record/index.php/site/forgot_password'
			        </SCRIPT>");

				}
			}
		}


}