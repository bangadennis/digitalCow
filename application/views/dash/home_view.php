
<div class="main-view container-fluid">
	<div class="row">
	<div class="col-md-2 home-view-1">
	<h3>Cows</h3>
	

	<?
		$this->load->model('dashboard_model');
		$this->load->library('encrypt');
		$phone_no=$this->session->userdata('phone_no');
		$results=$this->dashboard_model->get_cows($phone_no);
		if(!empty($results))
		{
			echo "<ol>";
			foreach ($results as $cow) {

					$cow_d=$cow['cow_id'];
				//$cow_encrypt=$this->encrypt->encode($cow);
				echo "<li class='link_cow'><a href='http://localhost/record/index.php/dashboard/dash?id=$cow_d'>
				".$cow['cow_id']."</a></li>";
		
			}
			echo "</ol>";
		}
		else
		{
			echo "No Records</br>";
			echo '<a href="http://localhost/record/index.php/dashboard/register_cow">Add Cow Record</a>';

		}

	?>
	
	</div>

<div class="col-md-7 home-view-2">

	<h3>Records</h3>
	<div class="well">
		<h4>Cow</h4>
		<?
			$result_cow=$result['cow_detail'];
			if(!empty($result_cow))
			{
				$cow_detail=$result_cow;

					echo "<h5><em>Cow ID:</em>&nbsp&nbsp".$cow_detail['cow_id'];
					echo "&nbsp&nbsp&nbsp&nbsp&nbsp</h5>";
					echo "<h5><em>Date Of Birth:</em>&nbsp&nbsp".$cow_detail['dateofbirth'];
					echo "&nbsp&nbsp&nbsp&nbsp&nbsp</h5>";
					echo "<h5><em>Breed:</em>&nbsp&nbsp".$cow_detail['breed'];
					echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
					echo "<em>Sex: </em>&nbsp&nbsp".$cow_detail['sex'];
					echo "</h5>";

			}
			else
			{
				echo "Select Cow</br>";

			}
		?>
	</div>
	<!--Milk-->
	<div class="well">
		<h4>Milk</h4>
		
				<?  

			$result_milk=$result['milk'];
			if(!empty($result_milk))
			{
				echo "<div>";
				echo "<table class='table table-striped' id='tblMilk'>";
				echo "<thead> <td>Morning Amount</td> <td>Evening Amount</td> <td>Date</td>
				</thead> <tbody>";
				foreach ($result_milk as $cow_detail) {


					echo "<tr>";
					echo "<td>".$cow_detail['morning_amount']."</td>";
					echo "<td>".$cow_detail['evening_amount']."</td>";
					echo "<td>".$cow_detail['date_cow']."</td>";
					echo "</tr>";

				}
				echo "</tbody> </table></div>";

			}
			else
			{
				echo "<span id='nomilkrecord'>No Records</span><br/>";
				echo '<a href="http://localhost/record/index.php/dashboard/milk_page"> Add Milk Record</a>';
			}
		?>
		<br/>
		<span id='exportMilk'>
		<a download='<? echo $cow_detail['cow_id']; ?>Milkdata.xls' href="#" 
		onclick="return ExcellentExport.excel(this, 'tblMilk', 'Milk');">
		<span class='glyphicon glyphicon-export'>
		Export Milk Excel</a>
		</span>

	</div>

	<div class="well">
		<!--Insemination sidebar-->
	<h4>Insemination</h4>
		<?
			$insemination=$result['insemination'];
			if(!empty($insemination))
			{

				echo "<table class='table table-striped' id='tblIns'>";
				echo "<thead> <td>Date</td> <td>Time</td> <td>Bull Source</td>
				<td>Veterinary</td>
				</thead>";
				foreach ($insemination as $cow_detail) {


					echo "<tr>";
					echo "<td>".$cow_detail['date_insemination']."</td>";
					echo "<td>".$cow_detail['time_insemination']."</td>";
					echo "<td>".$cow_detail['bull_breed_source']."</td>";
					echo "<td>".$cow_detail['doctor']."</td>";
					echo "</tr>";

				}
				echo "</table>";
			}
			else
			{
				echo "No Records<br/>";
				echo '<a href="http://localhost/record/index.php/dashboard/insemination_page"> Add Insemination Record</a>';
			}
		?>
		<br/>
		<span>
		<a download='<? echo $cow_detail['cow_id']; ?>Inseminationdata.xls' href="#" 
		onclick="return ExcellentExport.excel(this, 'tblIns', 'Insemination');">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>
	</div>

	<!--Calving sidebar-->
		<div class="well">

		<h4>Calving</h4>
		<?
			$calving=$result['calving'];
			if(!empty($calving))
			{

				echo "<table class='table table-striped' id='tblcalving'>";
				echo "<thead> <td>Calf</td>  <td>Method</td>
				<td>Remarks</td>
				</thead>";
				foreach ($calving as $cow_detail) {


					echo "<tr>";
					echo "<td>".$cow_detail['calf_id']."</td>";
					echo "<td>".$cow_detail['method_calving']."</td>";
					echo "<td>".$cow_detail['remarks']."</td>";
					echo "</tr>";

				}
				echo "</table>";
			}
			else
			{
				echo "No Records<br/>";
				echo '<a href="http://localhost/record/index.php/dashboard/calving_page">Add Calving Record</a>';
			}
		?>
		<br/>
		<span>
		<a download='<? echo $cow_detail['cow_id']; ?>calvingdata.xls' href="#" 
		onclick="return ExcellentExport.excel(this, 'tblcalving', 'Calving');">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>
		</div>

		<!--Health-->
	<div class="well">
		<h4>Health</h4>
		<?
			$health=$result['health'];
			if(!empty($health))
			{

				echo "<table class='table table-striped' id='tblhealth'>";
				echo "<thead> <td>Symptoms</td> <td>Type Treatment</td> <td>Treatment</td>
				<td>Veterinary</td><td>Treatment Date</td><td>Remarks</td>
				</thead>";
				foreach ($health as $cow_detail) {


					echo "<tr>";
					echo "<td>".$cow_detail['symptoms']."</td>";
					echo "<td>".$cow_detail['type_treatment']."</td>";
					echo "<td>".$cow_detail['treatment']."</td>";
					echo "<td>".$cow_detail['veterinary']."</td>";
					echo "<td>".$cow_detail['date_treatment']."</td>";
					echo "<td>".$cow_detail['remarks']."</td>";
					echo "</tr>";

				}
				echo "</table>";
			}
			else
			{
				echo "No Records<br/>";
				echo '<a href="http://localhost/record/index.php/dashboard/health_page">Add Health Record</a>';
			}
		?> 
		<br/>
		<span>
		<a download='<? echo $cow_detail['cow_id']; ?>healthdata.xls' href="#" 
		onclick="return ExcellentExport.excel(this, 'tblhealth', 'Calving');">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>
	</div>
	<!--Feeding-->
	<div class="well">
		<h4>Feeding</h4>
		<?
			$feed=$result['feed'];
			if(!empty($feed))
			{

				echo "<table class='table table-striped' id='tblfeed'>";
				echo "<thead> <td>Type Of Feed</td> <td>Amount of Feed</td> <td>Date Of Feeding</td>
				</thead>";
				foreach ($feed as $cow_detail) {


					echo "<tr>";
					echo "<td>".$cow_detail['type_feed']."</td>";
					echo "<td>".$cow_detail['amount_feed']."</td>";
					echo "<td>".$cow_detail['feed_date']."</td>";
					echo "</tr>";

				}
				echo "</table>";
			}
			else
			{
				echo "No Records<br/>";
				echo '<a href="http://localhost/record/index.php/dashboard/feed_page">Add Feeding Record</a>';
			}
		?>

		<br/>
		<span>
		<a download='<? echo $cow_detail['cow_id']; ?>Feeddata.xls' href="#" 
		onclick="return ExcellentExport.excel(this, 'tblfeed', 'Feed');">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>

	</div>

