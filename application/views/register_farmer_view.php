
<div class='container main-view'>
	<div class="row">
	<div class='col-sm-6 col-sm-push-3 jumbotron'>
		<?php echo form_open('dashboard/location_details_submit'); 
		?>
		<fieldset>
		<legend>Farmer Information</legend>
		<label>County</label>
		<input type='text' name='county' value="<? echo set_value('county') ?>" class='form-control col-sm-4' required autofocus placeholder='County' /><br />
		<label>District</label>
		<input type='text' name='district' value="<? echo set_value('district') ?>" class='form-control col-sm-4' required placeholder='District' /><br />
		<label>Location</label>
		<input type='text' name='location' value="<? echo set_value('location') ?>" class='form-control col-sm-4' required placeholder='Location' /><br />
		<label>Home Area/Village</label>
		<input type='text' name='area' value="<? echo set_value('area') ?>" class='form-control col-sm-4' required placeholder='Home Area' /><br />
		
		<? echo validation_errors('<p class="errors">')?>
		<br />
		<br />
		<button type='submit' class='btn btn-default'>Submit</button>
		</fieldset>
	</div>
	</div>
</div>
