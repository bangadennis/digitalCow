<!--Geting data from the jason table-->

<!--Drawing Line graph using Google Line Chart-->
 <script type="text/javascript">
 <? $jsonTable=$this->dashboard_model->graph_data();?> 
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable?>);

        var options = {
          title: 'Milk Production Daily',
          width: 870,
		  height: 600
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

<!--Main Milk page -->
<!--Holder of the body contents-->
<div class='container-fluid main-view' id='cow_detail'>
	<div class="row-fluid">

	<div class='col-xs-12 col-sm-6 col-md-6 side-view-1'>
<!--Buttons for add, analysis, update and delete-->
	<ul class="nav nav-tabs">
	  <li><a href="#add_div" data-toggle="tab">
	  <button class="btn btn-success btn-default btn_black" >
	  <span class='glyphicon glyphicon-plus-sign'>Add</button></a></li>
	  <li><a href="#update_div" data-toggle="tab">
	  <button class="btn btn-success btn-default btn_black">
	  <span class='glyphicon glyphicon-record'>Update</button></a></li>
	  <li><a href="#analysis_div" data-toggle="tab">
	  <button class="btn btn-success btn-default btn_black">
	  <span class='glyphicon glyphicon-stats'>Analytics</button></a></li>
	  <li><a href="#graph_div" data-toggle="tab">
	  <button class="btn btn-success btn-default btn_black">
	  <span class='glyphicon glyphicon-stats'>Graphical Analytics</button></a></li>
	</ul>

<!--The tabs-->
	<div class="tab-content">
<!--Add pane-->
	<div  id='add_div'  class="tab-pane fade in active">
		
	<form name='milk_form' action="<? echo site_url('dashboard/milk_add');?>" method='post'
		onsubmit='return Check_milk_form()' role='form' class='form-horizontal'>

		<label>Select Cow Id to Update Record</label>
		<label>Cow Identification Number</label>

		<select name='milk_cow_id' class="form-control" required autofocus>
		<? echo "<option value=''></option>"; ?>
		<? foreach($result as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>
		<label>Time Period of Milking</label><br/>
		<!--<select name='milk_time' class="form-control" required>
			<option value=''></option>
			<option value='morning'>Morning</option>
			<option value="evening">Evening</option>
		</select>-->
		<label>Morning Amount</label>
		<input type='text' name='morning_amount' value="<? echo set_value('morning_amount') ?>" class='form-control col-sm-4' required placeholder='Milk Amount Litres' /><br />
		<span id='form_error_morning' style='color: red'></span>
		<br />
		<label>Evening Amount</label>
		<input type='text' name='evening_amount' value="<? echo set_value('evening_amount') ?>" class='form-control col-sm-4' required placeholder='Milk Amount Litres' /><br />
		<span id='form_error_evening' style='color: red'></span>
		<br/>
		<label><span class='glyphicon glyphicon-calendar'></span>Date of Milking</label>
		<input type='date' name='milk_date' id='milk_date' value="<? echo set_value('milk_date') ?>" class='form-control col-sm-4' required /><br />
		<br/>
		<span id='form_milk_date' style='color: red'></span>
		<br />
		<br />
		<button type='submit' class='btn btn-default'>Add</button>
		<? echo validation_errors('<span class="errors" style="color: red">', '</span')?>
		<?php echo form_close(); ?>
	</div>

	<!--Upating the cow detail record-->

	<div id='update_div'  class="tab-pane fade">
	<?
	$phone_no=$this->session->userdata('phone_no');
	 $result_update=$this->dashboard_model->get_cow_id_update($phone_no, 'milkrecord', 'Female');
	?>
	<label>Select Cow Id to Update Record</label>
		<label>Cow Identification Number</label>
		<select id='select_id' class="form-control" onchange="Show_date(this.value)"
		required autofocus>
		<? echo "<option value=''></option>"; ?>
		<? foreach($result_update as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>
		<div id='date_update'></div>
		
		<div id='update_record'></div>
		
    </div>

	<!--Analysis Record-->
	<div id='analysis_div'  class="tab-pane fade">

	<form class="form-horizontal">
		<label><span class='glyphicon glyphicon-calendar'></span>From Date</label>
		<input type='date' id='from_date' value="<? echo set_value('from_date') ?>"
		 class='form-control' required placeholder='From Date' autofocus/><br />

		<label><span class='glyphicon glyphicon-calendar'></span>To Date</label>
		<input type='date' id='to_date' value="<? echo set_value('from_date') ?>"
		 class='form-control' required placeholder='From Date' /><br />

		<!--Hold the Cow Identification and Price of Milk-->
		<div>

		<div class="col-md-6">
		<label>Price Of Milk per Litre</label>
		<input type='text' id='price_milk' value='0' maxlength="5" 
		 class='form-control' required placeholder='Milk Price per Litre' />
		</div>

		<div class="col-md-6">
		<label>Cow Identification Number</label>
		<select id='cow_analysis' class="form-control" onchange="Show_total_milk(cow_analysis.value, 
		from_date.value, to_date.value, price_milk.value)">
		<? echo "<option value=''>None</option>"; ?>
		<? //echo "<option value='ALL'>ALL</option>"; ?>
		<? foreach($result_update as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>
		</div>
		
		</div>
		<!--Display analysis results-->
		<div id='analysis_results'></div>
		</form>
	</div>

	<!--Graph representation pane-->
	<div id='graph_div'  class="tab-pane fade">

		<label>Cow Identification Number</label>

		<select id='cow_graph' class="form-control" onchange="Show_analysis_graph(this.value)">
		<? echo "<option value=''>None</option>"; ?>
		<? echo "<option value='ALL'>ALL</option>"; ?>
		<? foreach($result_update as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>
		<? 

		$Cow_id=$this->session->userdata('Cow_id_graph');
		if(isset($Cow_id))
		{
			echo "<h4>Graph For Cow ID= ".$Cow_id."</h4>";
		}
		else
		{
			echo "No Cow Selected";
		}

		?>
		<!--Show the graph cow curve-->
		<br />
		<button class="btn btn-success" data-toggle="modal" data-target="#myGraph">Show Graph</button>
	</div>

	</div>
	</div>

	<!--Cow Milk Records uploaded, displayed in table form-->
	<div class="col-xs-12 col-sm-6 col-md-6 side-view-2">

 
	<?
	if(!empty($result_p))
	{

		if(strlen($pagination))
		{
			echo $pagination;
		}
		echo '<h3>Milk Record</h3>';
		echo '<hr />';
		echo anchor('dashboard/milk_page', "<span class='glyphicon glyphicon-refresh'></span>");
		echo "<table  class='table table-striped table-hover' id='tblmilkall'>";
		echo "<thead> <td>Cow_id</td><td>Morning Milk(Litres)</td><td>Evening Milk(Litres)</td><td>Date</td></thead>";
		foreach ($result_p as $row) 
		{
			$cow_d=$row['cow_id'];
			echo "<tr>";
			echo "<td><a href='http://localhost/record/index.php/dashboard/dash?id=$cow_d'>
				".$row['cow_id']."</a></td>";
			echo "<td>".$row['morning_amount']."</td>";
			echo "<td>".$row['evening_amount']."</td>";
			echo "<td>".$row['date_cow']."</td>";
			echo "<td ><button value=".$row['milk_id']." class='delete_milk'>
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
		<a download="allMilkdata.xls" href="#" 
		onclick="return ExcellentExport.excel(this, 'tblmilkall', 'AllMilk')">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
	</span>
	
	</div>
</div>
</div>
<!--End of the Milk page-->

<!--Modal milk graph-->

		<div class="modal fade" id="myGraph" tabindex="-1" role="dialog" aria-labelledby="myGraphLabel" aria-hidden="true">
			  <div class="modal-dialog myProfile modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myGraphLabel">Milk Production Graphical Representation</h4>
			      </div>
			      <div class="modal-body">

			      	<div id="chart_div" class="background_home"></div>

			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       <!-- <button type="button" class="btn btn-primary">Save changes</button>-->
			      </div>
			    </div>
			  </div>
		  </div>

