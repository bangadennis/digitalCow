<!DOCTYPE html>
<html>
<head>
<title>Digital Cow</title>
<meta name="veiwport" content="width=device-width" />
<link type='text/css' href="<? echo base_url(); ?>res/bootstrap/css/bootstrap.min.css" rel='stylesheet' />
<link type='text/css' href="<? echo base_url(); ?>res/css/style.css" rel='stylesheet' />
<link type='text/css' href="<? echo base_url(); ?>res/css/print.css" rel='stylesheet' />
<script type="text/javascript" src='https://www.google.com/jsapi'></script>
</head>

<body>
<div class='navbar navbar-fixed-top navbar-default header' role='navigation' >
	<div class="container">
	<span <?php if($active=='home'){echo 'class="active"';} ?> >
	<a href="<?echo site_url('dashboard/dash');?>" class='navbar-brand text-primary'> <strong>Digital Cow </strong> </a></span>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navHeaderCollapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<div class='collapse navbar-collapse' id="navHeaderCollapse">
			<ul class="nav navbar-nav navbar-right">
			<li <?php if($active=='home'){echo 'class="active"';} ?>><a href="<?echo site_url('dashboard/dash');?>">Home</a></li>
			<li <?php if($active=='cow_register'){echo 'class="active"';} ?> >
			<a href="<? echo site_url('dashboard/cow_register');?>">Cow</a></li>
				
			<li <?php if($active=='milk_page'){echo 'class="active"';} ?>><a href="<?echo site_url('dashboard/milk_page');?>">Milk</a></li>
			<li <?php if($active=='feed_page'){echo 'class="active"';} ?>>
			<a href="<? echo site_url('dashboard/feed_page');?>">Feed</a></li>
			<li <?php if($active=='income_expense'){echo 'class="active"';} ?>><a href="<? echo site_url('dashboard/income_expense')?>">Financial</a></li>
			<li <?php if($active=='reminder'){echo 'class="active"';} ?>><a href="<?echo site_url('dashboard/reminders_page');?>">Reminder</a></li>

			<li class='dropdown <?php if($active=='health_page'){echo 'active';} ?>' >
				<a href='#' class='dropdown-toggle' data-toggle='dropdown'>More<span class='glyphicon glyphicon-chevron-right'></span>
				<b class='caret'></b></a>
				<ul class='dropdown-menu'>
				<li><a href="<? echo site_url('dashboard/insemination_page');?>">Insemination</a></li>
				<li><a href="<? echo site_url('dashboard/calving_page');?>">Calving</a></li>
				<li><a href="<? echo site_url('dashboard/health_page');?>">Health</a></li>
				</ul>
				</li>
	 		<li class="user_profile bg-primary">
     			<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
     			<span class='glyphicon glyphicon-user text-info ' >	
				<? echo $user=$this->session->userdata('fname');?>
    			<span class="caret"></span></span></a>

    			<ul class="dropdown-menu">
			     <li><a href="#"> <a href="#" data-target='#myProfile' data-toggle='modal'>Profile</a></li>
			     <li><a href="<?echo site_url('dashboard/logout');?>"><span class='glyphicon glyphicon-log-out'></span>Logout</a></li>
			    <li> 
			    <?
			    	$admin=$this->session->userdata('phone_no');
			    	if($admin=='+254731053591')
			    	{
			    		echo "<a href='http://localhost/record/index.php/dashboard/admin'>Admin</a>";
			    	}
			    ?>

			    </li>
			    </ul>
    		</li>
			    
			

			
			<!--<form class="navbar-form navbar-left" role="search">
        	<div class="form-group">
         	 <input type="text" class="form-control" placeholder="Search">
       		 </div>
       		 <button type="submit" class="btn btn-default">Search</button>
      		</form>-->

			</ul>

		</div>

	</div>

</div>

<!--Modal profile-->

		<div class="modal fade" id="myProfile" tabindex="-1" role="dialog" aria-labelledby="myProfileLabel" aria-hidden="true">
			  <div class="modal-dialog myProfile">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			        <h4 class="modal-title" id="myProfileLabel">User Profile</h4>
			      </div>
			      <div class="modal-body bg-info">
			      <? 
			      //$this->load->model('dashboard_model');
			      //$phone_no=$this->session->userdata('phone_no');
			      //$result_profile=$this->dashboard_model->load_user_profile($phone_no);

			      if(!empty($result_profile))
			      {

			      	$result=$result_profile['user'];
			      	$location=$result_profile['location'];
			      	$cows=$result_profile['cows'];

					//force_download($name, $data);
			      	echo "<b>First Name: </b>".$result['fname'];
			      	echo "<br/>";
			      	echo "<b>Second Name: </b>".$result['sname'];
			      	echo "<br/>";
			      	echo "<b>Phone Number: </b>".$result['phone_no'];
			      	echo "<br/>";
			      	echo "<b>County: </b>".$location['county'];
			      	echo "<br/>";
			      	echo "<b>District: </b>".$location['district'];
			      	echo "<br/>";
			      	echo "<b>Location: </b>".$location['location'];
			      	echo "<br/>";
			      	echo "<b>Village/Home Area: </b>".$location['area'];
			      	echo "<br/>";
			      	echo "<b>Number Of Cows: </b>".$cows['number_cows'];
			      	//echo "<b>First Name:&nbps</b>".$result['fname'];
			      }


			      ?>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			       <!-- <button type="button" class="btn btn-primary">Save changes</button>-->
			      </div>
			    </div>
			  </div>
		  </div>

