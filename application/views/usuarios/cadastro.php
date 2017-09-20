<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Cadastro</title>

	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery/jquery-1.11.3.min.js"></script>

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
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/libs/font-awesome/css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/css.css">


	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/select2/dist/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/select2/config.css">
	<script src="<?=base_url()?>assets/libs/select2/dist/js/select2.full.min.js"></script>
	<script src="<?=base_url()?>assets/libs/select2/config.js"></script>


	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>		<!-- JQUERY INPUTMASK (JS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery.inputmask/config.js"></script>		<!-- JQUERY INPUTMASK CONFIG (JS) -->

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/alertifyjs/css/alertify.min.css">										<!-- ALERTIFY (CSS) -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/alertifyjs/css/themes/default.min.css">									<!-- ALERTIFY (CSS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/alertifyjs/alertify.min.js"></script>											<!-- ALERTIFY (JS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/alertifyjs/config.js"></script>													<!-- ALERTIFY (CONFIG) -->

	<style type="text/css">
		body
		{
			background-color: #333F4F;
		}
	</style>

	<script type="text/javascript">
		var base_url = '<?=base_url()?>';
		var base_url_controller = '<?=base_url().$this->router->fetch_class()?>/';
		var controller = '<?=$this->router->fetch_class()?>';
	</script>
	</head>
<body>
	<br><br><br><br>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<img src="<?=base_url()?>assets/img/logo.png">
						<div class="pull-right font-18 color-999">Configurações iniciais</div>
					</h3>
				</div>
				<div class="panel-body">
					<script type="text/javascript">
						$(function()
						{
							$('#formCadastro').bind('callback', function(event, data)
							{
								if(data.status == 1)
								{
									if(data.action=='insert')
									{
										window.location.href=base_url_controller;
									}
									else
									{
										$.toast(
										{
											text: data.msg,
											icon: 'success',
											position: 'top-right',
											//hideAfter: 10000,
											loader: false,
										});
									}
								}
								else
								{
									form_status = {'id':'formCadastro','erros': data.erros};
									formajaxerros('#'+$(this).attr('id'), data.erros);
								}
							});
						});
					</script>
					<?=form_open_multipart('usuarios/cadastro', array('id'=>'formCadastro', 'class'=>'formajax', 'role'=>'form', 'data-callback'=>'true'))?>
					<div class="row">
						<div class="col-md-12">
							<div class="msg"></div>
						</div>
					</div>
					<h4>Dados pessoais</h4>
					<hr>
					<div class="row margin-top-20">
						<div class="col-md-12 font-11">
							<label for="txtPronome" class="control-label font-11">COMO DESEJA EXIBIR SEU NOME?</label>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group form-group-sm">
								<label for="txtNome" class="control-label">Nome</label>
								<input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="Nome" data-field-db="<?=sha1('usuarios.nome')?>">
								<small class="msg-erro text-danger"></small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="pull-right">
								<button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Salvar</button>
							</div>
						</div>
					</div>
					<?=form_close()?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>