<?

class Reminder_handle extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->process_reminders();
		
	}


	public function process_reminders()
	{

		$this->load->model('smsmodel');
		$this->load->model('sendsms');

		$date=date('Y-m-d', strtotime('+1 day'));

		$result=$this->smsmodel->get_reminder_details($date);

		if(!empty($result))
		{

			foreach ($result as $reminder) {

				$activity=$reminder['activity'];
				$msg=$reminder['description'];
				$sender=$reminder['phone_no'];
				$this->load->helper('date');
				$format='DATE_RFC850';
				$time=time();
				$time=standard_date($format, $time);

				$msg_send="Reminder activity, Subject: ".$activity.",Description- ".$msg.", Tomorrow ".$date.".Sent at".$time
				."Admin @Dairy online";

				if($this->sendsms->ozekiSend($sender, $msg_send, true))
				{
					echo "Sms sent";
				}

			}

		}





	}








}
