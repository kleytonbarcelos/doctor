<div class="msg"></div>
<script type="text/javascript">
	$('.titulo').html('<i class="fa fa-user"></i> Pacientes');
</script>
<div id="toolbar">
	<button class="btn btn-sm btn-primary" onclick="cadastrar()"><i class="fa fa-plus"></i> Cadastrar</button>
	<button class="btn btn-sm btn-danger btnExcluir" disabled><i class="fa fa-trash"></i> Excluir</button>
</div>
<table
	id="tablePacientes"
	data-toggle="table"
	data-toolbar="#toolbar"
	data-click-to-select="true"
	data-classes="table table-striped table-hover bootstrap-table"

	data-url="<?=$this->base_url_controller?>bootstrap_table"
	
	data-show-export="true"
	data-show-refresh="true"
	data-show-toggle="true"
	data-show-columns="true"

	data-icons-prefix="fa"
	data-icons="icons"
	data-icon-size="sm"

	data-pagination="true"
	data-side-pagination="server"
	data-page-list="[5, 10, 20, 50, 100, 200]"
	data-search="true"
	data-query-params="queryParams"

	data-sort-name="nome"
	>
	<thead>
		<tr>
			<th data-field="state" data-checkbox="true"></th>
			<th data-field="nome" data-sortable="true" data-formatter="LinkEditar">Nome</th>
			<th data-field="celular" data-sortable="true">Celular</th>
			<th data-field="rg" data-sortable="true">Rg</th>
			<th data-field="cpf" data-sortable="true">Cpf</th>
			<th data-field="datanascimento" data-sortable="true">Data (nascimento)</th>
			<!-- <th data-field="acoes" data-align="center" data-formatter="LinkAcoes" class="col-md-1">Editar</th> -->
		</tr>
	</thead>
