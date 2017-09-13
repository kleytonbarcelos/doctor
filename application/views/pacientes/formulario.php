<?php
	$titulo_formulario = ( $this->router->fetch_method() == 'cadastrar' ) ? '<strong><i class="fa fa-plus-square"></i>&nbsp;Cadastro Paciente</strong>' : '<strong><i class="glyphicon glyphicon-edit"></i>&nbsp;Editar Paciente</strong>';
?>
<?=form_open_multipart('pacientes/salvar', array('id'=>'formModelosPrescricoes', 'role'=>'form'))?>
	<input type="hidden" id="id" name="id" data-field-db="id" value="<?=$dados->id?>">
	<h4><?=$titulo_formulario?></h4>
	<hr>
	<div class="msg"></div>
	<div class="row">
		<div class="col-md-12">
			<div role="tabpanel">
				<ul class="nav nav-tabs nav-justified" role="tablist">
					<li role="presentation" class="active">
						<a href="#home" aria-controls="home" role="tab" data-toggle="tab">Geral <small class="cont pull-right"></small></a>
					</li>
					<li role="presentation">
						<a href="#dadoscomplementares" aria-controls="dadoscomplementares" role="tab" data-toggle="tab">Dados complementares <small class="cont pull-right"></small></a>
					</li>
					<li role="presentation">
						<a href="#convenio" aria-controls="convenio" role="tab" data-toggle="tab">Convênio <small class="cont pull-right"></small></a>
					</li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="home">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-sm">
									<label for="txtNome" class="control-label">*Nome</label>
									<input type="text" class="form-control" id="txtNome" name="txtNome" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('nome')?>" placeholder="Nome" value="<?=set_value('txtNome', $dados->nome)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtDataNascimento" class="control-label">Data nascimento</label>
									<div class="input-group date datetimepicker-data">
										<input type="text" class="form-control inputmask-data" id="txtDataNascimento" name="txtDataNascimento" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('datanascimento')?>" placeholder="Data nascimento" value="<?=set_value('txtDataNascimento', $dados->datanascimento)?>">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtSexo" class="control-label">*Sexo</label>
									<select class="selectpicker form-control" id="txtSexo" name="txtSexo" data-field-db="<?=sha1('sexo')?>" data-live-search="false" data-style="btn-sm btn-default">
										<option value=""></option>
										<option value="M">Masculino</option>
										<option value="F">Feminino</option>
									</select>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group form-group-sm">
									<label for="txtEmail" class="control-label">E-mail</label>
									<input type="text" class="form-control" id="txtEmail" name="txtEmail" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('email')?>" placeholder="E-mail" value="<?=set_value('txtEmail', $dados->email)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtCpf" class="control-label">Cpf</label>
									<input type="text" class="form-control inputmask-cpf" id="txtCpf" name="txtCpf" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('cpf')?>" placeholder="Cpf" value="<?=set_value('txtCpf', $dados->cpf)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtRg" class="control-label">Rg</label>
									<input type="text" class="form-control" id="txtRg" name="txtRg" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('rg')?>" placeholder="Rg" value="<?=set_value('txtRg', $dados->rg)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtCelular" class="control-label">Celular</label>
									<input type="text" class="form-control inputmask-celular" id="txtCelular" name="txtCelular" placeholder="Celular" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('celular')?>" value="<?=set_value('txtCelular', $dados->nome)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtTelefone" class="control-label">Telefone (casa)</label>
									<input type="text" class="form-control inputmask-telefone" id="txtTelefone" name="txtTelefone" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('telefone')?>" placeholder="Telefone" value="<?=set_value('txtTelefone', $dados->telefone)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtTelefoneTrabalho" class="control-label">Telefone (trabalho)</label>
									<input type="text" class="form-control inputmask-telefone" id="txtTelefoneTrabalho" name="txtTelefoneTrabalho" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('telefonetrabalho')?>" placeholder="Telefone (Trabalho)" value="<?=set_value('txtTelefoneTrabalho', $dados->telefonetrabalho)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<div class="checkbox padding-top-20"><label><input type="checkbox" id="txtSms" name="txtSms" data-field-db="<?=sha1('sms')?>"> <strong>Receber SMS</strong></label></div>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtCep" class="control-label">CEP</label>
									<input type="text" class="form-control inputmask-cep" id="txtCep" name="txtCep" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('cep')?>" placeholder="CEP" value="<?=set_value('txtCep', $dados->cep)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group form-group-sm">
									<label for="txtEndereco" class="control-label">Endereço</label>
									<input type="text" class="form-control" id="txtEndereco" name="txtEndereco" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('endereco')?>" placeholder="Endereço" value="<?=set_value('txtEndereco', $dados->endereco)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtNumero" class="control-label">Número</label>
									<input type="text" class="form-control" id="txtNumero" name="txtNumero" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('numero')?>" placeholder="Número" value="<?=set_value('txtNumero', $dados->numero)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtComplemento" class="control-label">Complemento</label>
									<input type="text" class="form-control" id="txtComplemento" name="txtComplemento" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('complemento')?>" placeholder="Complemento" value="<?=set_value('txtComplemento', $dados->complemento)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtBairro" class="control-label">Bairro</label>
									<input type="text" class="form-control" id="txtBairro" name="txtBairro" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('bairro')?>" placeholder="Bairro" value="<?=set_value('txtBairro', $dados->bairro)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtCidade" class="control-label">Cidade</label>
									<input type="text" class="form-control" id="txtCidade" name="txtCidade" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('cidade')?>" placeholder="Cidade" value="<?=set_value('txtCidade', $dados->cidade)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtUf" class="control-label">UF</label>
									<select class="select2 form-control" id="txtUf" name="txtUf" data-field-db="<?=sha1('uf')?>">
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
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="dadoscomplementares">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtNaturalidade" class="control-label">Naturalidade</label>
								    <input type="text" class="form-control" id="txtNaturalidade" name="txtNaturalidade" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('naturalidade')?>" placeholder="Naturalidade" value="<?=set_value('txtNaturalidade', $dados->naturalidade)?>">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
									<label for="txtUfNaturalidade" class="control-label">UF Naturalidade</label>
									<select class="selectpicker form-control" id="txtUfNaturalidade" name="txtUfNaturalidade" data-field-db="<?=sha1('ufnaturalidade')?>" data-live-search="true" data-style="btn-default btn-sm">
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
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtEstadoCivil" class="control-label">Estado Civil</label>
								    <input type="text" class="form-control" id="txtEstadoCivil" name="txtEstadoCivil" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('estadocivil')?>" placeholder="Estado Civil" value="<?=set_value('txtEstadoCivil', $dados->estadocivil)?>">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtReligiao" class="control-label">Religião</label>
								    <input type="text" class="form-control" id="txtReligiao" name="txtReligiao" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('religiao')?>" placeholder="Religião" value="<?=set_value('txtReligiao', $dados->religiao)?>">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtProfissao" class="control-label">Profissão</label>
								    <input type="text" class="form-control" id="txtProfissao" name="txtProfissao" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('profissao')?>" placeholder="Profissão" value="<?=set_value('txtProfissao', $dados->profissao)?>">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtEscolaridade" class="control-label">Escolaridade</label>
								    <input type="text" class="form-control" id="txtEscolaridade" name="txtEscolaridade" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('escolaridade')?>" placeholder="Escolaridade" value="<?=set_value('txtEscolaridade', $dados->escolaridade)?>">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtCns" class="control-label">CNS</label>
								    <input type="text" class="form-control" id="txtCns" name="txtCns" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('cns')?>" placeholder="CNS" value="<?=set_value('cns', $dados->cns)?>">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
								    <label for="txtObs" class="control-label">Observações</label>
								    <textarea class="form-control" rows="5" id="txtObs" name="txtObs" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('obs')?>" placeholder="Observações"><?=set_value('txtObs', $dados->obs)?></textarea>
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="convenio">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtConvenio" class="control-label">Convenio</label>
								    <input type="text" class="form-control" id="txtConvenio" name="txtConvenio" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('convenio')?>" placeholder="Convenio" value="<?=set_value('txtConvenio', $dados->convenio)?>">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtPlanoConvenio" class="control-label">Plano Convênio</label>
								    <input type="text" class="form-control" id="txtPlanoConvenio" name="txtPlanoConvenio" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('planoconvenio')?>" placeholder="Plano Convênio" value="<?=set_value('txtPlanoConvenio', $dados->planoconvenio)?>">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
									<label for="txtCarteiraConvenio" class="control-label">Carteira Convênio</label>
									<input type="text" class="form-control" id="txtCarteiraConvenio" name="txtCarteiraConvenio" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('carteiraconvenio')?>" placeholder="Carteira Convênio" value="<?=set_value('txtCarteiraConvenio', $dados->carteiraconvenio)?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtValidadeConvenio" class="control-label">Validade Convênio</label>
									<div class='input-group date datetimepicker-data'>
										<input type="text" class="form-control inputmask-data" id="txtValidadeConvenio" name="txtValidadeConvenio" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('validadeconvenio')?>" placeholder="Validade Convênio" value="<?=set_value('txtValidadeConvenio', $dados->validadeconvenio)?>">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtAcomodacaoConvenio" class="control-label">Acomodação Convênio</label>
								    <input type="text" class="form-control" id="txtAcomodacaoConvenio" name="txtAcomodacaoConvenio" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('acomodacaoconvenio')?>" placeholder="Acomodação Convênio" value="<?=set_value('txtAcomodacaoConvenio', $dados->acomodacaoconvenio)?>">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="pull-right">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times-circle"></i> Fechar</button>
				<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>&nbsp;Salvar</button>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function clear_inputs_modal()
		{
			$('#formModelosPrescricoes').find(':text, :password, :file, textarea').val('');
			$('#formModelosPrescricoes').find(':radio, :checkbox').attr("checked",false);
			$('#formModelosPrescricoes').find('select').val('');
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
		$(function()
		{
			$('#formModelosPrescricoes').on('submit', function(event)
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
						if( $(el).prop('checked') == false )
						{
							value = ($(el).data('value')) ? $(el).data('value') : 'off';
							$(el).prop('value', value);
							$(el).prop('checked', false);
							$data.append( $(el).prop('name'), '' );
						}
						else
						{
							value = ($(el).data('value')) ? $(el).data('value') : 'on';
							$(el).prop('value', value);
							$(el).prop('checked', true);
							$data.append( $(el).prop('name'), $(el).prop('value') );
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
							return $(e).prop('name')+'=';
						}
						else
						{
							value = ($(e).data('value')) ? $(e).data('value') : 'on';
							$(e).prop('value', value);
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