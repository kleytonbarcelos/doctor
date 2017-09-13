<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Login</title>
	
	<!-- Bootstrap core CSS -->
	<link href="<?=base_url()?>assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/login2.css"> -->

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/font-awesome/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="<?=base_url()?>assets/libs/bootstrap/js/html5shiv.min.js"></script>
      <script src="<?=base_url()?>assets/libs/bootstrap/js/respond.min.js"></script>
    <![endif]-->
	<style type="text/css">
		body
		{
			background-image: url(<?=base_url()?>assets/img/2.jpg);
			background-repeat: no-repeat;
			background-position: 0 0;
		}

		@import url(http://fonts.googleapis.com/css?family=Roboto);

		/****** LOGIN MODAL ******/
		.loginmodal-container
		{
			padding: 30px;
			max-width: 350px;
			width: 100% !important;
			background-color: #F7F7F7;
			margin: 0 auto;
			border-radius: 2px;
			box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
			overflow: hidden;
			font-family: roboto;
			margin-top: 50%;
		}

		.loginmodal-container h1 {
			text-align: center;
			font-size: 1.8em;
			font-family: roboto;
		}

		.loginmodal-container input[type=submit] {
			width: 100%;
			display: block;
			margin-bottom: 10px;
			position: relative;
		}

		.loginmodal-container input[type=text], input[type=password] {
			height: 44px;
			font-size: 16px;
			width: 100%;
			margin-bottom: 10px;
			-webkit-appearance: none;
			background: #fff;
			border: 1px solid #d9d9d9;
			border-top: 1px solid #c0c0c0;
			/* border-radius: 2px; */
			padding: 0 8px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
		}

		.loginmodal-container input[type=text]:hover, input[type=password]:hover {
			border: 1px solid #b9b9b9;
			border-top: 1px solid #a0a0a0;
			-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
			-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
			box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
		}

		.loginmodal {
			text-align: center;
			font-size: 14px;
			font-family: 'Arial', sans-serif;
			font-weight: 700;
			height: 36px;
			padding: 0 8px;
			/* border-radius: 3px; */
			/* -webkit-user-select: none;
			user-select: none; */
		}

		.loginmodal-submit {
			/* border: 1px solid #3079ed; */
			border: 0px;
			color: #fff;
			text-shadow: 0 1px rgba(0,0,0,0.1); 
			background-color: #4d90fe;
			padding: 17px 0px;
			font-family: roboto;
			font-size: 14px;
			/* background-image: -webkit-gradient(linear, 0 0, 0 100%,	from(#4d90fe), to(#4787ed)); */
		}

		.loginmodal-submit:hover {
			/* border: 1px solid #2f5bb7; */
			border: 0px;
			text-shadow: 0 1px rgba(0,0,0,0.3);
			background-color: #357ae8;
			/* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
		}

		.loginmodal-container a {
			text-decoration: none;
			color: #666;
			font-weight: 400;
			text-align: center;
			display: inline-block;
			opacity: 0.6;
			transition: opacity ease 0.5s;
		} 

		.login-help{
		font-size: 12px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="loginmodal-container">
					<h3><i class="fa fa-user"></i> Login</h3>
					<?=form_open('login/verifica', array('class'=>'form-signin'))?>
						<?=$this->session->flashdata('msg')?>
						<label for="txtUsuario" class="sr-only">Usuário</label>
						<input type="text" name="txtUsuario" id="txtUsuario" class="form-control" placeholder="Usuário" autofocus>
						<label for="txtSenha" class="sr-only">Senha</label>
						<input type="password" name="txtSenha" id="txtSenha" class="form-control" placeholder="Senha">
						<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
					<?=form_close()?>
					<br>
					<div class="login-help">
						<a href="#">Recuperar senha</a>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- /container -->
	<script src="<?=base_url()?>assets/libs/jquery/jquery-1.11.3.min.js"></script>
	<script src="<?=base_url()?>assets/libs/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>