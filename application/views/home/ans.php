<br><br><br><br>
<a class="btn btn-primary btn-lg btn-cadastra"><i class="fa fa-play"></i> INICIAR ATUALIZAÇÃO DOS DADOS</a>
<div>
<small>REGISTROS ANS</small>
</div>
<script type="text/javascript">
	$(function()
	{
		$('.btn-cadastra').click(function(event)
		{
			cron();
		});
	});
	function cron()
	{
		var registrosans = $.ajax(
		{
			type: 'POST',
			url: base_url_controller+'registrosans',
			dataType: 'json',
			success: function(data)
			{
				return data.registrosans;
			}
		});

		$.when(registrosans).done(function(data)
		{
			var cont_send_ajax=0;
			$.each(data.registrosans, function(index, val)
			{
				console.log('SALVANDO REGISTRO>>> '+val.registroans);
				$.ajax(
				{
					url: base_url_controller+'salva_ans',
					type: 'POST',
					data: 'id='+val.registroans,
					dataType: 'json',
					beforeSend: function()
					{
						cont_send_ajax++;
					},
					success: function(data)
					{
						if (!--cont_send_ajax)
						{
							console.log('100% CONCLUÍDO');
						}
					}
				});
			});
		});
	}
</script>