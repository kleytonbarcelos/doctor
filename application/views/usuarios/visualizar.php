<div class="row">
	<div class="col-md-12 dadosvisualizacao">
		<h4><i class="fa fa-bars" style="color: "></i> <strong>Usuário</strong></h4>
		<table class="table table-striped">
			<tbody>
				<tr>
					<td width="150"><strong>Nome</strong></td>
					<td><?=$dados->nome?></td>
				</tr>
				<tr>
					<td><strong>Usuário</strong></td>
					<td><?=$dados->usuario?></td>
				</tr>
				<tr>
					<td><strong>E-mail</strong></td>
					<td><?=$dados->email?></td>
				</tr>
				<!-- <tr>
					<td><strong>Endereço</strong></td>
					<td><?=$dados->tipoendereco.' '.$dados->endereco.', '.$dados->numero.' '.$dados->complemento.', '.$dados->bairro?></td>
				</tr> -->
			</tbody>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="btn-group">
			<a href="<?=$this->base_url_controller.'editar/'.$dados->id?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span>  Editar</a>
			<a href="javascript:void(0);" onclick="$.print('.main');" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
		</div>
	</div>
</div>