</table>
<script type="text/javascript">
	//############################################## BOOTSTRAP-TABLE (Início) ###############################################
	//#######################################################################################################################
	var $table = $('#tablePacientes');
	var	$remove = $('.btnExcluir');
	function queryParams(params)
	{
		params.like_search = 'all'; // 'all' ou 'nome|cpf|celular'
		return params;
	}
	$(function()
	{
		$table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function()
		{
			$remove.prop('disabled', !$table.bootstrapTable('getSelections').length);
		});
		$remove.click(function()
		{
			var ids = $.map($table.bootstrapTable('getSelections'), function (row)
			{
				return row.id;
			});
			alertify.confirm('<strong><i class="fa fa-exclamation-circle"></i>&nbsp;Confirmação</strong>', '<strong>Você realmente deseja excluir este(s) registro(s) ?</strong>', function()
			{
				//console.log(ids);
				$.ajax(
				{
					url: base_url_controller+'excluir',
					type: 'POST',
					data: 'id='+ids,
					dataType: 'json',
					success: function(data)
					{
						if( data.status == 1 )
						{
							//alert_success('.msg', data.msg);
							alertify.success('<i class="fa fa-check-circle-o"></i> '+data.msg);

							$table.bootstrapTable('remove',
							{
								field: 'id',
								values: ids
							});
							$remove.prop('disabled', true);
							$table.bootstrapTable('refresh');
						}
						else
						{
							//alert_danger('.msg', data.msg);
							alertify.error('<i class="fa fa-remove"></i> '+data.msg);
						}
					}
				});
			}, function()
			{

			});
		});
	});
	function reset_click_to_select()
	{
		setTimeout(function()
		{
			$table.bootstrapTable('uncheckAll').find('.selected').removeClass('selected'); // Limpando a linha selecionada
		}, 1);
	}
	function LinkEditar(value, row, index)
	{
		return '<span>'+row.nome+'</span><button class="pull-right btn btn-success btn-xs" onclick="javascript:editar('+row.id+')"><i class="fa fa-pencil"></i></button>';
	}
	function LinkAcoes(value, row, index)
	{
		return '<span class="label label-success" onclick="javascript:editar('+row.id+')"><i class="fa fa-pencil"> Editar</i></span>'
		// return [
		// '<button class="btn btn-xs btn-default" onclick="javascript:editar('+row.id+')"><i class="fa fa-pencil"> Editar</i></button>',
		// ].join('');
	}
	//################################################ BOOTSTRAP-TABLE (Fim) ###############################################
	//######################################################################################################################
	function clear_inputs_modal()
	{
		$('#formPacientes input').val('');
		$('#formPacientes textarea').val('');
		clear_form_erros();
	}
	function clear_form_erros()
	{
		$('.msg-erro').html('');
		$('.has-error').removeClass('has-error');
		$('.modal-msg').html('');
		$('.nav-tabs').find('.cont').html(''); // Limpa contadores de erros (NAVTABS)
		$('.nav-tabs a:first').tab('show');
	}
	function cadastrar()
	{
		$('#modalCadastraPacientes .modal-title').html('<strong><i class="fa fa-plus-square"></i>&nbsp;Cadastro de Paciente</strong>');
		$('#modalCadastraPacientes').modal('show');
		clear_form_erros();
	}
	function editar(id) //Preenche os campos do formulário apartir do DB
	{
		reset_click_to_select();
		clear_form_erros();
		$('input[name="id"]').val(id);
		$('#modalCadastraPacientes .modal-title').html('<strong><i class="glyphicon glyphicon-edit"></i>&nbsp;Editar Paciente</strong>');
		$.ajax(
		{
			url: base_url_controller+'getvaluesinputs',
			type: 'POST',
			data: 'id='+id,
			dataType: 'json',
			success: function(data)
			{
				$('#modalCadastraPacientes').modal('show');

				$.each(data.inputs, function(campo, valor)
				{
					$element = $('[data-field-db='+campo+']');

					if( $element.prop('type') == 'text' )
					{
						console.log(moment.isDate(valor));
						//console.log('INPUT: '+$element.prop('name')+'     VALOR>>> '+valor);
						$element.val(valor);
					}
					else if( $element.prop('type') == 'checkbox' )
					{
						if(valor=='on')
						{						
							$element.prop('checked', true);
							$element.prop('value', 'on');
						}
						else
						{
							$element.prop('checked', false);
							$element.prop('value', 'off');
						}
						//console.log('CHECKBOX: '+$element.prop('name')+'     VALOR>>> '+valor);
					}
					else if( $element.prop('type') == 'select-one' )
					{
						//console.log('SELECT: '+$element.prop('name')+'     VALOR>>> '+valor);
						$element.selectpicker('val',valor);
					}
					else
					{
						//console.log('OUTRO: '+$element.prop('name')+'     VALOR>>> '+valor);
						$element.val(valor);
					}
				});
			}
		});
	}
	$(function()
	{
		$('#modalCadastraPacientes').on('hide.bs.modal', function(e)
		{
			clear_inputs_modal();
		});
		$('#formPacientes').on('submit', function(event)
		{
			event.preventDefault();
			var $form = $(this);
			var $button_submit = $form.find('button:submit');
			$button_submit.data('loading-text', '<i class="fa fa-circle-o-notch fa-spin"></i> Carregando...');
			$button_submit.button('loading');
			clear_form_erros();

			//#######################################################################################
			// FIX para correção de erros de enviar input:checbox VAZIOS juntos com os outros campos via ajax.
			var campos = $form.serialize()+'&'+$form.find('input:checkbox').map(function(i, e)
			{
				if( $(e).prop('checked') == false )
				{
					$(e).prop('value', 'off');
					$(e).prop('checked', false);
					return $(e).prop('name')+'=';
				}
				else
				{
					$(e).prop('value', 'on');
					$(e).prop('checked', true);
				}
			}).get().join('&');
			//#######################################################################################
			$.ajax(
			{
				url: $form.attr('action'),
				type: $form.attr('method'),
				data: campos,
				dataType: 'json',
			})
			.done(function(data) //success
			{
				//console.log("success");
				$button_submit.button('reset');

				if(data.status == 1)
				{
					//alert_success('.msg', data.msg);
					alertify.success('<i class="fa fa-check-circle-o"></i> '+data.msg);
					$('#tablePacientes').bootstrapTable('refresh', {url: base_url_controller+'bootstrap_table'});
					$('#modalCadastraPacientes').modal('hide');
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
					});
					$('.modal-msg')
					.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>')
					.show();

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
<div class="modal fade" id="modalCadastraPacientes">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<?=form_open('pacientes/salvar', array('id'=>'formPacientes', 'role'=>'form'))?>
			<input type="hidden" name="id" value="" data-field-db="id">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h5 class="modal-title"><strong><i class="fa fa-plus-square"></i>&nbsp;Cadastro de Paciente</strong></h5>
			</div>
			<div class="modal-body">
				<div class="modal-msg"></div>
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
										<input type="text" class="form-control" id="txtNome" name="txtNome" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('nome')?>" placeholder="Nome" value="<?=set_value('txtNome')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtDataNascimento" class="control-label">Data nascimento</label>
										<div class="input-group date datetimepicker-data">
											<input type="text" class="form-control inputmask-data" id="txtDataNascimento" name="txtDataNascimento" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('datanascimento')?>" placeholder="Data nascimento" value="<?=set_value('txtDataNascimento')?>">
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
										<input type="text" class="form-control" id="txtEmail" name="txtEmail" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('email')?>" placeholder="E-mail" value="<?=set_value('txtEmail')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtCpf" class="control-label">Cpf</label>
										<input type="text" class="form-control inputmask-cpf" id="txtCpf" name="txtCpf" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('cpf')?>" placeholder="Cpf" value="<?=set_value('txtCpf')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtRg" class="control-label">Rg</label>
										<input type="text" class="form-control" id="txtRg" name="txtRg" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('rg')?>" placeholder="Rg" value="<?=set_value('txtRg')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtCelular" class="control-label">Celular</label>
										<input type="text" class="form-control inputmask-celular" id="txtCelular" name="txtCelular" placeholder="Celular" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('celular')?>" value="<?=set_value('txtCelular')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtTelefone" class="control-label">Telefone (casa)</label>
										<input type="text" class="form-control inputmask-telefone" id="txtTelefone" name="txtTelefone" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('telefone')?>" placeholder="Telefone" value="<?=set_value('txtTelefone')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtTelefoneTrabalho" class="control-label">Telefone (trabalho)</label>
										<input type="text" class="form-control inputmask-telefone" id="txtTelefoneTrabalho" name="txtTelefoneTrabalho" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('telefonetrabalho')?>" placeholder="Telefone (Trabalho)" value="<?=set_value('txtTelefoneTrabalho')?>">
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
										<input type="text" class="form-control inputmask-cep" id="txtCep" name="txtCep" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('cep')?>" placeholder="CEP" value="<?=set_value('txtCep')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group form-group-sm">
										<label for="txtEndereco" class="control-label">Endereço</label>
										<input type="text" class="form-control" id="txtEndereco" name="txtEndereco" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('endereco')?>" placeholder="Endereço" value="<?=set_value('txtEndereco')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group form-group-sm">
										<label for="txtNumero" class="control-label">Número</label>
										<input type="text" class="form-control" id="txtNumero" name="txtNumero" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('numero')?>" placeholder="Número" value="<?=set_value('txtNumero')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtComplemento" class="control-label">Complemento</label>
										<input type="text" class="form-control" id="txtComplemento" name="txtComplemento" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('complemento')?>" placeholder="Complemento" value="<?=set_value('txtComplemento')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtBairro" class="control-label">Bairro</label>
										<input type="text" class="form-control" id="txtBairro" name="txtBairro" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('bairro')?>" placeholder="Bairro" value="<?=set_value('txtBairro')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtCidade" class="control-label">Cidade</label>
										<input type="text" class="form-control" id="txtCidade" name="txtCidade" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('cidade')?>" placeholder="Cidade" value="<?=set_value('txtCidade')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtUf" class="control-label">UF</label>
										<select class="select2 form-control" id="txtUf" name="txtUf" data-field-db="<?=sha1('uf')?>" data-live-search="true" data-style="btn-default btn-sm">
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
									    <input type="text" class="form-control" id="txtNaturalidade" name="txtNaturalidade" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('naturalidade')?>" placeholder="Naturalidade" value="<?=set_value('txtNaturalidade')?>">
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
									    <input type="text" class="form-control" id="txtEstadoCivil" name="txtEstadoCivil" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('estadocivil')?>" placeholder="Estado Civil" value="<?=set_value('txtEstadoCivil')?>">
									    <small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group form-group-sm">
									    <label for="txtReligiao" class="control-label">Religião</label>
									    <input type="text" class="form-control" id="txtReligiao" name="txtReligiao" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('religiao')?>" placeholder="Religião" value="<?=set_value('txtReligiao')?>">
									    <small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
									    <label for="txtProfissao" class="control-label">Profissão</label>
									    <input type="text" class="form-control" id="txtProfissao" name="txtProfissao" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('profissao')?>" placeholder="Profissão" value="<?=set_value('txtProfissao')?>">
									    <small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
									    <label for="txtEscolaridade" class="control-label">Escolaridade</label>
									    <input type="text" class="form-control" id="txtEscolaridade" name="txtEscolaridade" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('escolaridade')?>" placeholder="Escolaridade" value="<?=set_value('txtEscolaridade')?>">
									    <small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group form-group-sm">
									    <label for="txtCns" class="control-label">CNS</label>
									    <input type="text" class="form-control" id="txtCns" name="txtCns" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('cns')?>" placeholder="CNS" value="<?=set_value('txtCns')?>">
									    <small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
									    <label for="txtObs" class="control-label">Observações</label>
									    <textarea class="form-control" rows="5" id="txtObs" name="txtObs" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('obs')?>" placeholder="Observações"><?=set_value('txtObs')?></textarea>
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
									    <input type="text" class="form-control" id="txtConvenio" name="txtConvenio" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('convenio')?>" placeholder="Convenio" value="<?=set_value('txtConvenio')?>">
									    <small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
									    <label for="txtPlanoConvenio" class="control-label">Plano Convênio</label>
									    <input type="text" class="form-control" id="txtPlanoConvenio" name="txtPlanoConvenio" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('planoconvenio')?>" placeholder="Plano Convênio" value="<?=set_value('txtPlanoConvenio')?>">
									    <small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<label for="txtCarteiraConvenio" class="control-label">Carteira Convênio</label>
										<input type="text" class="form-control" id="txtCarteiraConvenio" name="txtCarteiraConvenio" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('carteiraconvenio')?>" placeholder="Carteira Convênio" value="<?=set_value('txtCarteiraConvenio')?>">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group form-group-sm">
									    <label for="txtValidadeConvenio" class="control-label">Validade Convênio</label>
										<div class='input-group date datetimepicker-data'>
											<input type="text" class="form-control inputmask-data" id="txtValidadeConvenio" name="txtValidadeConvenio" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('validadeconvenio')?>" placeholder="Validade Convênio" value="<?=set_value('txtValidadeConvenio')?>">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									    <small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
									    <label for="txtAcomodacaoConvenio" class="control-label">Acomodação Convênio</label>
									    <input type="text" class="form-control" id="txtAcomodacaoConvenio" name="txtAcomodacaoConvenio" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('acomodacaoconvenio')?>" placeholder="Acomodação Convênio" value="<?=set_value('txtAcomodacaoConvenio')?>">
									    <small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
				<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>&nbsp;Salvar</button>
			</div>
			<?=form_close()?>
		</div>
	</div>
</div>