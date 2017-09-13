<br><br><br><br>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;Preenchendo banco de dados - ANVISA</h3>
			</div>
			<div class="panel-body">
				<br>
				<div class="progress">
					<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
						<!-- <span class="sr-only"> % Completo</span> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var hdd_page_absolute = 1;
	var page_size = 1000;

	$('#formCadastroCliente').on('submit', function(event)
	{
		event.preventDefault();
		var Form = $(this);
		$.ajax(
		{
			url: Form.attr('action'),
			type: Form.attr('method'),
			data: Form.serialize(),
			dataType: 'json',
			success: function(data)
			{
	            if(data.status == 1)
	            {
	                if( data.acao == 'update' )
	                {
	
					}
					
				    $('#ModalCadastroCliente').modal('hide');
	            }
	            else
	            {
	                $.each(data.erros, function(campo, valor)
	                {
						$('[name='+campo+']').nextAll('.msg-erro').eq(0).html(valor);
						$('[name='+campo+']').parents('.form-group').eq(0).addClass('has-error');
	                });
	            }
			}
		});
	});

	function cron()
	{
		$.ajax(
		{
			type: 'POST',
			data: 'hdd_page_absolute='+hdd_page_absolute+'&page_size='+page_size,
			url: base_url_controller+'salvar',
			dataType: 'json',
			success: function(data)
			{
				if(data.status == 1)
				{
					data.dados.variaveis.hdd_page_absolute = parseInt(data.dados.variaveis.hdd_page_absolute) + 1;

					porcentagem = (parseInt(data.dados.paginas.atual) * 100) / parseInt(data.dados.paginas.ultima_pagina);

					$('.progress-bar').css({'width':porcentagem+'%'}).data('aria-valuenow', porcentagem).html( Math.ceil(porcentagem) +'%');

					if( data.dados.paginas.atual == data.dados.paginas.ultima_pagina )
					{
						$('.fa-refresh').removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-check');
						$('.progress-bar').removeClass('active');
					}
					else
					{
						hdd_page_absolute = data.dados.variaveis.hdd_page_absolute;
						page_size = data.dados.variaveis.page_size;
						setTimeout(function()
						{
							cron();
						}, 500);
					}
				}
			}
		});
	}
	setTimeout(function()
	{
		cron();
	}, 500);
</script>