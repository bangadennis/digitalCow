
<div class='container main-view-1'>
	<div class='jumbotron col-sm-push-3 col-sm-6 white_background'>
		<?php echo form_open('site/forgot_password'); 
		?>
		<h3>Reset Password</h3>
		<label class="">First Name</label><br />
		<input type='text' name='fname' value="<? echo set_value('fname') ?>" class='form-control col-sm-4' required autofocus placeholder='first name' /><br />
		<label class="">Second Name</label><br />
		<input type='text' name='sname' value="<? echo set_value('sname') ?>" class='form-control col-sm-4' required placeholder='second name' /><br />
		<label class="">Phone Number</label><br />
		<div class='input-group'>
		<span class='input-group-addon'>+254</span>
		<input type='text' name='phoneno' value="<? echo set_value('phoneno') ?>" class='form-control col-sm-4' required placeholder='Phone No' maxlength=9/>
		</div>

		<? echo validation_errors('<p class="errors" style="color: red">')?>
		<br />
		<button type='submit' class='btn btn-default'>Reset Password</button>
		<? echo form_close(); ?>
		<div class="pull-right">
		<button class="btn navbar-btn">
		<? echo anchor('site/login', "To Login");?> </button>

		</div>
	</div>
</div>
