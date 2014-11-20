<!DOCTYPE html>
<html  lang="en">
<head>
<title>Digital Cow</title>
<meta name="veiwport" content="width=device-width" />
<link type='text/css' href="<? echo base_url(); ?>res/bootstrap/css/bootstrap.min.css" rel='stylesheet' />
<link type='text/css' href="<? echo base_url(); ?>res/css/style.css" rel='stylesheet' />

</head>
<body id='background'>
<div class='navbar navbar-inverse navbar-fixed-top navbar-default'>
	<div class="container">
	<a href="<?echo site_url('site/home');?>" class='navbar-brand text-info'>Digital Cow</a>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navHeaderCollapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<div class='collapse navbar-collapse' id="navHeaderCollapse">
			<ul class="nav navbar-nav navbar-right">
			<li <?php if($active=='home'){echo 'class="active"';} ?> ><a href="<?echo site_url('site/home');?>">Home</a></li>
			<li <?php if($active=='info'){echo 'class="active"';} ?> ><a href="<?echo site_url('site/information');?>">Sms Service</a></li>
				<!--<li class='dropdown'>
				<a href='#' class='dropdown-toggle' data-toggle='dropdown'>Records <b class='caret'></b></a>
				<ul class='dropdown-menu'>
				<li><a href="#" >Identification</a></li>
				<li><a href="#" >Health</a></li>
				<li><a href="#" >Production</a></li>
				<li><a href="#">Feeding</a></li>
				</ul>
				</li>-->
			<!--<li><a href="#">About</a></li>-->
			<li <?php if($active=='login'){echo 'class="active"';} ?> > <a href="<?echo site_url('site/login');?>">Login<span class='glyphicon glyphicon-log-in'></span></a></li>
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

