
<div class='container-fluid main-view' id='cow_detail'>
	<div class="row-fluid">
	<div class='col-xs-12 col-sm-6 col-md-6 side-view-1'>

	<ul class="nav nav-tabs">
 	 <li><a href="#div1" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black" id='add'><span class='glyphicon glyphicon-plus-sign'></span>Add Record</button>
 	 </a></li>
  	 <li><a href="#div2" data-toggle="tab">
  	 	<button class="btn btn-success btn-default btn_black " id='update'><span class='glyphicon glyphicon-record'></span>Update Record</button>
  	 </a></li>
 	 <li><a href="#div3" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black" id='delete'><span class='glyphicon glyphicon-remove'></span>Delete Record</button>
 	 </a></li>
	</ul>

	<div class="tab-content">
	<div  id='div1' class="tab-pane fade in active">

		<form name='register_cow' action="<? echo site_url('dashboard/register_cow');?>" method='post'
		onsubmit='return Check_register()' role='form' class='form-horizontal'>

		<fieldset>
	
		<legend>Cow Details Recording</legend>
		<label>Cow Identification Number</label>
		<input type='text' id='cow_id_field' name='cow_id' value="<? echo set_value('cow_id') ?>" class='form-control col-sm-4' required autofocus placeholder='Cow id' /><br />
		<span id='form_cow_id' style='color: red'></span>
		
		<label><span class='glyphicon glyphicon-calendar'></span>Date of Birth</label>
		<input type='date' id='date_cow_birth' name='dob' value="<? echo set_value('dob') ?>" class='form-control col-sm-4' required placeholder='Date of Birth' /><br />
		<span id='form_dob' style='color: red'></span>
		<br/>
		<label>Sex</label>
		<select name='sex' class="form-control">
			<option value='Female'>Female</option>
			<option value="Male">Male</option>
			
		</select>
		<label>Breed</label>
		<input type='text' name='breed' value="<? echo set_value('breed') ?>" class='form-control col-sm-4' required placeholder='Breed' /><br />
		<span id='form_breed' style='color: red'></span>
		<br />
		<br />
		<button type='submit' id='cow_add_btn' class='btn btn-default'>Add</button>
		</fieldset>
		<?php echo form_close(); ?>
		<br />
		<? echo validation_errors('<span class="errors" style="color: red">', '</span')?>
		
	</div>
	<!--Upating the cow detail record-->
	<div id='div2' class="tab-pane fade">
		<?php 
		$this->load->model('dashboard_model');
		$data['phone_no']=$this->session->userdata('phone_no');
		$results=$this->dashboard_model->get_cow_id($data);
		?>
		<label>Select Cow Id to Update Record</label>
		<hr />
		<select class="form-control" onchange="Checkthis(this.value)" autofocus>
		<? echo "<option value=''></option>"; ?>
		<? foreach($results as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>
	
	<div id='test'></div>
	</div>

	<!--Delete Record-->
	<div id='div3' class="tab-pane fade">
		<? echo form_open(); ?>
		<label>Select Cow Id of the record to delete</label>
		<hr/>
	<select class="form-control" id='delete_id' onchange="Deletethis(this.value)" autofocus>
		<? echo "<option value=''></option>"; ?>
		<? foreach($results as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
	</select>
	<hr/>
	<? echo form_close(); ?>
	<div id='delete_info'></div>
	</div>
	</div>
	</div>

	<!--Cow Records uploaded side bar-->
	<div class="col-xs-12 col-sm-6 col-md-6 side-view-2">
	
	<?

	if(!empty($result_p))
	{
		if(strlen($pagination))
		{
			echo $pagination;
		}
		echo '<h3>Individual Cow Records</h3>';
		echo '<hr />';
		echo "<table  class='table table-striped table-hover' id='tblcowsall'>";
		echo "<thead> <td>Cow_id</td><td>Date of Birth</td><td>Sex</td><td>Breed</td></thead>";
		foreach ($result_p as $row) 
		{
			$cow_d=$row['cow_id'];
			echo "<tr>";
			echo "<td><a href='http://localhost/record/index.php/dashboard/dash?id=$cow_d'>
				".$row['cow_id']."</a></td>";
			echo "<td>".$row['dateofbirth']."</td>";
			echo "<td>".$row['sex']."</td>";
			echo "<td>".$row['breed']."</td>";
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
		<a download="allCowsdata.xls" href="#" 
		onclick="return ExcellentExport.excel(this, 'tblcowsall', 'Calving');">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
	</span>
	</div>
	</div>
</div>
