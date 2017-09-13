<?php
	$titulo_formulario = ( $this->router->fetch_method() == 'cadastrar' ) ? '<strong><i class="fa fa-plus-square"></i>&nbsp;Cadastro de Usuário</strong>' : '<strong><i class="glyphicon glyphicon-edit"></i>&nbsp;Editar Usuário</strong>';
?>
<?=form_open_multipart('usuarios/salvar', array('id'=>'formUsuarios', 'role'=>'form'))?>
	<input type="hidden" id="id" name="id" data-field-db="id" value="<?=$dados->id?>">
	<h4><?=$titulo_formulario?></h4>
	<hr>
	<div class="msg"></div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group form-group-sm">
				<label for="txtNome" class="control-label">Nome</label>
				<input type="text" class="form-control" id="txtNome" name="txtNome" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('usuarios.nome')?>" placeholder="Nome" value="<?=set_value('txtNome', $dados->nome)?>">
				<small class="msg-erro text-danger"></small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group form-group-sm">
				<label for="txtEmail" class="control-label">E-mail</label>
				<input type="text" class="form-control" id="txtEmail" name="txtEmail" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('usuarios.email')?>" placeholder="E-mail" value="<?=set_value('txtEmail', $dados->email)?>">
				<small class="msg-erro text-danger"></small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group form-group-sm">
			    <label for="txtTipo" class="control-label">Tipo</label>
				<select class="form-control" id="txtTipo" name="txtTipo">
					<option value="medico"<?if($dados->tipo=='medico'){echo ' selected';}?>>Medico</option>
					<option value="secretario"<?if($dados->tipo=='secretario'){echo ' selected';}?>>Secretário</option>
				</select>
				<??>
			    <small class="msg-erro text-danger"></small>
			</div>
		</div>
	</div>
<!-- 	<div class="row">
		<div class="col-md-12">
			<div class="form-group form-group-sm">
			    <label for="txtAdministradorDoEspaco" class="control-label">Administrador do(s) Espaço(s)</label>
				<select class="selectpicker form-control" id="txtAdministradorDoEspaco" name="txtAdministradorDoEspaco[]" data-live-search="true" data-style="btn-default btn-sm" multiple>
					<script type="text/javascript">
						$(function()
						{
							$.ajax(
							{
								url: base_url+'espacos/espacos',
								type: 'POST',
								//data: 'txtCampo='+$('txtCampo').val(),
								dataType: 'json',
								success: function(data)
								{
									$.each(data.dados, function(index, val)
									{
										$('#txtAdministradorDoEspaco').append('<option value="'+val.id+'">'+val.nome+'</option>').selectpicker('refresh');
									});
								}
							});

							$('#txtAdministradorDoEspaco').selectpicker('val', ['Mustard','Relish']);
						});
					</script>
				</select>
			    <small class="msg-erro text-danger"></small>
			</div>
		</div>
	</div> -->
	<div class="row">
		<div class="col-md-12">
			<div class="pull-right">
				<button type="button" class="btn btn-default btn-sm" onclick="window.history.go(-1);"><i class="fa fa-times-circle"></i> Fechar</button>
				<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>&nbsp;Salvar</button>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function clear_inputs_modal()
		{
			$('#formUsuarios').find(':text, :password, :file, textarea').val('');
			$('#formUsuarios').find(':radio, :checkbox').attr("checked",false);
			$('#formUsuarios').find('select').val('');
			clear_erros_modal();
		}
		function clear_erros_modal()
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
			$('#formUsuarios').on('submit', function(event)
			{
				event.preventDefault();

				clear_erros_modal();

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