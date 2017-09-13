<script type="text/javascript">
	$('.titulo').html('<i class="fa fa-book"></i> CID 10 - Cadastro Internacional de Doênças');
</script>
<style type="text/css">
	/*#imaginary_container
	{
		width: 200px;
		transition: all 1000ms;
	}*/
	.pesquisa
	{
		margin-top: 10px;
	}
</style>
<div class="pull-right">
	<span class="label label-success">Capítulos</span>
	&nbsp;
	<span class="label label-info">Grupos</span>
	&nbsp;
	<span class="label label-warning">Categorias</span>
	&nbsp;
	<span class="label label-danger">Sub-categorias</span>
</div>
<br><br>
<div class="row">
	<div class="col-md-12">
		<div id="imaginary_container" class="pull-right">
			<?=form_open('cid10/pesquisar', array('id'=>'formPesquisar', 'role'=>'form'))?>
			<div class="input-group stylish-input-group">
				<input type="text" class="form-control input-lg" name="search" id="search" data-timer="" placeholder="Pesquisar...">
				<span class="input-group-addon">
					<button type="button">
						<span class="glyphicon glyphicon-search"></span>
					</button>  
				</span>
			</div>
			<?=form_close()?>
		</div>
	</div>
</div>
<script type="text/javascript">
	var tempo = null;
	$(function()
	{
		function list_capitulos()
		{
			$.ajax(
			{
				url: base_url_controller+'capitulos',
				type: 'POST',
				dataType: 'json',
			})
			.done(function(data)
			{
				$('.capitulos').html(data.html);
			})
			.fail(function()
			{

			});
		}
		function clear()
		{
			$('.capitulos').html('');
			$('.pesquisa').html('');
		}
		$('#search').keyup(function()
		{
			clearTimeout(tempo);
			var search = $(this).val();

			if ( search.length == 0 )
			{
				clear();
				list_capitulos();
				return false;
			}
			if (search.length >= 3)
			{
				clear();
				tempo = setTimeout(function()
				{
					console.log(search);
					$.ajax(
					{
						url: base_url_controller+'pesquisar',
						type: 'POST',
						dataType: 'json',
						data: 'search='+search,
					})
					.done(function(data)
					{
						$('.pesquisa').html(data.html);
					})
					.fail(function()
					{

					});
				}, 500);
			}
		});
		// $('#imaginary_container').focusin(function(event)
		// {
		// 	$(this).css('width', '100%');
		// }).focusout(function(event)
		// {
		// 	$(this).css('width', '200');
		// });
	})
</script>
<div class="list-group pesquisa"></div>
<div class="list-group capitulos">
	<?php
		foreach ($dados as $value)
		{
			echo '<a href="javascript:void(0)" class="list-group-item" data-destino="grupos" data-id="'.$value->id.'"><span class="label label-success label-cid10-capitulos">'.$value->categoria_inicio.'-'.$value->categoria_fim.'</span>'.$value->descricao.'</a><div></div>';
		}
	?>
</div>
<script type="text/javascript">
	$(function()
	{
		$('body').on('click', '.list-group-item', function(event)
		{
			event.preventDefault();
			var $element = $(this);
			
			if( !$element.hasClass('clicked') )
			{
				$element.addClass('clicked');

				var id = $element.data('id');
				var destino = $element.data('destino');
				if(!destino){return false;}

				$.ajax(
				{
					url: base_url_controller+destino,
					type: 'POST',
					data: 'id='+id,
					dataType: 'json',
					success: function(data)
					{
						$($element).nextAll('div').eq(0).html(data.html);
					}
				});
			}
			else
			{
				$element.removeClass('clicked');
				$($element).nextAll('div').eq(0).html('');
			}
		});
	});
</script>