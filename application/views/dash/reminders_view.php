
<div class='container-fluid main-view' >
	<div class="row-fluid">


	<div class='col-xs-12 col-sm-6 col-md-6 side-view-1'>

	<ul class="nav nav-tabs">
 	 <li><a href="#div1_reminders" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-plus-sign'></span>Add Reminder</button>
 	 </a></li>
  	 <li><a href="#div2_reminders" data-toggle="tab">
  	 	<button class="btn btn-success btn-default btn_black ">
  	 	<span class='glyphicon glyphicon-record'></span>Update Reminder</button>
  	 </a></li>
 	 <!--<li><a href="#div3_reminders" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-remove'></span>Delete Reminder</button>
 	 </a></li>-->
	</ul>

  <div class="tab-content">
	<div  id='div1_reminders' class="tab-pane fade in active">
		
		<form name='reminder_form' action="<? echo site_url('dashboard/add_reminder_record');?>" method='post'
		onsubmit='return Check_reminder_form()' role='form' class='form-horizontal'>

		<fieldset class='form-horizontal'>

		<legend><span class='glyphicon glyphicon-bell'></span>Set Reminder</legend>
		<label>Activity</label>
		<input type='text' name='activity' value="<? echo set_value('activity'); ?>" 
		class='form-control col-sm-4' required placeholder='Subject' autofocus />		
		<br/>
		<label>Description</label>
		<textarea class="form-control" rows='3'  name='description' required>
		<? echo set_value('description'); ?>
		</textarea>

		<label>Activity Date</label>
		<input type='date' name='activity_date' value="<? echo set_value('activity_date') ?>" 
		class='form-control col-sm-4' required placeholder='Activity Date' />
		<br />
		<br />
		<br />
		<button type='submit' class='btn btn-default'>Add</button>
		</fieldset>
		<?php echo form_close(); ?>
		<br />
		<? echo validation_errors('<span class="errors" style="color: red">', '</span'); ?>
		
	</div>


	<!--Upating the cow detail record-->
	<div id='div2_reminders' class="tab-pane fade">

		<label>Select Reminder No. to Update</label>
		<hr />
		<select class="form-control" onchange="Update_reminder_record(this.value)" 
		required autofocus >
		<?php
		
		$i=0; 
		echo "<option value=''></option>"; 
		if(!empty($result))
		{
		foreach($result as $reminder)
		{	

		echo "<option value=".$reminder['reminder_id'].">";
		echo $i=$i+1; 
		echo "</option>";

		}
		}
		?>
		</select>
	
	<div id='update_reminder_record'></div>


	</div>

	<!--Delete Record-->
	<div id='div3_reminders' class="tab-pane fade">
		
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
		echo '<h3>Reminders</h3>';
		echo '<hr />';
		echo "<table  class='table table-striped table-hover' id='tblreminderall'>";
		echo "<thead> <td>Reminder No</td><td>Activity</td><td>Description</td>
		<td>Date set</td><td>Activity Date</td><td>Delete</td></thead>";
		foreach ($result_p as $row) 
		{
			echo "<tr>";

			echo "<td> ";
			echo $i=$i+1;
			echo "</td>";
			echo "<td>".$row['activity']."</td>";
			echo "<td>".$row['description']."</td>";
			echo "<td>".$row['date_set']."</td>";
			echo "<td>".$row['date_remind']."</td>";

			echo "<td ><button value=".$row['reminder_id']." class='delete_reminder' >
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
		<a download="allReminderdata.xls" href="#" 
		onclick="return ExcellentExport.excel(this, 'tblreminderall', 'Calving');">
		<span class='glyphicon glyphicon-export'></span>
		Export Excel</a>
	</span>
	</div>
	</div>
</div>
