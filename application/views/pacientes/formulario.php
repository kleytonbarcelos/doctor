<?php
	$titulo_formulario = ( $this->router->fetch_method() == 'cadastrar' ) ? '<strong><i class="fa fa-plus-square"></i>&nbsp;Cadastro de Pacientes</strong>' : '<strong><i class="glyphicon glyphicon-edit"></i>&nbsp;Editar Pacientes</strong>';
?>
<script type="text/javascript">
	$(function()
	{
		$('#formPacientes').bind('callback', function(event, data)
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
				form_status = {'id':'formPacientes','erros': data.erros};
				formajaxerros('#'+$(this).attr('id'), data.erros);
			}
		});
	});
</script>
<?=form_open_multipart('pacientes/salvar', array('id'=>'formPacientes', 'class'=>'formajax', 'role'=>'form', 'data-callback'=>'true'))?>
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
									<input type="text" class="form-control" id="txtNome" name="txtNome" data-field-db="<?=sha1('pacientes.nome')?>" placeholder="Nome">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtDataNascimento" class="control-label">Data nascimento</label>
									<div class="input-group date datetimepicker-data">
										<input type="text" class="form-control inputmask-data" id="txtDataNascimento" name="txtDataNascimento" data-field-db="<?=sha1('pacientes.datanascimento')?>" placeholder="Data nascimento">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtSexo" class="control-label">*Sexo</label>
									<select class="select2" data-minimum-results-for-search="Infinity" id="txtSexo" name="txtSexo" data-field-db="<?=sha1('pacientes.sexo')?>">
										<option value="">&nbsp;</option>
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
									<input type="text" class="form-control" id="txtEmail" name="txtEmail" data-field-db="<?=sha1('pacientes.email')?>" placeholder="E-mail">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtCpf" class="control-label">Cpf</label>
									<input type="text" class="form-control inputmask-cpf" id="txtCpf" name="txtCpf" data-field-db="<?=sha1('pacientes.cpf')?>" placeholder="Cpf">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtRg" class="control-label">Rg</label>
									<input type="text" class="form-control" id="txtRg" name="txtRg" data-field-db="<?=sha1('pacientes.rg')?>" placeholder="Rg">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtCelular" class="control-label">Celular</label>
									<input type="text" class="form-control inputmask-celular" id="txtCelular" name="txtCelular" placeholder="Celular" data-field-db="<?=sha1('pacientes.celular')?>">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtTelefone" class="control-label">Telefone (casa)</label>
									<input type="text" class="form-control inputmask-telefone" id="txtTelefone" name="txtTelefone" data-field-db="<?=sha1('pacientes.telefone')?>" placeholder="Telefone">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtTelefoneTrabalho" class="control-label">Telefone (trabalho)</label>
									<input type="text" class="form-control inputmask-telefone" id="txtTelefoneTrabalho" name="txtTelefoneTrabalho" data-field-db="<?=sha1('pacientes.telefonetrabalho')?>" placeholder="Telefone (Trabalho)">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<div class="checkbox padding-top-20"><label><input type="checkbox" id="txtSms" name="txtSms" data-field-db="<?=sha1('pacientes.sms')?>"> <strong>Receber SMS</strong></label></div>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtCep" class="control-label">CEP</label>
									<input type="text" class="form-control inputmask-cep" id="txtCep" name="txtCep" data-field-db="<?=sha1('pacientes.cep')?>" placeholder="CEP">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group form-group-sm">
									<label for="txtEndereco" class="control-label">Endereço</label>
									<input type="text" class="form-control" id="txtEndereco" name="txtEndereco" data-field-db="<?=sha1('pacientes.endereco')?>" placeholder="Endereço">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtNumero" class="control-label">Número</label>
									<input type="text" class="form-control" id="txtNumero" name="txtNumero" data-field-db="<?=sha1('pacientes.numero')?>" placeholder="Número">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtComplemento" class="control-label">Complemento</label>
									<input type="text" class="form-control" id="txtComplemento" name="txtComplemento" data-field-db="<?=sha1('pacientes.complemento')?>" placeholder="Complemento">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtBairro" class="control-label">Bairro</label>
									<input type="text" class="form-control" id="txtBairro" name="txtBairro" data-field-db="<?=sha1('pacientes.bairro')?>" placeholder="Bairro">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtCidade" class="control-label">Cidade</label>
									<input type="text" class="form-control" id="txtCidade" name="txtCidade" data-field-db="<?=sha1('pacientes.cidade')?>" placeholder="Cidade">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtUf" class="control-label">UF</label>
									<select class="select2 form-control" id="txtUf" name="txtUf" data-field-db="<?=sha1('pacientes.uf')?>">
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
								    <input type="text" class="form-control" id="txtNaturalidade" name="txtNaturalidade" data-field-db="<?=sha1('pacientes.naturalidade')?>" placeholder="Naturalidade">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
									<label for="txtUfNaturalidade" class="control-label">UF Naturalidade</label>
									<select class="select2" id="txtUfNaturalidade" name="txtUfNaturalidade" data-field-db="<?=sha1('pacientes.ufnaturalidade')?>">
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
								    <input type="text" class="form-control" id="txtEstadoCivil" name="txtEstadoCivil" data-field-db="<?=sha1('pacientes.estadocivil')?>" placeholder="Estado Civil">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtReligiao" class="control-label">Religião</label>
								    <input type="text" class="form-control" id="txtReligiao" name="txtReligiao" data-field-db="<?=sha1('pacientes.religiao')?>" placeholder="Religião">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtProfissao" class="control-label">Profissão</label>
								    <input type="text" class="form-control" id="txtProfissao" name="txtProfissao" data-field-db="<?=sha1('pacientes.profissao')?>" placeholder="Profissão">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtEscolaridade" class="control-label">Escolaridade</label>
								    <input type="text" class="form-control" id="txtEscolaridade" name="txtEscolaridade" data-field-db="<?=sha1('pacientes.escolaridade')?>" placeholder="Escolaridade">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtCns" class="control-label">CNS</label>
								    <input type="text" class="form-control" id="txtCns" name="txtCns" data-field-db="<?=sha1('pacientes.cns')?>" placeholder="CNS">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
								    <label for="txtObs" class="control-label">Observações</label>
								    <textarea class="form-control" rows="5" id="txtObs" name="txtObs" data-field-db="<?=sha1('pacientes.obs')?>" placeholder="Observações"></textarea>
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
								    <input type="text" class="form-control" id="txtConvenio" name="txtConvenio" data-field-db="<?=sha1('pacientes.convenio')?>" placeholder="Convenio">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtPlanoConvenio" class="control-label">Plano Convênio</label>
								    <input type="text" class="form-control" id="txtPlanoConvenio" name="txtPlanoConvenio" data-field-db="<?=sha1('pacientes.planoconvenio')?>" placeholder="Plano Convênio">
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
									<label for="txtCarteiraConvenio" class="control-label">Carteira Convênio</label>
									<input type="text" class="form-control" id="txtCarteiraConvenio" name="txtCarteiraConvenio" data-field-db="<?=sha1('pacientes.carteiraconvenio')?>" placeholder="Carteira Convênio">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtValidadeConvenio" class="control-label">Validade Convênio</label>
									<div class='input-group date datetimepicker-data'>
										<input type="text" class="form-control inputmask-data" id="txtValidadeConvenio" name="txtValidadeConvenio" data-field-db="<?=sha1('pacientes.validadeconvenio')?>" placeholder="Validade Convênio">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-sm">
								    <label for="txtAcomodacaoConvenio" class="control-label">Acomodação Convênio</label>
								    <input type="text" class="form-control" id="txtAcomodacaoConvenio" name="txtAcomodacaoConvenio" data-field-db="<?=sha1('pacientes.acomodacaoconvenio')?>" placeholder="Acomodação Convênio">
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
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="pull-left">				
				<button type="button" class="btn" onclick="window.history.go(-1);"><i class="fa fa-reply-all"></i> Voltar</button>
			</div>
			<div class="pull-right">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Salvar</button>
			</div>
		</div>
	</div>
<?=form_close()?>
<script type="text/javascript">setTimeout(function(){ getvaluesinputs('pacientes', $('#id').val()); }, 500);</script>