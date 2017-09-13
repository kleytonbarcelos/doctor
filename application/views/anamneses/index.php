<div class="msg"></div>
<div id="toolbar">
	<button class="btn btn-sm btn-primary" onclick="window.location.href=base_url_controller+'cadastrar';"><i class="fa fa-plus"></i> Cadastrar</button>
	<button class="btn btn-sm btn-danger btnExcluir" disabled><i class="fa fa-trash"></i> Excluir</button>
</div>
<table
	id="tableAnamneses"
	data-toggle="table"
	data-toolbar="#toolbar"
	data-click-to-select="true"
	data-classes="table table-striped table-hover bootstrap-table"

	data-url="<?=$this->base_url_controller?>bootstrap_table"
	
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
			<th data-checkbox="true"></th>
			<th data-field="nome" data-sortable="true">Nome</th>
			<th data-field="acoes" data-align="center" data-formatter="formatter_actions" class="col-xs-3 col-md-2"><i class="fa fa-cogs"></i></th>
		</tr>
	</thead>
</table>
<script type="text/javascript">
	//############################################## BOOTSTRAP-TABLE (Início) ###############################################
	//#######################################################################################################################
	var $table = $('#tableAnamneses');
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
	function formatter_actions(value, row, index)
	{
		return [
			'<a title="Ver Evento" class="btn btn-default btn-sm" target="_blank" href="'+base_url+row.url+'"><i class="fa fa-eye"></i></a>',
			'&nbsp;',
			'<a title="Editar Registro" class="btn btn-success btn-sm" target="_blank" href="'+base_url_controller+'editar/'+row.id+'"><i class="fa fa-pencil"></i></a>',
			].join('');
	}
	function formatter_date_to_br(value, row)
	{
		var data = new Date(row.data);
		var dia = ('00'+ (data.getUTCDate())).slice(-2);
		var mes = ('00'+(data.getUTCMonth()+1)).slice(-2);
		var ano = data.getUTCFullYear();
		return [dia, mes, ano].join('/');
	}
	function formatter_status(value, row)
	{
		switch(row.status)
		{
			case 'A':
				return '<span class="label label-primary">Aberto</span>';
				break;
			case 'P':
				return '<span class="label label-warning">Pendente</span>';
				break;
			default:
				return '<span class="label label-default">Encerrado</span>';
		}
	}
	//################################################ BOOTSTRAP-TABLE (Fim) ###############################################
	//######################################################################################################################
	//######################################################################################################################
	//######################################################################################################################
	//######################################################################################################################
	//######################################################################################################################
	function clear_inputs_modal()
	{
		$('#formAnamneses').find(':text, :password, :file, textarea').val('');
		$('#formAnamneses').find(':radio, :checkbox').attr("checked",false);
		$('#formAnamneses').find('select').val('');
		clear_form_erros();
	}
	function clear_form_erros()
	{
		$('.msg-erro').html('');
		$('.has-error').removeClass('has-error');
		$('.modal-msg').html('');
		
		if( $('.nav-tabs').size() > 0 )
		{
			$('.nav-tabs').find('.cont').html(''); // Limpa contadores de erros (NAVTABS)
			$('.nav-tabs a:first').tab('show');
		}
	}
	function cadastrar()
	{
		$('#modalCadastraAnamneses .modal-title').html('<strong><i class="fa fa-plus-square"></i>&nbsp;Cadastro de Evento</strong>');
		$('#modalCadastraAnamneses').modal('show');
		clear_form_erros();
	}
	function editar(id) //Preenche os campos do formulário apartir do DB
	{
		reset_click_to_select(); // Bootstrap-table
		clear_form_erros();
		$('input[name="id"]').val(id);
		$('#modalCadastraAnamneses .modal-title').html('<strong><i class="glyphicon glyphicon-edit"></i>&nbsp;Editar Evento</strong>');
		$.ajax(
		{
			url: base_url_controller+'getvaluesinputs',
			type: 'POST',
			data: 'id='+id,
			dataType: 'json',
			success: function(data)
			{
				$('#modalCadastraAnamneses').modal('show');

				$.each(data.inputs, function(campo, valor)
				{
					$element = $('[data-field-db='+campo+']');

					if( $element.prop('type') == 'text' )
					{
						console.log(moment.isDate(valor));
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
					}
					else if( $element.prop('type') == 'select-one' )
					{
						$element.selectpicker('val',valor);
					}
					else
					{
						$element.val(valor);
					}
				});
			}
		});
	}
	$(function()
	{
		$('#modalCadastraAnamneses').on('hide.bs.modal', function(e)
		{
			clear_inputs_modal();
		});
		$('#formAnamneses').on('submit', function(event)
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
					$('#tableAnamneses').bootstrapTable('refresh', {url: base_url_controller+'bootstrap_table'});
					$('#modalCadastraAnamneses').modal('hide');
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