<!--Income & expenses-->
<h2>User Record</h2>
	<div class="well">
		<h4>Financial Record</h4>
		<?
			$finance=$result['finance'];
			if(!empty($feed))
			{

				echo "<table class='table table-striped' id='tblIncome'>";
				echo "<thead> <td>Date</td> <td>Type</td> <td>amount</td>
				 <td>Description</td>
				</thead>";
				foreach ($finance as $cow_detail) {


					echo "<tr>";
					echo "<td>".$cow_detail['date']."</td>";
					echo "<td>".$cow_detail['type_income']."</td>";
					echo "<td>".$cow_detail['amount']."</td>";
					echo "<td>".$cow_detail['description']."</td>";
					echo "</tr>";

				}
				echo "</table>";
			}
			else
			{
				echo "No Records<br/>";
				echo '<a href="http://localhost/record/index.php/dashboard/income_expense">Add Financial Record</a>';
			}
		?>

		<br/>
		<span>
		<a download='<? echo $cow_detail['cow_id']; ?>Feeddata.xls' href="#" 
		onclick="return ExcellentExport.excel(this, 'tblfeed', 'Feed');">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>

	</div>


</div>

<!--Recent Sms Updates-->
<div class="col-md-3 home-view-3">
	<h3><span class='glyphicon glyphicon-comment'>SMS-Dashboard</h3>
	

<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
        <?  $count=$this->dashboard_model->get_count_response_sms();

         ?>
          <h5>Invalid SMS Query/Updates
          	 <span class="badge pull-right"><? echo $count['count_invalid']; ?></span>
          </h5>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body background-white">
      <?

		$invalid=$this->dashboard_model->get_invalid_sms();
	if(!empty($invalid))
	{
		foreach ($invalid as $row) {
			echo "<div class='well'>";
			echo "Message:".$row['msg'];
			echo "<br/>";
			echo "Receiver:".$row['receiver'];
			echo "<br>Date:".$row['date'];
			echo "</div>";
			
		}
	}



	?>
     
      </div>
    </div>
  </div>

<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapsetwo">
          <h5>System Sent Sms Response
          <span class="badge pull-right"><? echo $count['count_response']; ?></span>
          </h5>
        </a>
      </h4>
    </div>
    <div id="collapsetwo" class="panel-collapse collapse">
      <div class="panel-body backgroud-white">
     	
		<?

		$response=$this->dashboard_model->get_response_sms();
			if(!empty($response))
			{
				foreach ($response as $row) {
					echo "<div class='well'>";
					echo "Message:".$row['msg'];
					echo "<br/>";
					echo "Receiver:".$row['receiver'];
					echo "<br>Date:".$row['date'];
					echo "</div>";
					
				}
			}



		?>
	
     
      </div>
    </div>
  </div>


  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapsethree">
          <h5>Valid SMS Queries/Updates
          <span class="badge pull-right"> <? echo $count['count_received']; ?>
          </span></h5>

        </a>
      </h4>
    </div>
    <div id="collapsethree" class="panel-collapse collapse">
      <div class="panel-body background-white">
     	
		<?

		$response=$this->dashboard_model->get_received_sms();
			if(!empty($response))
			{
				foreach ($response as $row) {
					echo "<div class='well'>";
					echo "Message:".$row['msg'];
					echo "<br/>";
					echo "Receiver:".$row['receiver'];
					echo "<br>Date:".$row['date'];
					echo "</div>";
					
				}
			}

		?>
	
     
      </div>
    </div>
  </div>



  </div>

	
</div>

</div>
</div>
