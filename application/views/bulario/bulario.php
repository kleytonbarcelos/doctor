<?php
	// echo '<textarea class="form-control" rows="20">';
	// print_r($dados);
	// echo '</textarea>';
?>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title"><i class="fa fa-eyedropper"></i> Bulas</h3>
		<div class="box-tools">
			<?=form_open('bulas/lista', array('class'=>'form-ajax', 'role'=>'form'))?>
				<div class="input-group input-group-sm pull-right" style="margin-top:5px;margin-left:50px;width: 150px;">
					<input type="text" name="medicamento" id="medicamento" class="form-control pull-right" value="<?=$dados['variaveis']['medicamento']?>" placeholder="Pesquisa" >
					<div class="input-group-btn"><button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button></div>
				</div>
			<?=form_close()?>
		</div>
	</div>
	<div class="box-body with-border">
		<div class="lista_medicamentos"><?=$dados['html_medicamentos_bootstrap']?></div>
	</div>
	<div class="box-footer clearfix with-border">
		<div class="paginacao_medicamentos"><?=$dados['html_paginacao_bootstrap']?></div>
	</div>
</div>
<script type="text/javascript">
	var medicamento = '<?=$dados['variaveis']['medicamento']?>';
	var letra = '<?=$dados['variaveis']['letra']?>';
	var empresa = '<?=$dados['variaveis']['empresa']?>';
	var nu_expediente = '<?=$dados['variaveis']['nu_expediente']?>';
	var data_publicacao_i = '<?=$dados['variaveis']['data_publicacao_i']?>';
	var data_publicacao_f = '<?=$dados['variaveis']['data_publicacao_f']?>';
	var hdd_order_by = '<?=$dados['variaveis']['hdd_order_by']?>';
	var hdd_sort_by = '<?=$dados['variaveis']['hdd_sort_by']?>';
	var hdd_page_absolute = '<?=$dados['variaveis']['hdd_page_absolute']?>';
	var page_size = '<?=$dados['variaveis']['page_size']?>';

	var url = '';

	$(function()
	{
		$('.form-ajax').on('submit', function(event)
		{
			event.preventDefault();
			var Form = $(this);
			medicamento = $('#medicamento').val();

			if(medicamento)
			{
				$('.lista_medicamentos').html('<br><br><div class="text-center"><i class="fa fa-refresh fa-spin"></i> Carrengando...</div>');

				hdd_page_absolute = 1;
				letra = '';

				url = 'medicamento='+medicamento+'&letra='+letra+'&empresa='+empresa+'&nu_expediente='+nu_expediente+'&data_publicacao_i='+data_publicacao_i+'&data_publicacao_f='+data_publicacao_f+'&hdd_order_by='+hdd_order_by+'&hdd_sort_by='+hdd_sort_by+'&hdd_page_absolute='+hdd_page_absolute+'&page_size='+page_size;
				
				hdd_page_absolute = 1;

				$.ajax(
				{
					url: Form.attr('action'),
					type: Form.attr('method'),
					data: url,//Form.serialize()
					dataType: 'json',
					success: function(data)
					{
						if(data.status == 1)
						{
							$('.lista_medicamentos').html(data.dados.html_medicamentos_bootstrap);
							$('.paginacao_medicamentos').html(data.dados.html_paginacao_bootstrap);
						}
						else
						{
							$('.lista_medicamentos').html('<div class="text-center red" style="margin-top:50px;"><i class="fa fa-info-circle"></i> '+data.msg+'</div><br><br>');
							$('.paginacao_medicamentos').html('');
						}
					},
					error: function()
					{
						$('.lista_medicamentos').html('<br><br><div class="red"><i class="fa fa-remove"></i> Erro ocorrido na operação...</div>');
					}
				});
			}
			else
			{
				alertify.error('O campo pesquisa é requerido');
			}
		});
	});
	function pg(pg)
	{
		$('.lista_medicamentos').html('<br><br><div class="text-center"><i class="fa fa-refresh fa-spin"></i> Carrengando...</div>');

		hdd_page_absolute = pg;
		url = 'medicamento='+medicamento+'&letra='+letra+'&empresa='+empresa+'&nu_expediente='+nu_expediente+'&data_publicacao_i='+data_publicacao_i+'&data_publicacao_f='+data_publicacao_f+'&hdd_order_by='+hdd_order_by+'&hdd_sort_by='+hdd_sort_by+'&hdd_page_absolute='+hdd_page_absolute+'&page_size='+page_size;

		$.ajax(
		{
			url: base_url_controller+'lista',
			type: 'POST',
			data: url,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == 1)
				{
					$('.lista_medicamentos').html(data.dados.html_medicamentos_bootstrap);
					$('.paginacao_medicamentos').html(data.dados.html_paginacao_bootstrap);
				}
				else
				{
					$('.lista_medicamentos').html('<div class="text-center red" style="margin-top:50px;"><i class="fa fa-info"></i> '+data.msg+'</div><br><br>');
					$('.paginacao_medicamentos').html('');
				}
			}
		});
	}
</script>
<script type="text/javascript">
	// function mostra_dados_medicamentos(medicamento,empresa,expediente,data_publicacao,bula_paciente_transacao,bula_paciente_anexo,bula_profissional_transacao,bula_profissional_anexo)
	// {
	// 	$('#modal-medicamento').modal('show');

	// 	$('.medicamento').html(medicamento);
	// 	$('.empresa').html(empresa);
	// 	$('.expediente').html(expediente);
	// 	$('.data_publicacao').html(data_publicacao);
	// 	$('.bula_paciente').html('<a target="_black" href="http://www.anvisa.gov.br/datavisa/fila_bula/frmVisualizarBula.asp?pNuTransacao='+bula_paciente_transacao+'&pIdAnexo='+bula_paciente_anexo+'"><img src="<?=base_url('assets/img/iconepdf.png')?>"></a>');
	// 	$('.bula_profissional').html('<a target="_black" href="http://www.anvisa.gov.br/datavisa/fila_bula/frmVisualizarBula.asp?pNuTransacao='+bula_paciente_transacao+'&pIdAnexo='+bula_paciente_anexo+'"><img src="<?=base_url('assets/img/iconepdf.png')?>"></a>');
	// }
</script>
<!-- <div class="modal fade" id="modal-medicamento">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-medkit" aria-hidden="true"></i> Medicamento</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped">
					<tbody>
						<tr>
							<td>Medicamento</td>
							<td><div class="medicamento"></div></td>
						</tr>
						<tr>
							<td>Empresa</td>
							<td><div class="empresa"></div></td>
						</tr>
						<tr>
							<td>Expediente</td>
							<td><div class="expediente"></div></td>
						</tr>
						<tr>
							<td>Data de Publicacao</td>
							<td><div class="data_publicacao"></div></td>
						</tr>
						<tr>
							<td>Bula do Paciente</td>
							<td><div class="bula_paciente"></div></td>
						</tr>
						<tr>
							<td>Bula do Profissional</td>
							<td><div class="bula_profissional"></div></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer clearfix">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div> -->