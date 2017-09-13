<input type="button" class="btn btn-warning btn-sm btn-zerandocronometro" value="ZERAR CRONOMETRO">
<input type="button" class="btn btn-danger btn-sm btn-removecronometro" value="REMOVER CRONOMETRO">
<input type="button" class="btn btn-info btn-sm btn-infocronometro" value="INFO CRONOMETRO">
<script type="text/javascript">
	$(function()
	{
		$('.btn-zerandocronometro').click(function(event)
		{
			status_roda_cronometro = false;
		});
		$('.btn-removecronometro').click(function(event)
		{
			status_roda_cronometro = false;
			Cookies.remove('cronometro');
			Cookies.remove('prontuario');
			Cookies.remove('event_id');
		});
		$('.btn-infocronometro').click(function(event)
		{
			console.log( 'CRONOMETRO>>> '+Cookies.get('cronometro') );
			console.log( 'PRONTUARIO>>> '+Cookies.get('prontuario') );
			console.log( 'EVENTO>>> '+Cookies.get('event_id') );
		});
	});
</script>