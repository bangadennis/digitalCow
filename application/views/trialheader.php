<!DOCTYPE html>
<html>
<head>
<title>Online Dairy Records</title>
<meta name="veiwport" content="width=device-width" />
<link type='text/css' href="<? echo base_url(); ?>res/bootstrap/css/bootstrap.min.css" rel='stylesheet' />

</head>
<body>
<div class='navbar navbar-inverse navbar-static-top navbar-default'>
	<div class="container">
	<a href="#" class='navbar-brand'>Online Dairy Farmers</a>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navHeaderCollapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<div class='collapse navbar-collapse' id="navHeaderCollapse">
			<ul class="nav navbar-nav navbar-right">
			<li class="active"><a href="#">Home</a></li>
			<li><a href="#">Insights</a></li>
				<li class='dropdown'>
				<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Records <b class='caret'></b></a>
				<ul class='dropdown-menu'>
				<li><a href="#" >Identification</a></li>
				<li><a href="#" >Health</a></li>
				<li><a href="#" >Production</a></li>
				<li><a href="#">Feeding</a></li>
				</ul>
				</li>
			<li><a href="#">About</a></li>
			<li><a href="#login_modal" data-toggle="modal">login</a></li>
			<form class="navbar-form navbar-left" role="search">
        	<div class="form-group">
         	 <input type="text" class="form-control" placeholder="Search">
       		 </div>
       		 <button type="submit" class="btn btn-default">Search</button>
      		</form>
			</ul>
		</div>
	</div>
</div>
<!--body-->
<div class='container'>
	<div class="jumbotron">
	<center><h3>Welcome to Online Dairy Farmers Recording System</h3>
	<p>This is where farmers are able to store their records at ease and for easy financial analysis
	get sms updates</p>
	<a href="<? echo site_url('site/register'); ?>"><button class="btn btn-success">Register Now</button></a>
	</center>
	</div>
</div>
<!--modal-->
<div class="modal fade" id="login_modal" role="dialog">
	<div class="modal-dialog" style="background: #FFFFFF; border-radius: 20px">
		<div class="model-content" style="padding:10px 40px">
			<div class="model-header">
				<h2>Login Form</h2>		
			</div>
			<div class="model-body">
			<?php echo form_open('site/login'); ?>
		<label class="">Phone Number</label><br />
		<div class='input-group'>
		<span class='input-group-addon'>+254</span>
		<input type='text' name='phoneno' value="<? echo set_value('phoneno') ?>" class='form-control' required placeholder='Phone No' maxlength=9/ autofocus>
		</div>
		<label>Password</label><br />
		<input type='password', name='password' class='form-control' required maxlength=5>
		<br />
		<button type='submit' class='btn btn-default'>Login</button>
		<br/><br/>
		<div class='input-group'><span class='input-group-addon'>
		<? echo anchor('site/register', 'To Sign Up');?></span>
		<br/>
		<span class='input-group-addon'>
		<? echo anchor('site/forgot_password', 'Forgot Password');?></span>
		</div>
		<? echo validation_errors('<span class="errors">')?>
				
		</div>

		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
			
		</div>
		
	</div>
	

</div>
<script src="<? echo base_url(); ?>/res/jquery/jquery.min.js" type="text/javascript"></script>
<script src="<? echo base_url(); ?>/res/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>