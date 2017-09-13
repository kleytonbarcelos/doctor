<div class="row">
	<div class="col-md-12 dadosvisualizacao">
		<h4><i class="fa fa-bars"></i> <strong>Modelos de Prescrições</strong></h4>
		<table class="table table-striped table-bordered">
			<tbody>
				<tr>
					<td width="150"><strong>Nome do modelo</strong></td>
					<td><?=$dados->nome?></td>
				</tr>
				<tr>
					<td width="150"><strong>Medicamento</strong></td>
					<td><?=$dados->medicamento?></td>
				</tr>
				<tr>
					<td><strong>Quantidade</strong></td>
					<td><?=$dados->quantidade?></td>
				</tr>
				<tr>
					<td><strong>Posologia</strong></td>
					<td><?=$dados->posologia?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group">
			<button onclick="window.location.href=base_url_controller+'editar/<?=$dados->id?>'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> Editar</button>
			<button onclick="$.print('.dadosvisualizacao')" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
		</div>
	</div>
</div>