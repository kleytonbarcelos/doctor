$(function()
{
	$(':input').inputmask();

	$('.inputmask-celular').inputmask({mask: ['(99) 9999-9999', '(99) 99999-9999']});
	$('.inputmask-telefone').inputmask({mask: '(99) 9999-9999'});
	$('.inputmask-data').inputmask({mask: '99/99/9999'});
	$('.inputmask-cpf').inputmask({mask: '999.999.999-99'});
	$('.inputmask-cep').inputmask({mask: '99999-999'});
});