<?php
	if($controllers)
	{
		?>
		<div class="pull-right margin-bottom-20"><button type="button" class="btn btn-primary btn_sync"><i class="fa fa-check"></i> SINCRONIZAR PERMISSÕES</button></div>
		<table class="table table-striped table-hover table-bordered table-condensed">
			<thead>
				<tr>
					<th class="bg-primary" width="250">SESSÃO</th>
					<th class="bg-primary text-center" colspan="<?=sizeof($grupos)?>">GRUPOS DE USUÁRIOS</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach ($controllers as $controller => $value)
					{
						echo '<tr>';
							echo '<td><strong>'.$controller.'</strong></td>';
							foreach ($grupos as $grupo)
							{
								echo '<td align="center"><div class="label label-default" style="background-color: #000;color: #fff;">'.$grupo->nome.'</div></td>';
							}
						echo '</tr>';
						foreach ($controllers[$controller] as $value)
						{
							echo '<tr>';
							echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$value['method'].'</td>';
								foreach ($value['permissao'] as $grupo)
								{
									$html = ($grupo->acesso) ? '<span data-value="'.$grupo->acesso.'" data-grupo_id="'.$grupo->grupo_id.'" data-permissao_id="'.$grupo->permissao_id.'" class="label_acesso label label-success cursor-pointer">Acesso permitido</span>' : '<span data-value="'.$grupo->acesso.'" data-grupo_id="'.$grupo->grupo_id.'" data-permissao_id="'.$grupo->permissao_id.'" class="label_acesso label label-danger cursor-pointer">Acesso negado</span>';
									echo '<td align="center">'.$html.'</td>';
								}
							echo '</tr>';
						}
					}
				?>
			</tbody>
		</table>
		<script type="text/javascript">
			$(function()
			{
				$('body').on('click', '.label_acesso', function(event)
				{
					event.preventDefault();

					$element = $(this);
					var acesso = ($element.data('value')==0) ? 1 : 0; //Se data-value for 0 (acesso negado), se torna 1 (acesso permitido)
					$.ajax(
					{
						url: base_url_controller+'mudastatus',
						type: 'POST',
						data: 'grupo_id='+$element.data('grupo_id')+'&permissao_id='+$element.data('permissao_id')+'&acesso='+acesso,
						dataType: 'json',
						success: function(data)
						{
							if(data.status==1)
							{
								if(data.acesso==1)
								{
									$element.removeClass('label-danger').addClass('label-success').html('Acesso permitido');
								}
								else
								{
									$element.removeClass('label-success').addClass('label-danger').html('Acesso negado');
								}
								$element.data('value', data.acesso); // após a mudança de status no banco de dados, altera-se o data-value e o label
							}
						}
					});
				});
				$('.btn_sync').click(function(event)
				{
					$.fancybox.open(
						'<div class="alert alert-default">'+
							'<h3><i class="fa fa-spinner fa-spin"></i> Aguarde...</h3>'+
						'</div>',
					{
						modal:true,
						smallBtn : false,
					});
					$.ajax(
					{
						url: base_url_controller+'sync',
						type: 'POST',
						dataType: 'json',
						success: function(data)
						{
							if(data.status==1)
							{
								window.location.href=base_url_controller;
							}
						}
					});
				});
			});
		</script>
		<?php
	}
	else
	{
		?>
		<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong><i class="fa fa-exclamation-triangle"></i> Alerta!</strong> Você ainda não ativou seu sistema para aceitar GRUPOS e PERMISSÕES. Caso queira ativar o mesmo, clique no botão abaixo e aguarde.
		</div>
		<button type="button" class="btn btn-success btn_sync"><i class="fa fa-check"></i> ATIVAR GRUPOS E PERMISSÕES</button>
		<script type="text/javascript">
			$(function()
			{
				$('.btn_sync').click(function(event)
				{
					$.fancybox.open(
						'<div class="alert alert-default">'+
							'<h3><i class="fa fa-spinner fa-spin"></i> Aguarde...</h3>'+
						'</div>',
					{
						modal:true,
						smallBtn : false,
					});
					$.ajax(
					{
						url: base_url_controller+'sync',
						type: 'POST',
						dataType: 'json',
						success: function(data)
						{
							if(data.status==1)
							{
								window.location.href=base_url_controller;
							}
						}
					});
				});
			});
		</script>
		<?php
	}
?>