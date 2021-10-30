<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="../../favicon.ico">

    <title>Persediaan - Login</title>

    <!-- Bootstrap core CSS -->
    <link href="{{$baseurl}}/bootstrap337/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{$baseurl}}/bootstrap337/css/bootstrap-cosmo.min.css" rel="stylesheet">
    <link href="{{$baseurl}}/bootstrap337/css/navbar-fixed-top.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{$baseurl}}/bootstrap337/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	
    <!-- Custom styles for this template -->
    <!--<link href="navbar-fixed-top.css" rel="stylesheet">-->
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="{{$baseurl}}/bootstrap337/js/ie-emulation-modes-warning.js"></script>
	
	<style>
		.form-signin
		{
			max-width: 330px;
			padding: 15px;
			margin: 0 auto;
		}
		.form-signin .form-signin-heading, .form-signin .checkbox
		{
			margin-bottom: 10px;
		}
		.form-signin .checkbox
		{
			font-weight: normal;
		}
		.form-signin .form-control
		{
			position: relative;
			font-size: 16px;
			height: auto;
			padding: 10px;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}
		.form-signin .form-control:focus
		{
			z-index: 2;
		}
		.form-signin input[type="text"]
		{
			margin-bottom: -1px;
			border-bottom-left-radius: 0;
			border-bottom-right-radius: 0;
		}
		.form-signin input[type="password"]
		{
			margin-bottom: 10px;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
		}
		.account-wall
		{
			margin-top: 20px;
			padding: 40px 0px 20px 0px;
			background-color: #f7f7f7;
			-moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			-webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		}
		.login-title
		{
			color: #555;
			font-size: 18px;
			font-weight: 400;
			display: block;
		}
		.profile-img
		{
			width: 96px;
			height: 96px;
			margin: 0 auto 10px;
			display: block;
			-moz-border-radius: 50%;
			-webkit-border-radius: 50%;
			border-radius: 50%;
		}
		.need-help
		{
			margin-top: 10px;
		}
		.new-account
		{
			display: block;
			margin-top: 10px;
		}
	</style>

  </head>

  <body>

		<div>
			
			<?php
				foreach ($errors->all() as $message) {
					echo '<span class="label label-danger">'.$message.'</span><br>';
				}
			?>
			
		</div>


		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-md-offset-4">
					<h1 class="text-center login-title">Aplikasi Persediaan</h1>
					<div class="account-wall">
						<form class="form-signin" name="from-ruh" id="from-ruh">
							{{ csrf_field() }}
							<input type="hidden" class="form-control" id="baseurl" name="baseurl" value="{{$baseurl}}" />
							<input type="text" class="form-control" name="username" id="username" placeholder="Username" required autofocus>
							<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
							<div class="btn btn-lg btn-primary btn-block" id="login" name="login" type="submit">
							Sign in</div>
						</form>
					</div>
				</div>
			</div>
		</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{$baseurl}}/bootstrap337/js/jquery.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{$baseurl}}/bootstrap337/js/ie10-viewport-bug-workaround.js"></script>

	<script>
		jQuery(document).ready(function(){
			jQuery('#login').click(function(){
				
				var baseurl = jQuery('#baseurl').val();
				var uname = jQuery('#username').val();
				var upass = jQuery('#password').val();
				
				if(uname != "" || upass != "") {
					jQuery.get('token', function(token){
						if(token) {
							//~ var uname = jQuery('#username').val();
							//~ var upass = jQuery('#password').val();
							jQuery.ajax({
								url: baseurl+'/login?_token='+token+'&username='+uname+'&password='+upass,
								method: 'POST',
								//~ data: {username:uname, password: upass},
								success: function(result){
									if(result == "success"){
										window.location.replace(baseurl+'/beranda');
									} else {
										alert(result);
										jQuery('#username').focus();
									}
								},
								error: function(e){
									alert(e);
								}
							});
						} 
					});
				} 
			});
		});
	</script>

  </body>
</html>
