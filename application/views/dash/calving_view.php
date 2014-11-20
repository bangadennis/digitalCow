<div class='container-fluid main-view' >
	<div class="row-fluid">


	<div class='col-xs-12 col-sm-6 col-md-6 side-view-1'>

	<ul class="nav nav-tabs">
 	 <li><a href="#div1_calving" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-plus-sign'></span>Add Record</button>
 	 </a></li>
  	 <li><a href="#div2_calving" data-toggle="tab">
  	 	<button class="btn btn-success btn-default btn_black ">
  	 	<span class='glyphicon glyphicon-record'></span>Update Record</button>
  	 </a></li>
 	<!-- <li><a href="#div3_calving" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-remove'></span>Delete Record</button>
 	 </a></li>-->
	</ul>

  <div class="tab-content">
	<div  id='div1_calving' class="tab-pane fade in active">
		<?php echo form_open('dashboard/add_calving_record'); ?>
		<fieldset class='form-horizontal'>

		<legend>Cow Calving Details</legend>
		<label>Cow Identification Number</label>
		<select class="form-control"  name='cow_id'  required autofocus onchange='Show_calf_id_valid(this.value)'>
		<? echo "<option value=''></option>"; ?>
		<? foreach($result as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>

		<label>Calf Identification Number</label>
		<select class='form-control' name='calf_id' id="valid_calf" required>
		<option value=""></option>

		</select>

		<label>Method of Calving</label>
		<select name='method_calving' class='form-control'>
			<option value='Natural'>Natural</option>
			<option value='Surgery'>Ceaserian</option>
		</select>

		<div class="form-group">
		<div class="col-md-12">
		<label>Remarks</label>
		<textarea class="form-control" rows="2" name="remarks" value='N/A' required></textarea>
		</div>
		</div>


		<button type='submit' class='btn btn-default'>Add</button>
		</fieldset>
		<?php echo form_close(); ?>
		<br />
		<? echo validation_errors('<span class="errors" style="color: red">', '</span'); ?>
		
	</div>


	<!--Upating the cow detail record-->
	<div id='div2_calving' class="tab-pane fade">

		<?php 
		$this->load->model('dashboard_model');
		$phone_no=$this->session->userdata('phone_no');
		$result_update=$this->dashboard_model->get_cow_id_update($phone_no, 'calving_register', 'Female');
		?>
		<label>Select Cow Id to Update Record</label>
		<hr />
		<select class="form-control" id='cow_id_calving' onchange='Show_calf_id(this.value)' 
		required autofocus >
		<? echo "<option value=''></option>"; ?>
		<? foreach($result_update as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>
	
	<div id='show_calf_id'></div>
	<div id='update_calving_record'></div>

	</div>


	</div>
	</div>

	<!--Cow Records uploaded- side bar-->
	<div class="col-xs-12 col-sm-6 col-md-6 side-view-2">
	<?

	if(!empty($result_p))
	{

		if(strlen($pagination))
		{
			echo $pagination;
		}
		echo '<h3>Calving Records</h3>';
		echo '<hr />';
		echo "<table  class='table table-striped table-hover' id='tblcalvingall'>";
		echo "<thead> <td>Cow_id</td><td>calf Id</td>
		<td>Method of Calving</td><td>Remarks</td></thead>";
		foreach ($result_p as $row) 
		{
			$cow_d=$row['cow_id'];
			echo "<tr>";
			echo "<td><a href='http://localhost/record/index.php/dashboard/dash?id=$cow_d'>
				".$row['cow_id']."</a></td>";
			echo "<td>".$row['calf_id']."</td>";
			echo "<td>".$row['method_calving']."</td>";
			echo "<td>".$row['remarks']."</td>";

			echo "<td ><button value=".$row['calf_id']."
			 class='delete_calving'>
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
		<a download="allCalvingdata.xls" href="#" 
		onclick="return ExcellentExport.excel(this, 'tblcalvingall', 'All Milk');">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>
	</div>
	</div>
</div>
