<table
	data-click-to-select="true"

	id="tableBulas"
	data-toggle="table"
	data-classes="table table-striped table-hover bootstrap-table"

	data-url="<?=$this->base_url_controller?>bootstrap_table"
	
	data-show-export="false"
	data-show-refresh="false"
	data-show-toggle="false"
	data-show-columns="false"

	data-detail-view="false"

	data-sort-name="medicamento"

	data-icons-prefix="fa"
	data-icons="icons"
	data-icon-size="sm"

	data-pagination="true"
	data-side-pagination="server"
	data-page-list="[5, 10, 20, 50, 100, 200]"
	data-search="true"
	data-query-params="queryParams"
	>
	<thead>
		<tr>
			<th data-field="medicamento" data-sortable="true">Medicamento</th>
			<th data-field="empresa" data-sortable="true">Empresa</th>
			<th data-field="expediente" data-sortable="true" data-align="center">Expediente</th>
			<th data-field="data_publicacao" data-sortable="true" data-formatter="publicacao" data-align="center">Publicação</th>
			<th data-field="bula_paciente" data-formatter="bula_pacienete" data-align="center">Bula paciente</th>
			<th data-field="bula_profissional" data-formatter="monta_bula_profissional" data-align="center">Bula profissional</th>
		</tr>
	</thead>
</table>
<script type="text/javascript">
	function queryParams(params)
	{
		params.like_search = 'medicamento'; // 'all' ou 'nome|cpf|celular'
		return params;
	}
	function publicacao(value, row)
	{
		return '<span class="label label-success">'+row.data_publicacao+'</span>'
	}
	function bula_pacienete(value, row)
	{
		//var icon = row.id % 2 === 0 ? 'glyphicon-star' : 'glyphicon-star-empty'
		//return '<i class="glyphicon ' + icon + '"></i> ' + value;
		return '<div class="text-center"><a target="_black" href="http://www.anvisa.gov.br/datavisa/fila_bula/frmVisualizarBula.asp?pNuTransacao='+row.bula_paciente_transacao+'&pIdAnexo='+row.bula_paciente_anexo+'"><img width="24" height="24" src="<?=base_url('assets/img/iconepdf.png')?>"></a></div>';
	}
	function monta_bula_profissional(value, row)
	{
		return '<div class="text-center"><a target="_black" href="http://www.anvisa.gov.br/datavisa/fila_bula/frmVisualizarBula.asp?pNuTransacao='+row.bula_profissional_transacao+'&pIdAnexo='+row.bula_profissional_anexo+'"><img width="24" height="24" src="<?=base_url('assets/img/iconepdf.png')?>"></a></div>';
	}
</script>