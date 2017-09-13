<?php
	$cont = 1;
	echo '<div class="list-group">';
	foreach ($dados as $value)
	{
		//echo '<a style="border-left: 5px solid #F39C12;margin-bottom:8px;" class="list-group-item" href="'.$this->base_url_controller.'capitulos/'.$value->id.'"><span class="label label-info">'.$value->categoria_inicio.' '.$value->categoria_fim.'</span><div style="padding-top:5px;">'.$value->descricao.'</div></a>';
		echo '<a class="list-group-item cid10-capitulos" href="'.$this->base_url_controller.'capitulos/'.$value->id.'"><i class="fa fa-tag"></i>&nbsp;&nbsp;'.$value->descricao.'<kbd class="pull-right">'.$value->categoria_inicio.'-'.$value->categoria_fim.'</kbd></a>';
		$cont++;
	}
	echo '</div>';
?>
<style type="text/css">
	kbd
	{
		background-color: #eee;
		color: #333;
		border: 1px solid #ccc;
		font-weight: bold;
	}
</style>
<!-- <div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-th-list"></i> Capítulos</h3>
			</div>
			<div class="panel-body"> -->
				<?php
					// echo '<div class="list-group">';
					// foreach ($dados as $value)
					// {
					// 	//echo '<div><a class="cid10" data-id="'.$value->id.'">'.$value->descricao.'</a></div>';
					// 	echo '<a href="#" class="list-group-item cid10" data-id="'.$value->id.'">'.$value->descricao.' <span class="label pull-right">'.$value->categoria_inicio.'-'.$value->categoria_fim.'</span></a>';
					// }
					// echo '</div>';
				?>
<!-- 			</div>
		</div>
	</div>
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-th-list"></i> Grupos</h3>
			</div>
			<div class="panel-body grupos">
			</div>
		</div>
	</div>
</div> -->
<!-- <script type="text/javascript">
	$('.cid10').on('click', function(event)
	{
		event.preventDefault();
		$('.cid10').removeClass('active');
		$(this).addClass('active');
		$.ajax(
		{
			url: base_url_controller+'grupos',
			type: 'POST',
			data: 'capitulo_id='+$(this).data('id'),
			dataType: 'json',
			success: function(data)
			{
				$('.grupos').html(data.html);
			}
		});
	});
</script> -->