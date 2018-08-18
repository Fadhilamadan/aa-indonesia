<?php 
if(isset($_COOKIE['loginU'])) {
    header('location: home.php');
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="../assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Login Admin</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

	<!-- Fonts and icons -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- Animation library for notifications -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

	<!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/material-kit.css" rel="stylesheet"/>
</head>

<body class="signup-page">
	<nav class="navbar navbar-transparent navbar-absolute">
    	<div class="container">
        	<div class="row">
				<!--<div class="col-md-12" >
					<?php /*
			        session_start();
			        require './db.php';

			        if(isset($_COOKIE['loginU'])) {
			            header('location: home.php');
			        }
			        if(!isset($_SESSION['notifL'])) {
			                    echo "";
			        }
			        else { ?>
			            <div class="alert alert-danger">
						    <div class="container-fluid">
							  <div class="alert-icon">
							    <i class="material-icons">error_outline</i>
							  </div>
							  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"><i class="material-icons">clear</i></span>
							  </button>
			            <?php
			            echo $_SESSION['notifL']."";
			            unset($_SESSION['notifL']); */ ?>
			            		
							</div>
						</div>
						</div>-->
			            <?php /*
			        } */ ?>
			</div>
    	</div>
    </nav>

    <div class="wrapper">
		<div class="header header-filter" style="background-image: url('assets/img/city.jpg'); background-size: cover; background-position: top center;">
			<div class="container">
				
				<div class="row">
					<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
						<div class="card card-signup">
							<form class="form" id="login" method="POST" action="proses.php?cmd=login">
								<div class="header header-primary text-center">
									<h3>AA Indonesia Admin</h3>
								</div>
								<div class="content">
								
									<div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">face</i>
										</span>
										<input type="text" class="form-control" name="user" placeholder="Username">
									</div>

									<div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">lock_outline</i>
										</span>
										<input type="password" placeholder="Password" name="pass" class="form-control" />
									</div>

								</div>
								<div class="footer text-center">
									<input type="submit" class="btn btn-primary btn-primary" value="Login" />
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		    <footer class="footer">
                <div class="container">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="#">
                                    Media Solution
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                   Blog
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Licenses
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright pull-right">
                        &copy; <script>document.write(new Date().getFullYear())</script> - Made with <i class="fa fa-heart heart"></i> by <a href="#">Media Solution</a>
                    </div>
                </div>
            </footer>

		</div>

    </div>


</body>
	<!--   Core JS Files   -->
	<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/material.min.js"></script>

	<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
	<script src="assets/js/nouislider.min.js" type="text/javascript"></script>

	<!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
	<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

	<!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
	<script src="assets/js/material-kit.js" type="text/javascript"></script>

	<!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

	<script type="text/javascript">

        $('#login').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: 'proses.php?cmd=login',
            data: $('form').serialize(),
            success: function (data) {
            	if(data == 0){
            		$.notify({
	                    // options
	                    icon: 'ti-check',
	                    message: '<strong>Maaf,</strong> Username dan Password yang Anda masukkan tidak cocok.' 
	                },{
	                    // settings
	                    type: 'danger',
	                    placement: {
	                        from: "top",
	                        align: "center"
	                    },
	                });
            	}else{
            		window.location.replace("home.php");
            	}
            }
          });

        });
	</script>

</html>
