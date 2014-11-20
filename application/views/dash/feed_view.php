
<div class='container-fluid main-view'>
	<div class="row-fluid">


	<div class='col-xs-12 col-sm-6 col-md-6 side-view-1'>

	<ul class="nav nav-tabs">
 	 <li><a href="#div1_feed" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-plus-sign'></span>Add Record</button>
 	 </a></li>
  	 <li><a href="#div2_feed" data-toggle="tab">
  	 	<button class="btn btn-success btn-default btn_black ">
  	 	<span class='glyphicon glyphicon-record'></span>Update Record</button>
  	 </a></li>
 	<!-- <li><a href="#div3_feed" data-toggle="tab">
 	 	<button class="btn btn-success btn-default btn_black">
 	 	<span class='glyphicon glyphicon-remove'></span>Delete Record</button>
 	 </a></li>-->
	</ul>

  <div class="tab-content">
	<div  id='div1_feed' class="tab-pane fade in active">
	
		<form name='feed_form' action="<? echo site_url('dashboard/add_feed_record');?>" method='post'
		onsubmit='return Check_feed_form()' role='form' class='form-horizontal'>
		<fieldset>
		<legend>Feeding Details</legend>
		<label>Cow Identification Number</label>
		<select class="form-control"  name='cow_id' required autofocus >
		<? echo "<option value=''></option>"; ?>
		<? foreach($result as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>

		<label>Type of Feed</label>
		<input type='text' name='type_feed' value="<? echo set_value('type_feed') ?>" 
		class='form-control col-sm-4' required placeholder='Feed Description' /><br />

		<label>Amount of Feed</label>
		<input type='text' name='amount_feed' value="<? echo set_value('amount_feed') ?>" 
		class='form-control col-sm-4' required placeholder='Feed Amount' />
		<br />
		<label>Date Of feeding</label>
		<input type='date' name='date_feed' id='date_feed' value="<? echo set_value('date_feed') ?>" 
		class='form-control col-sm-4' required placeholder='Feed Date' />
		<br/>
		<span id='form_feed_date' style='color: red'></span>
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
	<div id='div2_feed' class="tab-pane fade">
		<?php 
		$this->load->model('dashboard_model');
		$phone_no=$this->session->userdata('phone_no');
		$result_update=$this->dashboard_model->get_cow_id_update($phone_no, 'feedingrecord', '');
		?>
		<label>Select Cow Id to Update Record</label>
		<hr />
		<select class="form-control" id='cow_id_feed' onchange="Show_feed_date(this.value)">
		<? echo "<option value=''></option>"; ?>
		<? foreach($result_update as $cow_id):?>	
		<? echo"<option value=".$cow_id['cow_id'].">".$cow_id['cow_id']."</option>";?>
		<? endforeach; ?>
		</select>
	
	<div id='show_feed_date'></div>
	<div id='update_feed_record'></div>

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
	<div class="col-xs-12 col-sm-6 col-md-6 side-view-2">

		
	<?

	if(!empty($result_p))
	{
		
		if(strlen($pagination))
		{
			echo $pagination;
		}
		echo '<h3>Cow Records</h3>';
		echo '<hr />';
		echo "<table  class='table table-striped table-hover' id='tblfeedall'>";
		echo "<thead> <td>Cow_id</td><td>Feed Type</td><td>Amount Of Feed</td><td>Date</td></thead>";
		foreach ($result_p as $row) 
		{
			$cow_d=$row['cow_id'];
			echo "<tr>";
			echo "<td><a href='http://localhost/record/index.php/dashboard/dash?id=$cow_d'>
				".$row['cow_id']."</a></td>";
			echo "<td>".$row['type_feed']."</td>";
			echo "<td>".$row['amount_feed']."</td>";
			echo "<td>".$row['feed_date']."</td>";
			echo "<td ><button value=".$row['feed_id']." class='delete_feed'>
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
		<a download="allfeeddata.xls" href="#" 
		onclick="return ExcellentExport.excel(this, "tblfeedall", "Feed");">
		<span class='glyphicon glyphicon-export'>
		Export Excel</a>
		</span>
	
	</div>
	</div>
</div>
