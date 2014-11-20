
<div class='container main-view-1'>
	<div class="row-fluid">
	<div class='jumbotron col-sm-push-3 col-sm-6 white_background'>
	<p id='error'>	</p>
		<?php echo form_open('site/login'); 
		?>
		<h3><span class='glyphicon glyphicon-lock'></span>Login form</h3>
		<label class="">Phone Number</label><br />
		<div class='input-group'>
		<span class='input-group-addon'>+254</span>
		<input type='text' name='phoneno' value="<? echo set_value('phoneno') ?>" class='form-control' required placeholder='712345678' maxlength=9/ autofocus>
		</div>
		<label>Password</label><br />
		<input type='password', name='password' class='form-control' required maxlength=5>
		<br />
		<button type='submit' class='btn btn-default'>Login</button>
		<br/><br/>
		<? echo validation_errors('<span class="errors" style="color: red">', '</span')?>
		</form>
		<div class='input-group'><span class='input-group-addon'>
		<? echo anchor('site/register', 'Sign Up');?></span>
		<br/>
		<span class='input-group-addon'>
		<? echo anchor('site/forgot_password', 'Forgot Password');?></span>
		</div>
		
	</div>
</div>
