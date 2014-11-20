
<div class="navbar navbar-inverse navbar-fixed-bottom footer-top" role='navigation'>
	<div class="container">
		<div class="row-fluid">
		<p class="navbar-text">
		<a href='http://localhost/record/index.php/dashboard/dash'>Digital Cow-Kenya</a>
		 &copy 2014</p>
		<?
		$is_login['user_id']=$this->session->userdata('user_id');
		$is_login['status']=$this->session->userdata('is_login_in');
		if(!empty($is_login['status']) && !empty($is_login['user_id']) && isset($is_login['status'])
			&& isset($is_login['user_id']))
		{
			echo '<p class="text-right"><a href="http://localhost/record/index.php/dashboard/logout" class="btn navbar-btn">
		<span class="glyphicon glyphicon-log-out"></span>Log Out</a></p>';
			
		}
		else
		{
			echo '<p class="text-right"><a href="http://localhost/record/index.php/site/register" class="btn navbar-btn">
		<span class="glyphicon glyphicon-plus-sign"></span>Sign Up</a></p>';
		}
	?>
		
		</div>
	</div>
</div>

<script src="<? echo base_url(); ?>/res/jquery/jquery.min.js" type="text/javascript"></script>
<script src="<? echo base_url(); ?>/res/jquery/ZeroClipboard.js" type="text/javascript"></script>
<script src="<? echo base_url(); ?>/res/jquery/dataTables.js" type="text/javascript"></script>
<script src="<? echo base_url(); ?>/res/jquery/tableTools.js" type="text/javascript"></script>
<script src="<? echo base_url(); ?>/res/jquery/tablebootstrap.js" type="text/javascript"></script>
<script src="<? echo base_url(); ?>/res/bootstrap/js/bootstrap.min.js"></script>
<script src="<? echo base_url(); ?>/res/jquery/effects.js" type="text/javascript"></script>
<script src="<? echo base_url(); ?>/res/jquery/excellentexport.js" type="text/javascript"></script>
</body>
</html>