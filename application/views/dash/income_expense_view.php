<!--Geting data from the jason table-->

<!--Drawing Line graph using Google Line Chart-->
 <script type="text/javascript">
 <? $jsonTable=$this->dashboard_model->graph_data_expense();?> 
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable?>);

        var options = {
          title: 'Expense Analysis',
          width: 700,
		  height: 500
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_expense'));
        chart.draw(data, options);
      }
    </script>

  <script type="text/javascript">
 <? $jsonTable=$this->dashboard_model->graph_data_income();?> 
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable(<?=$jsonTable?>);

        var options = {
          title: 'Income Analysis',
          width: 700,
		  height: 500
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div_income'));
        chart.draw(data, options);
      }
    </script>




<div class='container-fluid main-view' >
	<div class="row-fluid">


	<div class='col-xs-12 col-sm-6 col-md-6 side-view-1'>

	<ul class="nav nav-tabs">
 	 <li><a href="#div1_income_expense" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-plus-sign'></span>Add</button>
 	 </a></li>
  	 <li><a href="#div2_income_expense" data-toggle="tab">
  	 	<button class="btn btn-success btn-default btn_black ">
  	 	<span class='glyphicon glyphicon-record'></span>Update</button>
  	 </a></li>
 	 <li><a href="#div3_income_expense" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-stats'></span>Analytics</button>
 	 </a></li>
 	 <li><a href="#div4_income_expense" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-stats'></span>Graphical Analytics</button>
 	 </a></li>
	</ul>

  <div class="tab-content">
	<div  id='div1_income_expense' class="tab-pane fade in active">
		
		<form name='income_form' action="<? echo site_url('dashboard/add_income_expense_record');?>" method='post'
		onsubmit='return Check_income_form()' role='form' class='form-horizontal'>

		<fieldset class='form-horizontal'>

		<legend>Income and Expense</legend>
		<label>Type</label>
		<select class="form-control" name='type_income' required autofocus>
			<option></option>
			<option value="Income">Income</option>
			<option value="Expense">Expense</option>
		</select>
		<br/>
		<label>Description</label>
		<textarea class="form-control" rows='3'  name='description' required>
		<? echo set_value('description'); ?>
		</textarea>

		<label>Amount</label>
		<input type='text' name='amount' value="<? echo set_value('amount') ?>" 
		class='form-control col-sm-4' required placeholder='Amount in Kshs' />
		<br />
		<br />
		<label>Date</label>
		<input type='date' name='income_date' id='income_date' value="<? echo set_value('income_date') ?>" 
		class='form-control col-sm-4' required placeholder='Date' />
		<br/>
		<span id='form_income_date' style='color: red'></span>
		<br />
		<br />
		<br />
		<button type='submit' class='btn btn-default'>Add</button>
		</fieldset>
		<?php echo form_close(); ?>
		<br />
		<? echo validation_errors('<span class="errors" style="color: red">', '</span'); ?>
		
	</div>


	<!--Upating the income and expense record-->
	<div id='div2_income_expense' class="tab-pane fade">

		<label>Select Income/Expense No. to Update</label>
		<hr />
		<select class="form-control" onchange="Update_income_expense_record(this.value)" 
		required autofocus >
		<? $i=0; ?>
		<? echo "<option value=''></option>"; ?>
		<? foreach($result as $income):?>	
		<? echo"<option value=".$income['income_id'].">"; ?>
		<? echo $i=$i+1; ?> 
		<? echo "</option>"; ?>
		<? endforeach; ?>
		</select>
	
	<div id='update_income_expense_record'></div>


	</div>

	<!--Analysis Record-->
	<div id='div3_income_expense' class="tab-pane fade">

		<label><span class='glyphicon glyphicon-calendar'></span>From Date</label>
		<input type='date' id='from_date_income' value="<? echo set_value('from_date') ?>"
		 class='form-control' required placeholder='From Date' autofocus/><br />

		<label><span class='glyphicon glyphicon-calendar'></span>To Date</label>
		<input type='date' id='to_date_income' value="<? echo set_value('from_date') ?>"
		 class='form-control' required placeholder='To Date' /><br />

		 <button class="btn btn-success" id='btn_income'>Show Analysis</button>

		 <span id='form_income_error' style='color: red'></span>

		 <div id='analysis_income_result'></div>


	</div>
		<!--Display analysis results-->


	<div id='div4_income_expense' class="tab-pane fade">
		<h4>Graph for Income and Expense</h4>
		<br/>
		 <button class="btn btn-success" data-toggle="modal" data-target="#myGraphIncome">Show Graph</button>
		
	</div>

	</div>
	</div>

	<!--Cow Records uploaded- side bar-->
	<div class="col-xs-12 col-sm-6 col-md-6 side-view-2">
	

	<?
		$i=0;
	if(!empty($result_p))
	{
		if(strlen($pagination))
		{
			echo $pagination;
		}
		echo '<h3>Income And Expense</h3>';
		echo '<hr />';
		echo "<table  class='table table-striped table-hover' id='tblincomeall'>";
		echo "<thead> <td>Expense/income No</td><td>Type</td><td>Description</td>
		<td>Amount(Kshs)</td><td>Date</td><td>Delete</td></thead>";
		foreach ($result_p as $row) 
		{
			echo "<tr>";

			echo "<td> ";
			echo $i=$i+1;
			echo "</td>";
			echo "<td>".$row['type_income']."</td>";
			echo "<td>".$row['description']."</td>";
			echo "<td>".$row['amount']."</td>";
			echo "<td>".$row['date']."</td>";

			echo "<td ><button value=".$row['income_id']."
			class='delete_income' >
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
		<a download="allincomeexpensedata.xls" href="#" 
		onclick="return ExcellentExport.excel(this, 'tblincomeall', 'Calving');">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>
	</div>
	</div>
</div>


<!--Modal income and expense graph-->

		<div class="modal fade" id="myGraphIncome" tabindex="-1" role="dialog" aria-labelledby="myGraphLabel" aria-hidden="true">
			  <div class="modal-dialog myProfile modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myGraphLabel"> Financial Income&Expense Graphical Representation</h4>
			      </div>
			      <div class="modal-body">

			      	<div id="chart_div_expense" class="background_home"></div>

					<div id="chart_div_income" class="background_home"></div>


			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       <!-- <button type="button" class="btn btn-primary">Save changes</button>-->
			      </div>
			    </div>
			  </div>
		  </div>

