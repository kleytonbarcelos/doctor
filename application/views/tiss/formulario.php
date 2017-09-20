<!--
	AUTOPREENCHIVEL

	1 - Nome Paciente
	10 - Nome Prestador (médico)
	13 - Conselho (médico)
	14 - Número Conselho (médico)
	16 - CBO (profissão do médico
	21 - Código do procedimento
-->

<?php
	$titulo_formulario = ( $this->router->fetch_method() == 'cadastrar' ) ? '<strong><i class="fa fa-plus-square"></i>&nbsp;Guia de consulta</strong><span class="pull-right">v. 3.03.01</span>' : '<strong><i class="glyphicon glyphicon-edit"></i>&nbsp;Guia de consulta</strong><span class="pull-right">v. 3.03.01</span>';
?>
<?=form_open_multipart('tiss/salvar', array('id'=>'formTiss', 'role'=>'form'))?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/tiss.css">
<div class="row tiss" style="background-color: #fff;padding: 10px;margin: 10px;">
<div class="col-md-12">
	<input type="hidden" id="id" name="id" data-field-db="id" value="<?=$dados->id?>">
	<h4><?=$titulo_formulario?></h4>
	<hr>
	<div class="msg"></div>
	<div class="row">
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtPaciente">Paciente</label>
						<div class="input-group">
							<input type="hidden" id="paciente_id" name="paciente_id" data-callback="true" data-field-db="<?=sha1('tiss.paciente_id')?>">
							<input type="text" id="txtPaciente" name="txtPaciente" class="search-query form-control" aria-describedby="basic-addon2" autocomplete="off" spellcheck="false" dir="auto">
							<span class="input-group-addon" id="basic-addon2">
								<i class="fa fa-search"></i>
							</span>
						</div>
						<script type="text/javascript">
							$(function()
							{
								var icone_carregando_typeahead = null;
								$('#txtPaciente').on('keydown', function(event)
								{
									$element = $(this);
									if( $element.val().length <= 1 ){$('#paciente_id').val('')}

									if(!icone_carregando_typeahead)
									{
										$element.parent('.input-group').find('.input-group-addon').html('<i class="fa fa-spinner fa-pulse"></i>');
										icone_carregando_typeahead = setTimeout(function()
										{
											$element.parent('.input-group').find('.input-group-addon').html('<i class="fa fa-search"></i>');
											icone_carregando_typeahead=null;
										}, 1000);
									}
								});
								$('#txtPaciente').typeahead(
								{
									scrollBar:true,
									ajax:
									{
										url: base_url+'pacientes/typeahead',
										triggerLength: 1,
										//items: 20,
										method:'POST',
										displayField: 'text',
										preProcess: function (data)
										{
											if (data.status == 1)
											{
												var list = [];
												$.each(data.dados, function(index, val)
												{
													list[index] = {'id':val.id, 'text':val.nome.toUpperCase()};
												});
												return list;
											}
											else
											{
												return false;
											}
										}
									},
									onSelect: function(data)
									{
										$('#paciente_id').val(data.value);
									}
								});
								$('#paciente_id').bind('callback', function()
								{
									$.ajax(
									{
										url: base_url+'pacientes/get',
										type: 'POST',
										data: 'id='+$('#paciente_id').val(),
										dataType: 'json',
										success: function(data)
										{
											$('#txtPaciente').val( data.dados.nome.toUpperCase() );
										}
									});
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtRegistroAns">1 - Registro na ANS*</label>
						<div class="input-group">
							<input type="hidden" id="registroans_id" name="registroans_id" data-callback="true" data-field-db="<?=sha1('tiss.registroans_id')?>">
							<input type="text" id="txtRegistroAns" name="txtRegistroAns" class="search-query form-control" aria-describedby="basic-addon2" autocomplete="off" spellcheck="false" dir="auto">
							<span class="input-group-addon" id="basic-addon2">
								<i class="fa fa-search"></i>
							</span>
						</div>
						<script type="text/javascript">
							$(function()
							{
								var icone_carregando_typeahead = null;
								$('#txtRegistroAns').on('keydown', function(event)
								{
									$element = $(this);
									if( $element.val().length <= 1 ){$('#registroans_id').val('')}

									if(!icone_carregando_typeahead)
									{
										$element.parent('.input-group').find('.input-group-addon').html('<i class="fa fa-spinner fa-pulse"></i>');
										icone_carregando_typeahead = setTimeout(function()
										{
											$element.parent('.input-group').find('.input-group-addon').html('<i class="fa fa-search"></i>');
											icone_carregando_typeahead=null;
										}, 1000);
									}
								});
								$('#txtRegistroAns').typeahead(
								{
									scrollBar:true,
									ajax:
									{
										url: base_url+'tiss/typeahead_registrosans',
										triggerLength: 1,
										//items: 20,
										method:'POST',
										displayField: 'text',
										preProcess: function (data)
										{
											if (data.status == 1)
											{
												var list = [];
												$.each(data.dados, function(index, val)
												{
													list[index] = {'id':val.id, 'text':'<strong>'+val.registroans+'</strong> - '+val.razaosocial};
												});
												return list;
											}
											else
											{
												return false;
											}
										}
									},
									onSelect: function(data)
									{
										$('#registroans_id').val(data.value);
									}
								});
								$('#registroans_id').bind('callback', function()
								{
									$.ajax(
									{
										url: base_url+'tiss/typeahead_registrosans/'+$('#registroans_id').val(),
										type: 'POST',
										dataType: 'json',
										success: function(data)
										{
											$('#txtRegistroAns').val( data.dados.registroans+' - '+data.dados.razaosocial );
										}
									});
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtNumeroGuias">2 - Número da guia*</label>
						<!-- <input type="number" min="1" max="20" step="1" value="1" class="form-control" id="txtNumeroGuias" name="txtNumeroGuias"> -->
						<div class="input-group spinner" data-trigger="spinner">
							<input type="text" class="form-control text-center" id="txtNumeroGuias" name="txtNumeroGuias" data-field-db="<?=sha1('tiss.numeroguias')?>" value="1" data-rule="quantity" autocomplete="off" spellcheck="false" dir="auto">
							<div class="input-group-addon">
								<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-caret-up"></i></a>
								<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-caret-down"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss bg-eee">
					<div class="form-group form-group-sm">
						<label for="txtNumeroGuiasOperadora">3 - Número da guia na operadora</label>
						<!-- <input type="number" min="1" max="20" step="1" value="1" class="form-control" id="txtNumeroGuiasOperadora" name="txtNumeroGuiasOperadora"> -->
						<div class="input-group spinner" data-trigger="spinner">
							<input type="text" class="form-control text-center" id="txtNumeroGuiasOperadora" name="txtNumeroGuiasOperadora" data-field-db="<?=sha1('tiss.numeroguiasoperadora')?>" value="1" data-rule="quantity" autocomplete="off" spellcheck="false" dir="auto">
							<div class="input-group-addon">
								<a href="javascript:;" class="spin-up" data-spin="up"><i class="fa fa-caret-up"></i></a>
								<a href="javascript:;" class="spin-down" data-spin="down"><i class="fa fa-caret-down"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<h5 class="font-14 font-bold">DADOS DO PACIENTE</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtNumeroCartao">4 - Número do cartão*</label>
						<input type="text" class="form-control" id="txtNumeroCartao" name="txtNumeroCartao" data-field-db="<?=sha1('tiss.numerocartao')?>" autocomplete="off" spellcheck="false" dir="auto">
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss bg-eee">
					<div class="form-group form-group-sm">
						<label for="txtValidadeCarteira">5 - Validade da carteirinha</label>
						<div class="input-group date datetimepicker-data">
							<input type="text" class="form-control inputmask-data" id="txtValidadeCarteira" name="txtValidadeCarteira" data-field-db="<?=sha1('tiss.validadecarteira')?>" placeholder="__/__/____" autocomplete="off" spellcheck="false" dir="auto">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
						<small class="msg-erro text-danger"></small>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default bg-eee">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtRecemNascido">6 - Recém nascido</label>
						<input class="margin-left-20" type="checkbox" id="txtRecemNascido" name="txtRecemNascido" data-field-db="<?=sha1('tiss.recemnascido')?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-md-8">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtNome">7 - Nome*</label>
						<div class="input-group">
							<input type="hidden" id="paciente_id_old" name="paciente_id_old" data-callback="true" data-field-db="<?=sha1('tiss.paciente_id_old')?>">
							<input type="text" id="txtNome" name="txtNome" data-field-db="<?=sha1('tiss.nomepaciente')?>" class="search-query form-control" aria-describedby="basic-addon2" autocomplete="off" spellcheck="false" dir="auto">
							<span class="input-group-addon" id="basic-addon2">
								<i class="fa fa-search"></i>
							</span>
						</div>
						<script type="text/javascript">
							$(function()
							{
								var icone_carregando_typeahead = null;
								$('#txtNome').on('keydown', function(event)
								{
									$element = $(this);
									if( $element.val().length <= 1 ){$('#paciente_id_old').val('')}

									if(!icone_carregando_typeahead)
									{
										$element.parent('.input-group').find('.input-group-addon').html('<i class="fa fa-spinner fa-pulse"></i>');
										icone_carregando_typeahead = setTimeout(function()
										{
											$element.parent('.input-group').find('.input-group-addon').html('<i class="fa fa-search"></i>');
											icone_carregando_typeahead=null;
										}, 1000);
									}
								});
								$('#txtNome').typeahead(
								{
									scrollBar:true,
									ajax:
									{
										url: base_url+'pacientes/typeahead',
										triggerLength: 1,
										//items: 20,
										method:'POST',
										displayField: 'text',
										preProcess: function (data)
										{
											if (data.status == 1)
											{
												var list = [];
												$.each(data.dados, function(index, val)
												{
													list[index] = {'id':val.id, 'text':val.nome.toUpperCase()};
												});
												return list;
											}
											else
											{
												return false;
											}
										}
									},
									onSelect: function(data)
									{
										$('#paciente_id_old').val(data.value);
									}
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss bg-eee">
					<div class="form-group form-group-sm">
						<label for="txtNumeroCns">8 - Número no CNS</label>
						<input type="text" class="form-control" id="txtNumeroCns" name="txtNumeroCns" data-field-db="<?=sha1('tiss.numerocns')?>" autocomplete="off" spellcheck="false" dir="auto">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<h5 class="font-14 font-bold">DADOS DO CONTRATADO</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2 col-md-2">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<select class="form-control" id="txtTipoDocumentoPrestador" name="txtTipoDocumentoPrestador" data-field-db="<?=sha1('tiss.tipodocumentoprestador')?>">
							<option value="CODIGOOPERADORA">Código do prestador na operadora</option>
							<option value="CPF">CPF</option>
							<option value="CNPJ">CNPJ</option>
						</select>
						<input type="text" class="form-control" id="txtDocumentoPrestador" name="txtDocumentoPrestador" data-field-db="<?=sha1('tiss.documentoprestador')?>" autocomplete="off" spellcheck="false" dir="auto">
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-8 col-md-8">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtNomePrestador">10 - Nome do prestador*</label>
						<input type="text" class="form-control" id="txtNomePrestador" name="txtNomePrestador" data-field-db="<?=sha1('tiss.nomeprestador')?>" autocomplete="off" spellcheck="false" dir="auto">
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-2 col-md-2">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtCodigoCnes">11 - Código no CNES*</label>
						<input type="text" class="form-control" id="txtCodigoCnes" name="txtCodigoCnes" data-field-db="<?=sha1('tiss.codigocnes')?>" autocomplete="off" spellcheck="false" dir="auto">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss bg-eee">
					<div class="form-group form-group-sm">
						<label for="txtNomeExecutor">12 - Nome do executor</label>
						<input type="text" class="form-control" id="txtNomeExecutor" name="txtNomeExecutor" data-field-db="<?=sha1('tiss.nomeexecutor')?>" autocomplete="off" spellcheck="false" dir="auto">
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-2 col-md-2">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtConselho">13 - Conselho*</label>
						<select class="select2" id="txtConselho" name="txtConselho" data-field-db="<?=sha1('tiss.conselho_id')?>">
							<option value="">&nbsp;</option>
						</select>
						<script type="text/javascript">
							$(function()
							{
								$.ajax(
								{
									url: base_url_controller+'tiss_conselhos',
									type: 'POST',
									dataType: 'json',
									success: function(data)
									{
										$.each(data.tiss_conselhos, function(index, val)
										{
											$('#txtConselho').append('<option value="'+val.id+'">'+val.nome+' - '+val.descricao+'</option>');
										});
									}
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-2 col-md-2">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtNumeroConselho">14 - Número*</label>
						<input type="text" class="form-control" id="txtNumeroConselho" name="txtNumeroConselho" data-field-db="<?=sha1('tiss.numeroconselho')?>" autocomplete="off" spellcheck="false" dir="auto">
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-2 col-md-2">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtUfExecutor">15 - Estado*</label>
						<select class="form-control form-control" id="txtUfExecutor" name="txtUfExecutor" data-field-db="<?=sha1('tiss.ufexecutor')?>">
							<option value="AC">Acre</option>
							<option value="AL">Alagoas</option>
							<option value="AP">Amapá</option>
							<option value="AM">Amazonas</option>
							<option value="BA">Bahia</option>
							<option value="CE">Ceará</option>
							<option value="DF">Distrito Federal</option>
							<option value="ES">Espírito Santo</option>
							<option value="GO">Goias</option>
							<option value="MA">Maranhão</option>
							<option value="MT">Mato Grosso</option>
							<option value="MS">Mato Grosso do Sul</option>
							<option value="MG">Minas Gerais</option>
							<option value="PA">Pará</option>
							<option value="PB">Paraíba</option>
							<option value="PR">Paraná</option>
							<option value="PE">Pernambuco</option>
							<option value="PI">Piauí</option>
							<option value="RJ">Rio de Janeiro</option>
							<option value="RN">Rio Grande do Norte</option>
							<option value="RS">Rio Grande do Sul</option>
							<option value="RO">Rondônia</option>
							<option value="RR">Roraima</option>
							<option value="SC">Santa Catarina</option>
							<option value="SP">São Paulo</option>
							<option value="SE">Sergipe</option>
							<option value="TO">Tocantins</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-2 col-md-2">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtCbos">16 - CBO-S*</label>
						<select class="select2" id="txtCbos" name="txtCbos" data-field-db="<?=sha1('tiss.cbo_id')?>">
							<option value="">&nbsp;</option>
						</select>
						<script type="text/javascript">
							$(function()
							{
								$.ajax(
								{
									url: base_url_controller+'tiss_cbos',
									type: 'POST',
									dataType: 'json',
									success: function(data)
									{
										$.each(data.tiss_cbos, function(index, val)
										{
											$('#txtCbos').append('<option value="'+val.id+'">'+val.codigo+' - '+val.nome+'</option>');
										});
									}
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<h5 class="font-14 font-bold">CONSULTA</h5>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtIndicacaoAcidente">17 - Indicação de acidente*</label>
						<select class="select2" id="txtIndicacaoAcidente" name="txtIndicacaoAcidente" data-field-db="<?=sha1('tiss.indicacaoacidente_id')?>">
							<option value="">&nbsp;</option>
						</select>
						<script type="text/javascript">
							$(function()
							{
								var ajax = $.ajax(
								{
									url: base_url_controller+'tiss_indicacaoacidentes',
									type: 'POST',
									dataType: 'json',
									success: function(data)
									{
										$.each(data.tiss_indicacaoacidentes, function(index, val)
										{
											$('#txtIndicacaoAcidente').append('<option value="'+val.id+'">'+val.codigo+' - '+val.nome+'</option>');
										});
									}
								});
								$.when(ajax).done(function()
								{
									$('#txtIndicacaoAcidente').val(4);
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtDataConsulta">18 - Data da consulta*</label>
						<div class="input-group date datetimepicker-data">
							<input type="text" class="form-control inputmask-data" id="txtDataConsulta" name="txtDataConsulta" data-field-db="<?=sha1('tiss.dataconsulta')?>" placeholder="__/__/____" autocomplete="off" spellcheck="false" dir="auto">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
						<small class="msg-erro text-danger"></small>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtTipoConsulta">19 - Tipo da consulta*</label>
						<select class="select2" id="txtTipoConsulta" name="txtTipoConsulta" data-field-db="<?=sha1('tiss.tipoconsulta_id')?>">
							<option value="">&nbsp;</option>
						</select>
						<script type="text/javascript">
							$(function()
							{
								$.ajax(
								{
									url: base_url_controller+'tiss_tipoconsultas',
									type: 'POST',
									dataType: 'json',
									success: function(data)
									{
										$.each(data.tiss_tipoconsultas, function(index, val)
										{
											$('#txtTipoConsulta').append('<option value="'+val.id+'">'+val.codigo+' - '+val.nome+'</option>');
										});
									}
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtCodigoTabela">20 - Código da tabela*</label>
						<select class="select2" id="txtCodigoTabela" name="txtCodigoTabela" data-field-db="<?=sha1('tiss.codigotabela_id')?>">
							<option value="">&nbsp;</option>
						</select>
						<script type="text/javascript">
							$(function()
							{
								var ajax = $.ajax(
								{
									url: base_url_controller+'tiss_codigotabelas',
									type: 'POST',
									dataType: 'json',
									success: function(data)
									{
										$.each(data.tiss_codigotabelas, function(index, val)
										{
											$('#txtCodigoTabela').append('<option value="'+val.id+'">'+val.codigo+' - '+val.nome+'</option>');
										});
									}
								});
								$.when(ajax).done(function()
								{
									$('#txtCodigoTabela').val(4);
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtCodigoProcedimento">21 - Código do procedimento*</label>
						<div class="input-group">
							<input type="hidden" id="codigoprocedimento_id" name="codigoprocedimento_id" data-callback="true" data-field-db="<?=sha1('tiss.codigoprocedimento_id')?>">
							<input type="text" id="txtCodigoProcedimento" name="txtCodigoProcedimento" class="search-query form-control" aria-describedby="basic-addon2" autocomplete="off" spellcheck="false" dir="auto">
							<span class="input-group-addon" id="basic-addon2">
								<i class="fa fa-search"></i>
							</span>
						</div>
						<script type="text/javascript">
							$(function()
							{
								var icone_carregando_typeahead = null;
								$('#txtCodigoProcedimento').on('keydown', function(event)
								{
									$element = $(this);
									if( $element.val().length <= 1 ){$('#codigoprocedimento_id').val('')}

									if(!icone_carregando_typeahead)
									{
										$element.parent('.input-group').find('.input-group-addon').html('<i class="fa fa-spinner fa-pulse"></i>');
										icone_carregando_typeahead = setTimeout(function()
										{
											$element.parent('.input-group').find('.input-group-addon').html('<i class="fa fa-search"></i>');
											icone_carregando_typeahead=null;
										}, 1000);
									}
								});
								$('#txtCodigoProcedimento').typeahead(
								{
									scrollBar:true,
									ajax:
									{
										url: base_url+'tiss/typeahead_codigoprocedimentos',
										triggerLength: 1,
										//items: 20,
										method:'POST',
										displayField: 'text',
										preProcess: function (data)
										{
											if (data.status == 1)
											{
												var list = [];
												$.each(data.dados, function(index, val)
												{
													list[index] = {'id':val.id, 'text':val.codigo+' - '+val.nome};
												});
												return list;
											}
											else
											{
												return false;
											}
										}
									},
									onSelect: function(data)
									{
										codigo = data.text.split(' - ');
										$('#txtCodigoProcedimento').val(codigo[0]);
										$('#codigoprocedimento_id').val(data.value);
									}
								});
								$('#codigoprocedimento_id').bind('callback', function()
								{
									$.ajax(
									{
										url: base_url+'tiss/typeahead_codigoprocedimentos/'+$('#codigoprocedimento_id').val(),
										type: 'POST',
										dataType: 'json',
										success: function(data)
										{
											$('#txtCodigoProcedimento').val( data.dados.codigo );
										}
									});
								});
							});
						</script>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-default">
				<div class="panel-body panel-body-tiss">
					<div class="form-group form-group-sm">
						<label for="txtValorProcedimento">22 - Valor do procedimento*</label>
						<input type="text" class="form-control valor" id="txtValorProcedimento" name="txtValorProcedimento" data-field-db="<?=sha1('tiss.valorprocedimento')?>" autocomplete="off" spellcheck="false" dir="auto">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-12">
			<div class="panel panel-default bg-eee">
				<div class="panel-body">
					<div class="form-group form-group-sm">
						<label for="txtObservacao">23 - Observações</label>
						<textarea class="form-control" id="txtObservacao" name="txtObservacao" data-field-db="<?=sha1('tiss.observacoes')?>" style="min-height: 80px !important;"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="pull-right">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Salvar</button>
			</div>
		</div>
	</div>
</div>
</div>




<a href="javascript:void(0);" onclick="jspdf('#atestado', 'modal');" class="btn btn-info btn-lg">jsPDF</a>
<a href="javascript:void(0);" onclick="mpdf('#loremfull')" class="btn btn-danger btn-lg">PDF (mPDF)</a>
<a href="javascript:void(0);" onclick="mpdf('#atestado')" class="btn btn-warning btn-lg">PDF (mPDF) - Prontuário</a>
<div id="loremfull">
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

<div style="width: 37%;height: 150px;position: absolute;bottom: 100px;left:55px;border: 2px solid #000;padding: 10px;font-size: 11px;font-weight: bold;text-align:center;">
	<div style="font-size: 14px;">Identificação do comprador</div>
	<div><br></div>
	<div>Nome: ____________________________________________</div>
	<div>___________________________________________________</div>
	<div>RG: ___________________  Emissor: _________________</div>
	<div>Endereço: ________________________________________</div>
	<div>___________________________________________________</div>
	<div>Cidade: ________________________________ UF: _____</div>
	<div>Telefone: ________________________________________</div>
</div>
<div style="width: 37%;height: 150px;position: absolute;bottom: 100px;right:55px;border: 2px solid #000;padding: 10px;font-size: 11px;font-weight: bold;text-align:center;">
	<div style="font-size: 14px;">Identificação do fornecedor</div>
	<div><br><br>______________________________________</div>
	<div>Assinatura farmacêutico</div>
	<div><br><br>Data: _____/_____/_________</div>
</div>


</div>
<div id="atestado">
	<?php
		echo '<pre>';	
			print_r($this->session->dados_usuario);
		echo '</pre>';
	?>
	<div class="conteudo_completo">
		<div>
			Atesto para os devidos fins a pedido do interessado que KLEYTON BARCELOS RANGEL DE OLIVEIRA, foi
			submetido à consulta médica nesta data.
			<br><br><br>
			Em decorrência, deverá permanecer afastado de suas atividades laborativas por um período de 3 dias a partir
			desta data.
			<style type="text/css">
				body{background: url('<?=base_url()?>assets/img/bgprontuario.jpg') no-repeat;}
			</style>
		</div>
		<footer>
			<div style="width: 37%;height: 150px;position: absolute;bottom: 100px;left:55px;border: 2px solid #000;padding: 10px;font-size: 11px;font-weight: bold;text-align:center;">
				<div style="font-size: 14px;">Identificação do comprador</div>
				<div><br></div>
				<div>Nome: ____________________________________________</div>
				<div>___________________________________________________</div>
				<div>RG: ___________________  Emissor: _________________</div>
				<div>Endereço: ________________________________________</div>
				<div>___________________________________________________</div>
				<div>Cidade: ________________________________ UF: _____</div>
				<div>Telefone: ________________________________________</div>
			</div>
			<div style="width: 37%;height: 150px;position: absolute;bottom: 100px;right:55px;border: 2px solid #000;padding: 10px;font-size: 11px;font-weight: bold;text-align:center;">
				<div style="font-size: 14px;">Identificação do fornecedor</div>
				<div><br><br>______________________________________</div>
				<div>Assinatura farmacêutico</div>
				<div><br><br>Data: _____/_____/_________</div>
			</div>
			<div style="float:right">
				<div><strong>Dr. Fabio</strong></div>
				<div>CRM: 31234654</div>
				<div>Telefone(s): 28 3552-8962</div>
			</div>
		</footer>
	</div>
</div>
	<script type="text/javascript">
		function clear_inputs_modal()
		{
			$('#formTiss').find(':text, :password, :file, textarea').val('');
			$('#formTiss').find(':radio, :checkbox').attr("checked",false);
			$('#formTiss').find('select').val('');
			clear_form_erros();
		}
		function clear_form_erros()
		{
			$('.msg').html('');
			$('.msg-erro').html('');
			$('.has-error').removeClass('has-error');
			$('.modal-msg').html('');
			$('.nav-tabs').find('.cont').html(''); // Limpa contadores de erros (NAVTABS)
			$('.nav-tabs a:first').tab('show');
		}
		setTimeout(function()
		{
			getvaluesinputs('tiss', $('#id').val());
		}, 500);
		$(function()
		{
			$('#formTiss').on('submit', function(event)
			{
				event.preventDefault();

				clear_form_erros();

				var $form = $(this);
				var $button_submit = $form.find('button:submit');
				$button_submit.data('loading-text', '<i class="fa fa-circle-o-notch fa-spin"></i> Carregando...');
				$button_submit.button('loading');
					//################################################################################################ // FIX ENVIAR FORM NORMAL OU UPLOAD
				var $data;
				var contentType = "application/x-www-form-urlencoded";
				var processData = true;
					//################################################################################################
				if( $form.attr('enctype') == 'multipart/form-data' )
				{
					$('[class^="ckeditor"]').each(function(index, el)
					{
						var name = $(el).attr('name');
						CKEDITOR.instances[name].updateElement();
					});
					
					var $data = new FormData( $form.get(0) );
					var contentType = false;
					var processData = false;
					//################################################################################################
					// FIX para correção de erros de enviar input:checbox VAZIOS juntos com os outros campos via ajax.
					$form.find('input:checkbox').each(function(index, el)
					{
						console.log( $(el).prop('checked') );
						if( $(el).prop('checked') == false )
						{
							value = ($(el).data('value')) ? $(el).data('value') : 'off';
							$(el).prop('value', value);
							$(el).prop('checked', false);
							$data.append( $(el).prop('name'), 0 );
						}
						else
						{
							value = ($(el).data('value')) ? $(el).data('value') : 'on';
							$(el).prop('value', value);
							$(el).prop('checked', true);
							$data.append( $(el).prop('name'), 1 );
						}
					});
					//################################################################################################
					//$data.append('txtCAMPO', 'txtCAMPO_VALUE');
				}
				else
				{
					//################################################################################################
					// FIX para correção de erros de enviar input:checbox VAZIOS juntos com os outros campos via ajax.
					var $data = $form.serialize()+'&'+$form.find('input:checkbox').map(function(i, e)
					{
						if( $(e).prop('checked') == false )
						{
							value = ($(e).data('value')) ? $(e).data('value') : 'off';
							$(e).prop('value', value);
							$(e).prop('checked', false);
							return $(e).prop('name')+'=0';
						}
						else
						{
							value = ($(e).data('value')) ? $(e).data('value') : 'on';
							$(e).prop('value', '1');
							$(e).prop('checked', true);
						}
					}).get().join('&');
					//################################################################################################
				}
				$.ajax(
				{
					url: $form.attr('action'),
					type: $form.attr('method'),
					data: $data,
					dataType: 'json',
					cache : false,
					contentType: contentType,
					processData: processData,
				})
				.done(function(data) //success
				{
					//console.log("success");
					$button_submit.button('reset');

					if(data.status == 1)
					{
						//alert_success('.msg', data.msg);
						alertify.success('<i class="fa fa-check-circle-o"></i> '+data.msg);
						if(data.acao=='cadastrar')
						{
							window.location.href=base_url_controller;
						}
					}
					else
					{
						var LinkNavTabs = '';
						var cont = 0;
						var msg = '';
						$.each(data.erros, function(campo, valor)
						{
							var Input = $('[name='+campo+']');
							//Input.nextAll('.msg-erro').eq(0).html(valor);
							Input.parents('.form-group').eq(0).addClass('has-error');
							msg += '<div><small>'+valor+'</small></div>';

							LinkNavTabs = Input.parents('.tab-pane').eq(0).prop('id');
							if(LinkNavTabs)
							{
								var ElementCont = $('.nav-tabs a[aria-controls="'+LinkNavTabs+'"]').find('.cont');
								cont = parseInt( ElementCont.text() );
								if( isNaN(cont) )
								{
									cont=1;
								}
								else
								{
									cont = cont + 1;
								}
								ElementCont.html('<span class="badge">'+cont+'</span>'); //.html('<span class="label label-warning">'+cont+'</span>');
								cont = 0;
							}
						});
						$('.msg')
						.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>')
						.show();

						if(LinkNavTabs)
						{
							$element = null;
							$tab = null;
							$('.nav-tabs').find('.cont').each(function(index, el)
							{
								if( $(el).text().length > 0 )
								{
									$element = $(el);
									return false;
								}
							});
							//console.log('tab: '+$element.parents('a').attr('aria-controls'));
							$element.parents('a').tab('show');
						}
					}
				})
				.fail(function()
				{
					//console.log("error");
					$button_submit.button('reset');
				})
				.always(function()
				{
					//console.log("complete");
					$button_submit.button('reset');
				});
			});
		});
	</script>
<?=form_close()?>