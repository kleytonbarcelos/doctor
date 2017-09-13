<br><br><br><br>
<a class="btn btn-primary btn-cadastra-medicamento"><i class="fa fa-check"></i> Cadastrar Medicamentos</a>
<div>
<small>(BASE - wwww.maissaude.com.br)</small>
</div>
<script type="text/javascript">
	var pg = 1;
	$(function()
	{
		$('.btn-cadastra-medicamento').click(function(event)
		{
			cron();
		});
	});
	function cron()
	{
		$.ajax(
		{
			type: 'POST',
			url: base_url_controller+'salva/'+pg,
			dataType: 'json',
			success: function(data)
			{
				if(data.status == 'processando')
				{
					console.log('Processando.... PG: '+data.pg);
					pg = data.pg;
					cron();
				}
				else
				{
					console.log('100% CONCLUÍDO!!!');
				}
			}
		});
	}
</script>