<html>
<head>
<?
echo "<meta http-equiv='refresh' content='0.99'>";
?>
<title>My Blog</title>
</head>
<body>
<?

// $this->load->model('sendsms');

$time=time();
echo $time1=strtotime('2014-02-17 21:02:26');echo "<br />";
echo $time2=strtotime('2014-02-17 22:07:30'); echo "<br />";
echo $time;
if($time===$time2)
{
	$data=array('fname' =>'Kibokodd', 'sname' => 'Yako');
	//$this->db->set('fname', 'Kiboko');
	$this->db->where('phone_no','+254222222222');
	$this->db->update('users', $data);
	//$this->db->insert('users');
	echo 'hello';

}
else
{
	echo 'kenya';
}




?>


	</h1>
</body>
</html>
