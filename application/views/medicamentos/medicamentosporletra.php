<script type="text/javascript">
	$(function()
	{
		$('a[href*="/saude/bulas/precos/"]').on('click', function(event)
		{
			event.preventDefault();

			var url = $(this).attr('href');

			$.ajax(
			{
				url: base_url_controller+'precos_medicamento',
				type: 'POST',
				data: 'url='+url,
				dataType: 'json',
				success: function(data)
				{
					$('#modal-precos .modal-body').html(data.html);
					$('#modal-precos').modal('show');
				}
			});
		});
		$('body').on('click', '.bula', function(event)
		{
			event.preventDefault();
			
			window.location.href=$(this).data('url');
		});
	});
</script>
<style type="text/css">
	.accordion-um
	{
		font-size: 14px;
		font-weight: 400;

		margin: 0;
		padding: 5px;
		background-color: #666;
		color: #fff;
		font-weight: bold;
	}
	.tabela-medicamentos thead tr
	{
		left: -9999px;
		position: absolute;
		top: -9999px;
	}
	.tabela-medicamentos tbody tr
	{
		padding: 20px 10px;
	}
	.tabela-medicamentos tbody tr td {
		border: medium none;
		position: relative;
	}
	.tabela-medicamentos tbody tr td::before {
		font-weight: 700;
		white-space: nowrap;
	}
	.tabela-preco-medicamentos {
		margin-bottom: 20px;
		margin-top: 7px;
		width: 100%;
	}
	.tabela-preco-medicamentos tbody tr {
		padding: 20px 10px;
	}
	.tabela-preco-medicamentos tbody tr a {
		font-weight: 400;
	}
	.tabela-preco-medicamentos tbody tr th {
		font-weight: 400;
		padding: 0 0 5px;
	}
	.tabela-preco-medicamentos tbody tr td {
		border-right: 2px solid #fff;
		display: table-cell;
		/*padding: 14px 20px;*/
		text-align: center;
		vertical-align: middle;
		font-size: 80%;
	}
	.tabela-preco-medicamentos tbody tr td:nth-child(1) {
		width: auto;
	}
	.tabela-preco-medicamentos thead
	{
		border-bottom: 2px solid #ddd;
		color: #000;
		font-weight: bold;
		font-size: 9px;
		text-transform: uppercase;
		text-align: center;
	}
	.tabela-preco-medicamentos thead tr th {
		padding: 0 0 5px;
		text-align: center;
	}
	.cabecalho-medicamento
	{
		background-color: #fff;
		padding: 1px 10px 10px 10px;
	}
	/*###########################################################################*/
	/*###########################################################################*/
	.dados_medicamento
	{
		background-color: #fff;
	}
	.dados_medicamento h2
	{
		font-size:22px;
		margin-top: 0;
		font-weight: 400;
	}
	.panel-group
	{
		font-family: Tahoma,Verdana,Segoe,sans-serif;
		margin:0;
		/*border:1px solid #ccc;*/
		background-color: #fff;
	}
	.panel-group > div > h3
	{
		font-size: 20px;
		font-weight: 400;

		margin: 0;
		padding: 10px;
		background-color: #00CCFF;
		color: #fff;
		font-weight: bold;
	}
	.panel-group > div > div
	{
		margin: 0;
		padding: 20px;
		font-family: Tahoma !important;
	}
	.texto-fixo
	{
		background: #f0f0f0;
		padding: 20px;
		font-weight:bold;
	}
	.texto-fixo > p
	{
		margin-bottom: 0px;
	}
	.va-direto-ao-ponto
	{
		margin-top: 10px;
	}
</style>
<h2><i class="fa fa-medkit"></i> Medicamentos letra <?=$letra?></h2>
<ul class="list-group">
	<?php
		foreach ($medicamentos as $value)
		{
			?>
				<li class="list-group-item cursor-pointer" data-url="<?=str_replace('http://www.minhavida.com.br/saude/bulas/', '', $value->url)?>"><i class="fa fa-eyedropper"></i>&nbsp;&nbsp;<?=$value->nome?></li>
				<!-- <h4><span class="label label-success"><?=$value->nome?></span></h4> -->
			<?php
		}
	?>
</ul>
<script type="text/javascript">
	$(function()
	{
		$('.list-group-item').click(function(event)
		{
			window.location.href = base_url_controller+'bula/'+$(this).data('url');
		});
	});
</script>