<div class='container-fluid main-view'>
	<div class="row-fluid white_background">
	
<div class='col-sm-push-2 col-sm-8 white_background'>

	<ul class="nav nav-tabs">
 	 <li><a href="#div1_admin" data-toggle="tab">
 	 	<span class='glyphicon glyphicon-plus-sign'></span>Active Users Accounts
 	 </a></li>
  	 <li><a href="#div2_admin" data-toggle="tab">
  	 	
  	 	<span class='glyphicon glyphicon-record'></span>UnActivated User Accounts
  	 </a></li>
 	 <li><a href="#div3_admin" data-toggle="tab">
 	 	
 	 	<span class='glyphicon glyphicon-stats'></span> Maintained Data
 	 </a></li>
	</ul>

  <div class="tab-content">

	<div  id='div1_admin' class="tab-pane fade in active">

		<?
	$result_p=$this->dashboard_model->active_users();

	if(!empty($result_p))
	{

		echo '<h3>Signed Up Users</h3>';
		echo '<hr />';
		echo "<table  class='table table-striped table-hover' id='tblactiveusers'>";
		echo "<thead> <td>First Name</td><td>Second Name</td><td> Phone Number</td><td>Gender</td> <td>Delete</td> </thead>";
		foreach ($result_p as $row) 
		{
			echo "<tr>";
			echo "<td>".$row['fname']."</td>";
			echo "<td>".$row['sname']."</td>";
			echo "<td>".$row['phone_no']."</td>";
			echo "<td>".$row['gender']."</td>";

			echo "<td ><button value=".$row['user_id']."
			 class='delete_user'>
			<span class='glyphicon glyphicon-remove'></span>
			</button></td>";

			echo "</tr>";
	
		}
		echo "</table>";
		
		}
	else
	{
		echo "No Records";
	}

	?>

	<span>
		<a download="activeusers.xls" href="#" 
		onclick="return ExcellentExport.excel(this, "tblactiveusers", "Users");">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>
		
	</div>


	<!--Upating the income and expense record-->
	<div id='div2_admin' class="tab-pane fade">

			<?
	$result_p=$this->dashboard_model->inactive_users();

	if(!empty($result_p))
	{

		echo '<h3> Not Signed Up Users</h3>';
		echo '<hr />';
		echo "<table  class='table table-striped table-hover' id='tblinactiveusers'>";
		echo "<thead> <td>First Name</td><td>Second Name</td><td> Phone Number</td><td>Gender</td> <td>Delete</td> </thead>";
		foreach ($result_p as $row) 
		{ 
			echo "<tr>";
			echo "<td>".$row['fname']."</td>";
			echo "<td>".$row['sname']."</td>";
			echo "<td>".$row['phone_no']."</td>";
			echo "<td>".$row['gender']."</td>";

			echo "<td ><button value=".$row['user_id']."
			 class='delete_user'>
			<span class='glyphicon glyphicon-remove'></span>
			</button></td>";

			echo "</tr>";
	
		}
		echo "</table>";
		
		}
	else
	{
		echo "No Records";
	}

	?>

	<span>
		<a download="activeusers.xls" href="#" 
		onclick="return ExcellentExport.excel(this, "tblinactiveusers", "Users");">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>
		

	</div>

	<!--Analysis Record-->
	<div id='div3_admin' class="tab-pane fade">

	<?
		
		$result_p=$this->dashboard_model->get_admin_details();
		
		echo "<div class='bg-info'>";
		echo "<b> Number of Cows Maintained=".$result_p['number_cows']."</b><br/><br/>";
		echo "<b> Number of Farmers Registered=".$result_p['number_users']."</b>";
		echo "</div>";

	?>

	</div>

	</div>
	</div>


	</div>
</div>

