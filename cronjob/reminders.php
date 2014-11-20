<?

include 'sendsms.php';

$database='onlineDairy';
$username='root';
$password='1234pass';
$server='localhost';
//connecting to the database
if(!($conn=mysql_connect($server, $username, $password))||!mysql_select_db($database))
{
	
	echo 'Error Connecting to the database'.mysql_error();

}
else
{
	$date=date('Y-m-d', strtotime('+1 day'));

	$query="SELECT phone_no,activity, description FROM reminder WHERE date_remind='$date'";
	
	if($result=mysql_query($query))
	{
		$num_rows=mysql_num_rows($result);
		
		if($num_rows>0)
		{
			
			for($i=0;$i<$num_rows;$i++)
			{
				$reminder=mysql_fetch_row($result);
				$activity=$reminder[1];
				$msg=$reminder[2];
				$sender=$reminder[0];
				$time=time();
				 $time=date("Y-M-d,@ H:m:s", $time);

				$msg_send="Reminder activity, Subject: ".$activity.",Description- ".$msg.", Tomorrow ".$date.".Sent at".$time
				."Admin @Dairy online";

				if(ozekiSend($sender, $msg_send, true))
				{
					echo "Sent<br/>";
				}
			}
		  
		}
		else
		{
			return false;
		}
		
	}



}






?>
