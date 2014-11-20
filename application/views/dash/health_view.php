
<div class='container-fluid main-view'>
	<div class="row-fluid">


	<div class='col-xs-12 col-sm-6 col-md-6 side-view-1'>

	<ul class="nav nav-tabs">
 	 <li><a href="#div1_health" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-plus-sign'></span>Add Record</button>
 	 </a></li>
  	 <li><a href="#div2_health" data-toggle="tab">
  	 	<button class="btn btn-success btn-default btn_black ">
  	 	<span class='glyphicon glyphicon-record'></span>Update Record</button>
  	 </a></li>
 	 <!--<li><a href="#div3_health" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-remove'></span>Delete Record</button>
 	 </a></li>-->
	</ul>

  <div class="tab-content">
	<div  id='div1_health' class="tab-pane fade in active">

		<form name='health_form' action="<? echo site_url('dashboard/add_health_record');?>" method='post'
		onsubmit='return Check_health_form()' role='form' class='form-horizontal'>

		<fieldset class='form-horizontal'>

		<legend>Cow Health Details</legend>
		<label>Cow Identification Number</label>
		<select class="form-control"  name='cow_id' required autofocus>
		<? echo "<option value=''></option>"; ?>
		<? foreach($result as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>

		<div class="form-group">

		<div class="col-md-6">
		<label>Symptoms</label>
		<textarea class="form-control" rows="2" name="symptoms" value='N/A' required></textarea>
		</div>

		<div class="col-md-6">
		<label >Type of Treatment</label>
		<select class='form-control' name='type_treatment' required>
			<option value='Normal'>Normal</option>
			<option value='Vaccination'>Vaccination</option>
		</select>

		</div>
		</div>


		<div class="form-group">

		<div class="col-md-6">
		<label >Treatment</label>
		<textarea class="form-control" rows="2" name="treatment" required
		value="<? echo set_value('veterinary') ?>" 
		></textarea>
		</div>

		<div class="col-md-6">
		<label>Remarks</label>
		<textarea class="form-control" rows="2" name='remarks' required
		value="<? echo set_value('remarks') ?>" ></textarea>
		</div>
		</div>
		<br />

		<div class="form-group">

		<div class="col-md-6">
		<label>Veterinary Name</label>
		<input type='text' name='veterinary' value="<? echo set_value('veterinary') ?>" 
		class='form-control col-sm-4' required placeholder='Veterinary Name'  />
		</div>

		<div class="col-md-6">
		<label>Date Of Treatment</label>
		<input type='date' name='date_treatment' id='date_treatment' value="<? echo set_value('date_treatment') ?>" 
		class='form-control col-sm-4' required placeholder='Treatment Date' />
		<br/>
		<span id='form_health_date' style='color: red'></span>
		
		</div>

		</div>

		<button type='submit' class='btn btn-default'>Add</button>
		</fieldset>
		<?php echo form_close(); ?>
		<br />
		<? echo validation_errors('<span class="errors" style="color: red">', '</span'); ?>
		
	</div>


	<!--Upating the cow detail record-->
	<div id='div2_health' class="tab-pane fade">

		<?php 
		$this->load->model('dashboard_model');
		$phone_no=$this->session->userdata('phone_no');
		$result_update=$this->dashboard_model->get_cow_id_update($phone_no, 'health', '');
		?>
		<label>Select Cow Id to Update Record</label>
		<hr />
		<select class="form-control" id='cow_id_health' onchange='Show_health_date(this.value)' 
		required autofocus >
		<? echo "<option value=''></option>"; ?>
		<? foreach($result_update as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>
	
	<div id='show_health_date'></div>
	<div id='update_health_record'></div>

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
	<div class="col-xs-12 col-sm-6 col-md-6 side-view-2" >
	
		
	<?

	if(!empty($result_p))
	{
		if(strlen($pagination))
		{
			echo $pagination;
		}
		echo '<h3>Health Records</h3>';
		echo '<hr />';
		echo "<table  class='table table-condensed table-hover table-striped' id='tblhealthall'>";
		echo "<thead> <td>Cow_id</td><td>Symptoms</td><td>Treatment</td>
		<td>Remarks</td><td>Date of Treatment</td></thead>";
		foreach ($result_p as $row) 
		{
			$cow_d=$row['cow_id'];
			echo "<tr>";
			echo "<td><a href='http://localhost/record/index.php/dashboard/dash?id=$cow_d'>
				".$row['cow_id']."</a></td>";

			//echo "<td>".$row['type_treatment']."</td>";
			echo "<td>".$row['symptoms']."</td>";
			echo "<td>".$row['treatment']."</td>";
			echo "<td>".$row['remarks']."</td>";
			//ddecho "<td>".$row['veterinary']."</td>";
			echo "<td>".$row['date_treatment']."</td>";

			echo "<td id='delete_health'><button value=".$row['health_id']."
			class='delete_health' >
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

	<span><a download="Allhealthdata.xls" href="#" 
		onclick="return ExcellentExport.excel(this, 'tblhealthall', 'Calving');">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>
	</div>
	</div>
</div>
