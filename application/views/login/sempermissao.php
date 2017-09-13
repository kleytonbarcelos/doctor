<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title></title>

	<!-- BOOTSTRAP 3.7.3 -->
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/libs/bootstrap/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/libs/bootstrap/css/bootstrap-theme.min.css">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="<?=base_url()?>assets/libs/bootstrap/js/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="<?=base_url()?>assets/libs/bootstrap/js/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="<?=base_url()?>assets/libs/bootstrap/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery/jquery-1.11.3.min.js"></script>

	<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/libs/font-awesome/css/font-awesome.min.css">

	<script src="<?=base_url()?>assets/libs/fancyBox-3.0/dist/jquery.fancybox.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/fancyBox-3.0/dist/jquery.fancybox.min.css">
</head>
<body>

	<div class="alert alert-default display-none" id="alert_sempermissao">
		<h3><i class="fa fa-exclamation-triangle"></i> Alerta!</h3>
		<p>Você não possui permissão para acessar essa área.</p>
		<br>
		<div class="pull-right"><a class="btn btn-default btn-sm" onclick="$.fancybox.close();">&nbsp;OK&nbsp;</a></div>
	</div>
	<script type="text/javascript">
		$.fancybox.open(
		{
			'src':'#alert_sempermissao',
		},
		{
			modal:true,
			afterClose: function()
			{
				window.history.go(-1);
			}
		});
	</script>
</body>
</html>