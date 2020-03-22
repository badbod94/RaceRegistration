<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title>
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/css/datepicker/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="assets/css/custom.css">
</head>
<body>

<section class="register-page ">
<div class="container">
	<div class="row">
		<div class="col-lg-3"></div>
		<div class="col-lg-6 col-md-12 col-xs-12 col-sm-12">
			<div class="form-wrapper dark-mode">
				<div class="error-msg"></div>
				<div class="success-msg"></div>
			<?php include('template-parts/form.php');?>
		</div>
		</div>
		<div class="col-lg-6"></div>
	</div>
</div>
</section>

<script type="text/javascript" src="assets/js/jquery/jquery-3.4.0.min.js"></script>
<script type="text/javascript" src="assets/js/moment/moment.min.js"></script>
<script type="text/javascript" src="assets/js/datepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="assets/js/custom.js"></script>
</body>
</html>