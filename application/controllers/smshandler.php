<?

class Smshandler extends CI_Controller{

	public function __construct(){
		parent::__construct();
	

	}



	public function process_sms()
	{

	$msgdata=strtolower($this->input->get('msgdata', true));
	$sender=$this->input->get('sender', true);
	$receiver=$this->input->get('receiver', true);
	//$recvtime=$this->input->get('recvtime');
	//$msgid=$this->input->get('msgid');

	$this->load->model('smsmodel');
	$this->load->model('sendsms');


		$data_msg= array('sender' => $sender, 
				'receiver' => $receiver,
				'msg' => $msgdata
			);


	$fname=$this->smsmodel->check_if_user_exists($sender);

	if(!empty($fname))
	{
		$msg=$this->process_string($msgdata, $sender, $fname);


		if(empty($msg))
		{	
			$msg='Incorrect Syntax, Send help to check the syntax';
			$this->sendsms->ozekiSend($sender, $msg, true);
			$this->smsmodel->invalid_message($data_msg);
		}
		else
		{

			$data= array('receiver' => $sender, 
				'sender' => $receiver,
				'msg' => $msg
			);

			//send the sms to farmer
			$this->sendsms->ozekiSend($sender, $msg, true);
			//store the sent sms
			$this->smsmodel->sent_message($data);
			//store the received sms
			$this->smsmodel->received_message($data_msg);
		}
	}
	else
	{

		$msg="No such a user, Kindly Register Dairy Online to enjoy storage of cow records";
		//send sms of invalid user.
		$this->sendsms->ozekiSend($sender, $msg, true);
	}

	
	}
	//end of process sms




//Process the string message
	public function process_string($data, $phone_no, $fname)
	{

	$this->load->model('smsmodel');

		$msg=explode(' ', $data);
		switch ($msg[0]) {

			case 'u':

				$result=$this->smsmodel->process_updates($data, $phone_no);	
				if(empty($result))
				{
					return false;
				}	
				else
				{
					return $result;
				}					
				break;

			case 'q':

				return $result=$this->smsmodel->process_queries($data, $phone_no, $fname);
				break;

			case 'help':

				return 	$syntax="Get list of your cows, send word: cows
				,to update milk record morning and evening send: u milk m=? e=? cow_id date[YYYY-MM-DD],
					to update income/expense: u income/expense amount description date,
					to add a reminder: u reminder date activity description,
					to Query Milk Records:q milk total/average date/monthly/weekly/week=? cow_id/all,
					to Query Income/Expense Profit, expenses &income: q all daily/weekly/monthly/week=?/date,
					to Query Income or Expense: q income/expense, monthly/daily/weekly/week=?/date,
					NOTE, NOT CASE SENSTIVE
					";
					break;

			case 'cows':

				$result=$this->smsmodel->farmer_cows($phone_no);

				if(!empty($result))
				{
					$list='Your Cow Id include: ';
					foreach ($result as $cow) {
						
						$list.=$cow['cow_id'].', ';
					}

				return $list;
				}
				else
				{
					return $list="No Cow Registered Yet";
				}
				break;

			default:
			return;
			break;

		
		}
	}

		




}