<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Login</title>

	<!-- Bootstrap -->
	<link href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="<?=base_url()?>assets/bootstrap/js/html5shiv.min.js"></script>
	<script src="<?=base_url()?>assets/bootstrap/js/respond.min.js"></script>
	<![endif]-->

	<link href="<?=base_url()?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<style type="text/css">
		.login-panel {
			margin-top: 50%;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="login-panel panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Login</h3>
					</div>
					<div class="panel-body">
						<?php echo form_open('login/atualizar'); ?>
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="E-mail" name="email" type="text" value="<?=set_value('email')?>" autofocus>
									<?php echo form_error('email'); ?>
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Senha" name="senha" type="password" value="<?=set_value('senha')?>">
									<?php echo form_error('senha'); ?>
								</div>
								<div class="checkbox">
									<label>
										<input name="remember" type="checkbox" value="Remember Me">Lembrar senha
									</label>
								</div>
								<input type="submit" name="login" class="btn btn-lg btn-success btn-block">
							</fieldset>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

