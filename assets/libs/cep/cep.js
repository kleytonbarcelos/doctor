// ################################################# Busca CEP (início) ############################################
function clear_form_cep()
{
	// Limpa valores do formulário de cep.
	$('#txtEndereco').val('');
	$('#txtBairro').val('');
	$('#txtCidade').val('');
	$('#txtUf').val('');
	//$('#txtIbge').val("");
}
$('#txtCep').blur(function()
{
	var cep = $(this).val().replace(/\D/g, ''); //Nova variável "cep" somente com dígitos.
	if (cep != "")
	{
		var validacep = /^[0-9]{8}$/; //Expressão regular para validar o CEP.
		if(validacep.test(cep))
		{
			$('#txtEndereco').val("...")
			$('txtBairro').val("...")
			$('txtCidade').val("...")
			$('txtUf').val("...")
			//$('txtIbge').val("...")
			$.ajax(
			{
				url: 'https://viacep.com.br/ws/'+cep+'/json/',
				type: 'GET',
				dataType: 'json',
				success: function(data)
				{
					if(data.localidade)
					{
						$('#txtEndereco').val(data.logradouro);
						$('#txtBairro').val(data.bairro);
						$('#txtCidade').val(data.localidade);
						$('#txtUf').val(data.uf);
						//$('txtIbge').val(data.ibge);
						$('#txtCep').nextAll('.msg-erro').html('');
					}
					else
					{
						clear_form_cep();
						$('#txtCep').next().html('CEP não encontrado.');
					}
				}
			});
		}
		else
		{
			clear_form_cep();
			$('#txtCep').next().html('Formato de CEP inválido.');
		}
	}
	else
	{
		clear_form_cep();
	}
});
// ################################################# Busca CEP (fim) ############################################