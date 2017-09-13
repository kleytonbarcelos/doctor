<?php
	$titulo_formulario = ( $this->router->fetch_method() == 'cadastrar' ) ? '<strong><i class="fa fa-plus-square"></i>&nbsp;Cadastro - Modelos de Prescrições</strong>' : '<strong><i class="glyphicon glyphicon-edit"></i>&nbsp;Editar - Modelos de Prescrições</strong>';
?>
<?=form_open_multipart('modelosprescricoes/salvar', array('id'=>'formModelosPrescricoes', 'role'=>'form'))?>
	<input type="hidden" id="id" name="id" data-field-db="id" value="<?=$dados->id?>">
	<h4><?=$titulo_formulario?></h4>
	<hr>
	<style type="text/css">
.teste-wrapper {
  max-width:300px;
  margin:94px auto 0 auto;
  text-align:center;
}

input#toggle {
max-height: 0;
max-width: 0;
opacity: 0;
}
input#toggle + label {
display: inline-block;
position: relative;
box-shadow: inset 0 0 0px 1px #d5d5d5;
text-indent: -5000px;
height: 30px;
width: 50px;
border-radius: 15px;
}

input#toggle + label:before {
content: "";
position: absolute;
display: block;
height: 30px;
width: 30px;
top: 0;
left: 0;
border-radius: 15px;
background: rgba(19,191,17,0);
-moz-transition: .25s ease-in-out;
-webkit-transition: .25s ease-in-out;
transition: .25s ease-in-out;
}

input#toggle + label:after {
content: "";
position: absolute;
display: block;
height: 30px;
width: 30px;
top: 0;
left: 0px;
border-radius: 15px;
background: white;
box-shadow: inset 0 0 0 1px rgba(0,0,0,.2), 0 2px 4px rgba(0,0,0,.2);
-moz-transition: .25s ease-in-out;
-webkit-transition: .25s ease-in-out;
transition: .25s ease-in-out;
}
input#toggle:checked + label:before {
width: 50px;
background: rgba(19,191,17,1);
}

input#toggle:checked + label:after {
left: 20px;
box-shadow: inset 0 0 0 1px rgba(19,191,17,1), 0 2px 4px rgba(0,0,0,.2);
}
	</style>
<div class="teste-wrapper">
  <input type="checkbox" name="toggle" id="toggle">
  <label for="toggle"></label>
</div>
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		Nesta seção você pode cadastrar aquelas prescrições que mais utiliza, para economizar tempo durante a consulta com o paciente. 
		Uma vez salvas, elas aparecerão no prontuário do paciente, necessitando apenas um clique para prescrevê-las.
	</div>
	<div class="msg"></div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group form-group-sm">
				<div class="checkbox"><label><input type="checkbox" id="txtSugestaoDeMedicamentos" name="txtSugestaoDeMedicamentos" data-field-db="<?=sha1('configuracoes.sugestaodemedicamentos')?>"> Habilitar sugestão de medicamentos</label></div>
				<small class="msg-erro text-danger"></small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group form-group-sm">
				<label for="txtNome" class="control-label">Nome do modelo <small>(ex.: Prescrição para dor de cabeça)</small></label>
				<input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="Nome" value="<?=set_value('txtNome', $dados->nome)?>">
				<small class="msg-erro text-danger"></small>
			</div>
		</div>
	</div>
	<div class="registros-prescricao"></div>
	<button type="button" class="btn btn-success btn-sm btn-add-campos-prescricao"><i class="fa fa-plus-circle fa-fw"></i> ADICIONAR CAMPO</button>
	<script type="text/javascript">
		var template_registros = ''+
							'<div class="row">'+
								'<div class="col-md-7">'+
									'<div class="form-group form-group-sm">'+
										'<label for="txtMedicamento" class="control-label">Medicamento</label>'+
										'<input type="text" class="form-control" name="txtMedicamento[]" placeholder="Medicamento">'+
										'<small class="msg-erro text-danger"></small>'+
									'</div>'+
								'</div>'+
								'<div class="col-md-2">'+
									'<div class="form-group form-group-sm">'+
									    '<label for="txtQuantidade" class="control-label">Quantidade</label>'+
										'<select class="form-control" name="txtQuantidade[]">'+
											'<option value="nenhum">Nenhum</option>'+
											'<option value="usocontinuo">Uso Contínuo</option>'+
											'<option value="1">1</option>'+
											'<option value="2">2</option>'+
											'<option value="3">3</option>'+
											'<option value="4">4</option>'+
											'<option value="5">5</option>'+
											'<option value="6">6</option>'+
											'<option value="7">7</option>'+
											'<option value="8">8</option>'+
											'<option value="9">9</option>'+
											'<option value="10">10</option>'+
										'</select>'+
									    '<small class="msg-erro text-danger"></small>'+
									'</div>'+
								'</div>'+
								'<div class="col-md-2">'+
									'<div class="form-group form-group-sm">'+
										'<label for="txtPosologia" class="control-label">Posologia</label>'+
										'<input type="text" class="form-control" name="txtPosologia[]" placeholder="Posologia">'+
										'<small class="msg-erro text-danger"></small>'+
									'</div>'+
								'</div>'+
								'<div class="col-md-1">'+
									'<a href="javascript:void(0);" class="margin-top-20 btn btn-danger btn-sm btn-remove-campos-prescricao" style="margin-top: 25px;"><i class="fa fa-trash-o"></i></a>'+
								'</div>'+
							'</div>';

		$(function()
		{
			$.ajax(
			{
				url: base_url_controller+'modelosprescricoesregistros',
				type: 'POST',
				data: 'id='+$('#id').val(),
				dataType: 'json',
				success: function(data)
				{
					modelosprescricoesregistros = data.modelosprescricoesregistros
					$.each(data.modelosprescricoesregistros, function(index, val)
					{
						$('.registros-prescricao').append( template_registros );
						$('.registros-prescricao').find('.row:last').find('[name="txtMedicamento[]"]').val(val.medicamento);
						$('.registros-prescricao').find('.row:last').find('[name="txtQuantidade[]"]').val(val.quantidade);
						$('.registros-prescricao').find('.row:last').find('[name="txtPosologia[]"]').val(val.posologia);
					});
				}
			});

			$('body').on('click', '.btn-remove-campos-prescricao', function(event)
			{
				event.preventDefault();
				$(this).parents('.row').remove();
			});
			$('body').on('click', '.btn-add-campos-prescricao', function(event)
			{
				event.preventDefault();
				$('.registros-prescricao').append( template_registros );
				$('.registros-prescricao').find('.row:last').find('input').val('');
			});
			$('.btn-salvarprescricao').on('click', function(event)
			{
				event.preventDefault();

				$('.msg-prescricoes').html('');
				$('.has-error').removeClass('has-error');

				$.ajax(
				{
					url: base_url_controller+'salvarprescricoes',
					type: 'POST',
					data: $('#formModelosPrescricoes').serialize(),
					dataType: 'json',
					success: function(data)
					{
						if( data.status == 1 )
						{
							alertify.success('<i class="fa fa-check-square-o"></i> '+data.msg);
							get_prescricoes();
						}
						else
						{
							var msg = '';
							$.each(data.erros, function(campo, valor)
							{
								var Input = $('[name='+campo+']');
								Input.parents('.form-group').eq(0).addClass('has-error');
								msg += '<div><small>'+valor+'</small></div>';
							});
							$('.msg-prescricoes')
							.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>')
							.show();
						}
					}
				});
			});
		});
	</script>
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