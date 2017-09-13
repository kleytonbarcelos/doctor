<div class="msg"></div>
<div id="toolbar">
	<button class="btn btn-sm btn-primary" onclick="window.location.href=base_url_controller+'cadastrar';"><i class="fa fa-plus"></i> Cadastrar</button>
	<button class="btn btn-sm btn-danger btnExcluir" disabled><i class="fa fa-trash"></i> Excluir</button>
</div>
<table
	id="tableGrupos"
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
	var $table = $('#tableGrupos');
	var	$remove = $('.btnExcluir');
	function queryParams(params)
	{
		params.like_search = 'nome'; // 'all' ou 'nome|cpf|celular'
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
		return ''+
			'<a title="Ver Grupo" data-toggle="tooltip" class="btn btn-default btn-xs" href="'+base_url_controller+'visualizar/'+$.md5(row.id)+'"><i class="fa fa-vcard"></i></a>'+
			'&nbsp;'+
			'<a title="Editar Grupo" data-toggle="tooltip" class="btn btn-default btn-xs" href="'+base_url_controller+'editar/'+$.md5(row.id)+'"><i class="fa fa-pencil"></i></a>'+
		'';
	}
	function formatter_date_to_br(value, row)
	{
		return moment(row.data).format('DD/MM/Y');
	}
	function formatter_datetime_to_br(value, row)
	{
		return moment(row.data).format('DD/MM/Y H:mm:ss');
	}
	function formatter_time_to_br(value, row)
	{
		return moment(row.data).format('H:mm:ss');
	}
	function formatter_status(value, row)
	{
		switch(row.status)
		{
			case 'concluido':
				return '<span class="label label-success">Concluído</span>';
				break;
			case 'pendente':
				return '<span class="label label-warning">Pendente</span>';
				break;
			default:
				return '<span class="label label-default">Encerrado</span>';
		}
	}
	//################################################ BOOTSTRAP-TABLE (Fim) ###############################################
	//######################################################################################################################
	//######################################################################################################################
</script>