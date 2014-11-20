<?

$is_login['user_id']=$this->session->userdata('user_id');
$is_login['status']=$this->session->userdata('is_login_in');
if(!empty($is_login['status']) && !empty($is_login['user_id']) && isset($is_login['status'])
			&& isset($is_login['user_id']))
{
$data_active['active']=$active;
$data_active['result_profile']=$result_profile;

$this->load->view('include/header_logged_in', $data_active);
}
else
{
	$data_active['active']=$active;
	$this->load->view('include/header');
}

$data['result_p']=$result;
$data['result']=$data_page;
$data['pagination']=$pagination;
$this->load->view($main_content, $data);


$this->load->view('include/footer');