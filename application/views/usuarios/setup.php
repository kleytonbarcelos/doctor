<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Dados complementares</title>

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
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/style.css">


	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/select2/dist/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/select2/config.css">
	<script src="<?=base_url()?>assets/libs/select2/dist/js/select2.full.min.js"></script>
	<script src="<?=base_url()?>assets/libs/select2/config.js"></script>

	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>		<!-- JQUERY INPUTMASK (JS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery.inputmask/config.js"></script>									<!-- JQUERY INPUTMASK CONFIG (JS) -->

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
		<div class="col-md-4 col-md-offset-4">
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
							$('#formSetup').bind('callback', function(event, data)
							{
								if(data.status == 1)
								{
									window.location.href=base_url+'home';
								}
								else
								{
									form_status = {'id':'formSetup','erros': data.erros};
									formajaxerros('#'+$(this).attr('id'), data.erros);
								}
							});
						});
					</script>
					<?=form_open_multipart('usuarios/salvarsetup', array('id'=>'formSetup', 'class'=>'formajax', 'role'=>'form', 'data-callback'=>'true'))?>
					<input type="hidden" id="usuario_id" name="usuario_id" data-field-db="<?=sha1('usuarios.id')?>">
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
					<div class="row margin-top-10">
						<div class="col-md-3">
							<div class="form-group form-group-sm">
								<select class="select2" id="txtPronome" name="txtPronome">
									<option value="NULL">&nbsp;</option>
								</select>
								<script type="text/javascript">
									$(function()
									{
										var pronomes = $.ajax(
										{
											url: base_url_controller+'pronomes',
											type: 'POST',
											dataType: 'json',
											success: function(data)
											{
												$.each(data.pronomes, function(index, val)
												{
													$('#txtPronome').append('<option value="'+val.id+'">'+val.nome+'</option>');
												});
											}
										});
										$.when(pronomes).done(function()
										{
											$('#txtPronome').val(1);
										});
									});
								</script>
							    <small class="msg-erro text-danger"></small>
							</div>
						</div>
						<div class="col-md-9">
							<div class="form-group form-group-sm">
								<input type="text" class="form-control" id="txtNome" name="txtNome" data-field-db="<?=sha1('usuarios.nome')?>" placeholder="Nome" value="<?=$this->session->dados_usuario->nome?>">
								<small class="msg-erro text-danger"></small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group form-group-sm">
								<label for="txtNumeroConselho" class="control-label font-11">PROFISSÃO</label>
								<select class="select2" id="txtProfissao" name="txtProfissao" data-field-db="<?=sha1('usuarios.profissao_id')?>">
									<option value="NULL">&nbsp;</option>
								</select>
								<script type="text/javascript">
									$(function()
									{
										$.ajax(
										{
											url: base_url_controller+'profissoes',
											type: 'POST',
											dataType: 'json',
											success: function(data)
											{
												$.each(data.profissoes, function(index, val)
												{
													$('#txtProfissao').append('<option value="'+val.id+'">'+val.nome+'</option>');
												});
											}
										});
										$('#txtProfissao').on('change', function(event)
										{
											event.preventDefault();

											if( $(this).val() == 1 || $(this).val() == 5 ) // 'Médico' ou 'Outro profissional de saúde'
											{
												$('.row-especialidade').slideDown();
											}
											else
											{
												$('.row-especialidade').slideUp();
											}
										});
									});
								</script>
							    <small class="msg-erro text-danger"></small>
							</div>
						</div>
					</div>
					<div class="row row-especialidade display-none">
						<div class="col-md-12">
							<div class="form-group form-group-sm">
								<label for="txtNumeroConselho" class="control-label font-11">ESPECIALIDADE</label>
								<select class="select2" id="txtEspecialidade" name="txtEspecialidade" data-field-db="<?=sha1('usuarios.especialidade_id')?>">
									<option value=""></option>
								</select>
								<script type="text/javascript">
									$(function()
									{
										$.ajax(
										{
											url: base_url+'tiss/tiss_cbos',
											type: 'POST',
											dataType: 'json',
											success: function(data)
											{
												$.each(data.tiss_cbos, function(index, val)
												{
													$('#txtEspecialidade').append('<option value="'+val.id+'">'+val.nome+'</option>');
												});
											}
										});
									});
								</script>
							    <small class="msg-erro text-danger"></small>
							</div>
						</div>
					</div>
					<div class="row row-especialidade display-none">
						<div class="col-md-6">
							<div class="form-group form-group-sm">
								<label for="txtNumeroConselho" class="control-label font-11">CONSELHO</label>
								<select class="select2" id="txtConselho" name="txtConselho" data-field-db="<?=sha1('usuarios.conselho_id')?>">
									<option value="NULL">&nbsp;</option>
								</select>
								<script type="text/javascript">
									$(function()
									{
										$.ajax(
										{
											url: base_url+'tiss/tiss_conselhos',
											type: 'POST',
											dataType: 'json',
											success: function(data)
											{
												$.each(data.tiss_conselhos, function(index, val)
												{
													$('#txtConselho').append('<option value="'+val.id+'">'+val.nome+'</option>');
												});
											}
										});
									});
								</script>
							    <small class="msg-erro text-danger"></small>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group form-group-sm">
								<label for="txtNumeroConselho" class="control-label font-11">NÚMERO DO CONSELHO</label>
								<input type="text" class="form-control" id="txtNumeroConselho" name="txtNumeroConselho" data-field-db="<?=sha1('usuarios.numeroconselho')?>" placeholder="Número conselho">
								<small class="msg-erro text-danger"></small>
							</div>
						</div>
					</div>
					<h4>Dados da clínica</h4>
					<hr>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group form-group-sm">
								<label for="txtNomeClinica" class="control-label font-11">NOME DA CLÍNICA</label>
								<input type="text" class="form-control" id="txtNomeClinica" name="txtNomeClinica" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('clinicas.nome')?>" placeholder="Nome da Clinica">
								<small class="msg-erro text-danger"></small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-group-sm">
								<label for="txtTelefone" class="control-label font-11">TELEFONE DA CLÍNICA</label>
								<input type="text" class="form-control inputmask-celular" id="txtTelefone" name="txtTelefone" placeholder="Telefone" data-field-db="<?=sha1('clinicas.telefone')?>">
								<small class="msg-erro text-danger"></small>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group form-group-sm">
							    <label for="txtProfissionaisDeSaude" class="control-label font-11">NÚMERO DE PROFISSIONAIS DE SAÚDE</label>
								<select class="select2" id="txtProfissionaisDeSaude" name="txtProfissionaisDeSaude" data-field-db="<?=sha1('clinicas.profissionaissaude')?>">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5-10">5-10</option>
									<option value=">10">Mais de 10</option>
								</select>
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
					<script type="text/javascript">
						setTimeout(function()
						{
							getvaluesinputs('usuarios', <?=$usuario_id?>);
						}, 500);
					</script>
				</div>
			</div>
		</div>
	</div>
</body>
</html>