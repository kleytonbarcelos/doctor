<div class="row">
	<div class="col-md-12 dadosvisualizacao">
		<h4><i class="fa fa-tags"></i> <strong>Logs</strong></h4>
		<br><br>
		<table class="table table-striped">
			<tbody>
				<tr>
					<td width="150"><strong>Mensagem</strong></td>
					<td><?=$dados->mensagem?></td>
				</tr>
				<tr>
					<td width="150"><strong>Data</strong></td>
					<td><?=$dados->data?></td>
				</tr>
				<tr>
					<td width="150"><strong>Url</strong></td>
					<td><?=$dados->url?></td>
				</tr>
				<tr>
					<td width="150"><strong>Navegador</strong></td>
					<td><?=$dados->browser?></td>
				</tr>
				<tr>
					<td width="150"><strong>Ip</strong></td>
					<td><?=$dados->ip?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group">
			<button onclick="window.history.go(-1)" class="btn btn-sm"><i class="fa fa-reply"></i> Voltar</button>
			<!-- <button onclick="window.location.href=base_url_controller+'editar/'+$.md5(<?=$dados->id?>)" class="btn btn-sm"><span class="glyphicon glyphicon-edit"></span> Editar</button> -->
			<button onclick="$.print('.dadosvisualizacao');" class="btn btn-sm"><i class="glyphicon glyphicon-print"></i> Imprimir</button>
		</div>
	</div>
</div>