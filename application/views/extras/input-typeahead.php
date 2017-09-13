<!-- <input type="hidden" id="paciente_id" name="paciente_id"> -->
<!-- <div id="custom-search-input">
	<div class="input-group input-group-sm">
		<input type="text" class="search-query form-control" name="txtNome" id="txtNome" placeholder="" autocomplete="off" />
		<span class="input-group-btn">
			<button class="btn btn-sm" type="button">
				<span class="glyphicon glyphicon-search"></span>
			</button>
		</span>
	</div>
</div>
<script type="text/javascript">
	$(function()
	{
		$('#txtNome').typeahead(
		{
			ajax:
			{
				url: base_url+'pacientes/typeahead',
				triggerLength: 1,
				items: 20,
				scrollBar: true,
				method:'POST',
				displayField: 'nome',
				preProcess: function (data)
				{
					if (data.status == 1)
					{
						var list = [];
						$.each(data.pacientes, function(index, paciente)
						{
							list[index] = {'id':paciente.id, 'nome':paciente.nome};
						});
						return list;
					}
					else
					{
						return false;
					}
				}
		   	},
		   	onSelect: function(item)
		   	{
		   		$('#paciente_id').val(item.value);
		   	}
		});
	});
</script> -->