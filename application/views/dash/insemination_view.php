
<div class='container-fluid main-view'>
	<div class="row-fluid"> 


	<div class='col-xs-12 col-sm-6 col-md-6 side-view-1'>

	<ul class="nav nav-tabs">
 	 <li><a href="#div1_insemination" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-plus-sign'></span>Add Record</button>
 	 </a></li>
  	 <li><a href="#div2_insemination" data-toggle="tab">
  	 	<button class="btn btn-success btn-default btn_black ">
  	 	<span class='glyphicon glyphicon-record'></span>Update Record</button>
  	 </a></li>
 	 <!--<li><a href="#div3_feed" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-remove'></span>Delete Record</button>
 	 </a></li>-->
	</ul>

  <div class="tab-content">
	<div  id='div1_insemination' class="tab-pane fade in active">


		<form name='ins_form' action="<? echo site_url('dashboard/add_insemination_record');?>" method='post'
		onsubmit='return Check_ins_form()' role='form' class='form-horizontal'>
		<fieldset class='form-horizontal'>
		<legend>Cow Insemination Details</legend>

		<label>Cow Identification Number</label>
		<select class="form-control"  name='cow_id' required autofocus>
		<? echo "<option value=''></option>"; ?>
		<? foreach($result as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>

		<div class="form-group">
		<div class="col-md-6">
		<label>Date Of Insemination</label>
		<input type='date' name='date_insemination' id='date_insemination' value="<? echo set_value('date_insemination') ?>" 
		class='form-control col-sm-4' required placeholder='Insemination Date' />
		<br/>
		<span id='form_insemination_date' style='color: red'></span>
		</div>

		<div class="col-md-6">
		<label>Time of Insemination</label>
		<input type='time' name='time_insemination' value="<? echo set_value('time_insemination') ?>" 
		class='form-control col-sm-4' required placeholder='Insemination Time' />
		</div>
		</div>

		<label class="radio">Method Of Insemination :</label>
		<label class="radio-inline">Natural</label>
		<input type='radio' name='method_insemination' value='Natural'  />
		<label class="radio-inline">Artificial</label>
		<input type='radio' name='method_insemination' value="Artificial" checked="true" /><br />
		<label>Bull Breed Source</label>
		<input type='text' name='bull_breed_source' value="<? echo set_value('bull_breed_source') ?>" 
		class='form-control col-sm-4' required placeholder='Bull Breed Source' /><br />

		<label>Inseminator</label>
		<input type='text' name='doctor' value="<? echo set_value('doctor') ?>" 
		class='form-control col-sm-4' required placeholder='Inseminator Name'  />
		
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
	<div id='div2_insemination' class="tab-pane fade">
		<?php 
		$this->load->model('dashboard_model');
		$phone_no=$this->session->userdata('phone_no');
		$result_update=$this->dashboard_model->get_cow_id_update($phone_no, 'insemination','');
		?>
		<label>Select Cow Id to Update Record</label>
		<hr />
		<select class="form-control" id='cow_id_insemination' 
		onchange="Show_insemination_date(this.value)" required autofocus >
		<? echo "<option value=''></option>"; ?>
		<? foreach($result_update as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>
	
	<div id='show_insemination_date'></div>
	<div id='update_insemination_record'></div>

	</div>

	<!--Delete Record-->
	<div id='div3_feed' class="tab-pane fade">
		<? echo form_open(); ?>
		<label>Select Cow Id to Delete Record</label>
		<hr/>
	<select class="form-control"  onchange="Deletethis(this.value)">
		<? echo "<option value=''></option>"; ?>
		<? foreach($result as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
	</select>
	<hr/>
	<? echo form_close(); ?>
	<div id=''></div>
	</div>

	</div>
	</div>

	<!--Cow Records uploaded- side bar-->
	<div class="col-xs-12 col-sm-6 col-md-6 side-view-1">

	
	<?

	if(!empty($result_p))
	{
		if(strlen($pagination))
		{
			echo $pagination;
		}
		echo '<h3>Insemination Records</h3>';
		echo '<hr />';
		echo "<table  class='table table-striped table-hover' id='tblinsall'>";
		echo "<thead> <td>Cow_id</td><td>Date</td><td>Time</td><td>Method</td>
		<td>Bull Source</td><td>Inseminator</td></thead>";
		foreach ($result_p as $row) 
		{
			

			$cow_d=$row['cow_id'];
			echo "<tr>";
			echo "<td><a href='http://localhost/record/index.php/dashboard/dash?id=$cow_d'>
				".$row['cow_id']."</a></td>";
			echo "<td>".$row['date_insemination']."</td>";
			echo "<td>".$row['time_insemination']."</td>";
			echo "<td>".$row['method_insemination']."</td>";
			echo "<td>".$row['bull_breed_source']."</td>";
			echo "<td>".$row['doctor']."</td>";

			echo "<td ><button value=".$row['insemination_id']."
			class='delete_insemination'>
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
		<a download="allInseminationdata.xls" href="#" 
		onclick="return ExcellentExport.excel(this, 'tblinsall', 'All Insemination');">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>
			</div>
	</div>
</div>
