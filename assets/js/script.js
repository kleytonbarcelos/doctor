function set_select(element, value)
{
	setTimeout(function()
	{
		$('#'+element).val(value).trigger('change');
	}, 500);
}
function getvaluesinputs(controller, id)
{
	$.ajax(
	{
		url: base_url+controller+'/getvaluesinputs',
		type: 'POST',
		data: 'id='+id,
		dataType: 'json',
		success: function(data)
		{
			$.each(data.inputs, function(input, value)
			{
				$element = $('[data-field-db="'+input+'"]');
				//console.log($element.attr('name')+': VALOR>> '+value);
				if( $element.length )
				{
					if( $element.prop('type') == 'checkbox' )
					{
						//console.log($element.attr('name')+' (checkbox): '+value);
						if(value==1)
						{
							$element.prop('checked', true);
						}
						else
						{
							$element.prop('checked', false);
						}
					}
					else if( $element.prop('type') == 'select-one' ) //select
					{
						//console.log(select.attr('name')+' (select): '+value);
						if(value)
						{
							set_select($element.attr('name'), value);
						}
					}
					else // text|hidden|password|textarea|etc...
					{
						if( $element.prop('type') == 'file' )
						{
							if(value)
							{
								$element.parents('.fileinput-group').find('.btn_excluir_file').show();
								$element.parents('.fileinput-group').find('.file_default').show();
								$element.parents('.fileinput-group').find('.file_default').find('.file').html('<a href="'+base_url+'assets/uploads/'+value+'" data-fancybox="images"><img style="max-height:200px !important;" src="'+base_url+'assets/uploads/'+value+'"></a>');
							}
							else
							{
								$element.parents('.fileinput-group').find('.btn_excluir_file').hide();
								$element.parents('.fileinput-group').find('.file_new').show();
							}
							//console.log($element.attr('name')+' (file): '+value);
							//$element.val(value);
						}
						else if( $element.prop('type') == 'hidden' )
						{
							//console.log($element.attr('name')+' (hidden): '+value);
							$element.val(value);
						}
						else if( $element.prop('type') == 'textarea' )
						{
							//console.log($element.attr('name')+' (textarea): '+value);
							$element.val(value);
						}
						else
						{
							//console.log($element.attr('name')+' (outhers): '+value);
							$element.val(value);
						}
						//############################################################### Exceção para campos TYPEAHEAD
						if( $element.data('callback') )
						{
							$element.trigger('callback');
						}
						if( $element.hasClass('inputmask-data') )
						{
							$element.val( date_to_br(value) );
						}
					}
				}
			});
		}
	});
}		
function cookies_show()
{
	var cookies = document.cookie.split(';');
	$.each(cookies, function(index, val)
	{
		tmp = val.trim().split('=');
		if(tmp[0])
		{
			console.log(tmp[0]+'='+tmp[1]);
		}
	});
}
function cookies_remove()
{
	var cookies = document.cookie.split(';');
	$.each(cookies, function(index, val)
	{
		tmp = val.trim().split('=');
		if(tmp[0])
		{
			Cookies.remove(tmp[0]);
		}
	});
}
function sizeof(element)
{
	if(typeof element == "object")
	{
		var i, count = 0;
		for(i in element)
		{
			if(element.hasOwnProperty(i))
			{
				count++;
			}
		}
		return count;
	}
	else if(typeof element == "array")
	{
		return element.lenght;
	}
	else
	{
		return false;
	}
}
function nome_abreviado(nome)
{
	var nome_completo = nome.split(" ");
	return nome_completo[0]+' '+nome_completo[nome_completo.length-1];
}
function nome_logo(nome)
{
	nome = nome_abreviado(nome);
	var nome_completo = nome.split(' ');
	return nome_completo[0].substr(0, 1).toUpperCase()+nome_completo[1].substr(0, 1).toUpperCase();
}
function primaira_letra_maiuscula(str)
{
	//pega apenas as palavras e tira todos os espaços em branco.
	return str.replace(/\w\S*/g, function(str)
	{
		//passa o primeiro caractere para maiusculo, e adiciona o todo resto minusculo
		return str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
	});
}
function br2nl(str)
{
	//return str.replace(/\<br\>/g, "\n").replace(/\<br \/\>/g, "\n");
	return str.replace(/<br\s*\/?>/mg,"\n");
}
function url2object(str)
{
	return JSON.parse('{"' + decodeURI(str.replace(/&/g, "\",\"").replace(/=/g,"\":\"")) + '"}');
}
//###################################################################################################
//###################################################################################################
//###################################################################################################
//###################################################################################################
//###################################################################################################
//###################################################################################################
//###################################################################################################
//###################################################################################################
//###################################################################################################
//###################################################################################################
//###################################################################################################
//###################################################################################################
function split_str(str, registro_por_pagina=5)
{
	texto = str;
	paginas = Math.ceil(texto.length / registro_por_pagina);
	
	grupos = [];
	tmp = 0;
	for(i=0;i<paginas;i++)
	{
		grupos[i] = texto.substr(tmp, registro_por_pagina);
		tmp = registro_por_pagina + tmp;
	}
	return grupos;
}
function mpdf(element, settings)
{
	if(settings)
	{
		settings = url2object(settings);
		var appendformpdfhtml = '';
		$.each(settings, function(index, val)
		{
			appendformpdfhtml += '<input name="'+index+'" value="'+val+'">';
		});
	}
	else
	{
		settings = {};
	}
	
	if(settings.output=='download')
	{
		target = 'iframempdf';
	}
	else
	{
		if( settings.target == 'fancybox' )
		{
			$.fancybox.open(
			{
				src  : '',
				type : 'iframe',
			});
			target = $('[class^="fancybox-iframe"]').attr('id');
		}
		else
		{
			target = (settings.target) ? settings.target : '_blank';
		}
	}
	css = $('link[href$=".css"]').map(function(index, elem)
	{
		return $(elem).attr('href');
	}).get().join(',');
	style = $.trim($('style').text().replace(/[\t\n]+/g,' '));
	//$("body").text(dom.replace(/\n\s+|\n/g, ""));
	//#######################################################################
	//#######################################################################
	//#######################################################################
	html = '';
	conteudo = $.trim( $(element).html().replace(/\n\s+|\n+|\t/g, "") );
	conteudo = split_str(conteudo, 10000);
	$.each(conteudo, function(index, val)
	{
		html += '<textarea name="html[]">'+val+'</textarea>';
	});
	$('.divformpdf').remove();
	formpdfhtml = ''+
		'<form action="'+base_url+'pdf" id="formpdf" target="'+target+'" method="post" style="display:none;">'+
			'<textarea name="style">'+style+'</textarea>'+
			'<textarea name="css">'+css+'</textarea>'+
			''+html+''+
			''+appendformpdfhtml+''+
			'<input type="submit">'+
		'</form>'+
		'<iframe id="iframempdf" name="iframempdf" style="display:none;"></iframe>'+
	'';
	$('body').append( $('<div class="divformpdf">').html(formpdfhtml) );
	$('#formpdf').attr({'target':target});
	$('#formpdf').trigger('submit');
}
//##########################################################################################
function clear_inputs_modal(form)
{
	$(form).find(':text, :password, :file, textarea').val('');
	$(form).find(':radio, :checkbox').attr("checked",false);
	$(form).find('select').val('');
	clear_form_erros();
}
function clear_form_erros(form)
{
	$(form).find('.msg').html('');
	$(form).find('.msg-erro').html('');
	$(form).find('.has-error').removeClass('has-error');
	$(form).find('.modal-msg').html('');
	$(form).find('.nav-tabs').find('.cont').html(''); // Limpa contadores de erros (NAVTABS)
	$(form).find('.nav-tabs a:first').tab('show');
}
function formajaxerros(form, erros)
{
	var LinkNavTabs = '';
	var cont = 0;
	var msg = '';
	$.each(erros, function(campo, valor)
	{
		var Input = $(form).find('[name='+campo+']');
		//Input.nextAll('.msg-erro').eq(0).html(valor);
		Input.parents('.form-group').eq(0).addClass('has-error');
		msg += '<div><small>'+valor+'</small></div>';

		LinkNavTabs = Input.parents('.tab-pane').eq(0).prop('id');
		if(LinkNavTabs)
		{
			var ElementCont = $('.nav-tabs a[aria-controls="'+LinkNavTabs+'"]').find('.cont');
			//if(cont==0){ElementCont.text('')}
			cont = parseInt( ElementCont.text() );
			if( isNaN(cont) )
			{
				cont=1;
			}
			else
			{
				cont = cont + 1;
			}
			ElementCont.html('<span class="badge">'+cont+'</span>');
			cont = 0;
		}
	});
	$(form).find('.msg')
	.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>')
	.show();

	if(LinkNavTabs)
	{
		$element = null;
		$tab = null;
		$('.nav-tabs').find('.cont').each(function(index, el)
		{
			if( $(el).text().length > 0 )
			{
				$element = $(el);
				return false;
			}
		});
		//console.log('tab: '+$element.parents('a').attr('aria-controls'));
		$element.parents('a').tab('show');
	}
}
var form_status = {};
$(function()
{
	$('.btn_excluir_file').click(function(event)
	{
		$element = $(this);
		$.ajax(
		{
			url: base_url_controller+'excluir_arquivo',
			type: 'POST',
			data: 'field='+$(this).data('field')+'&id='+$('#id').val(),
			dataType: 'json',
			success: function(data)
			{
				if(data.status==1)
				{
					$element.parents('.fileinput-group').find('.file_default').hide();
					$element.parents('.fileinput-group').find('.file_new').show();
				}
			}
		});
		$element.hide();
	});
	$('.formajax').on('submit', function(event)
	{
		event.preventDefault();

		var $form = $(this);
		var $button_submit = $form.find('button:submit');
		$button_submit.data('loading-text', '<i class="fa fa-circle-o-notch fa-spin"></i> Carregando...');
		$button_submit.button('loading');
		clear_form_erros('#'+$form.attr('id'));
		//################################################################################################ // FIX para atualizar conteúdo do CKEDITOR antes do submit
		if( $('[class^="ckeditor"]').length > 0 )
		{
			for (var i in CKEDITOR.instances){CKEDITOR.instances[i].updateElement()}
		}
		//################################################################################################ // FIX ENVIAR FORM NORMAL OU UPLOAD
		var $data;
		var contentType = "application/x-www-form-urlencoded";
		var processData = true;
		//################################################################################################
		if( $form.attr('enctype') == 'multipart/form-data' )
		{
			var $data = new FormData( $form.get(0) );
			var contentType = false;
			var processData = false;
			//$data.append('txtCAMPO', 'txtCAMPO_VALUE');
			//################################################################################################
			// FIX para correção de erros de enviar input:checbox VAZIOS juntos com os outros campos via ajax.
			$form.find('input:checkbox').each(function(index, el){if( $(el).prop('checked') == false ){ $data.append($(el).prop('name'), 0); }else{ $data.append($(el).prop('name'), 1); } });
			//################################################################################################
		}
		else
		{
			//################################################################################################
			// FIX para correção de erros de enviar input:checbox VAZIOS juntos com os outros campos via ajax.
			var $data = $form.serialize()+'&'+$form.find('input:checkbox').map(function(i, e){if( $(e).prop('checked') == false ){ return $(e).prop('name')+'=0'; }else{ return $(e).prop('name')+'=1'; }}).get().join('&');
			//################################################################################################
		}
		$.ajax(
		{
			url: $form.attr('action'),
			type: $form.attr('method'),
			data: $data,
			dataType: 'json',
			cache : false,
			contentType: contentType,
			processData: processData,
		})
		.done(function(data)
		{
			$button_submit.button('reset');
			if( $form.data('callback') )
			{
				$form.trigger('callback', [data]);
			}
		})
		.fail(function() //error
		{
			$button_submit.button('reset');
		})
		.always(function() //complete
		{
			$button_submit.button('reset');
		});
	});
	//######################################################################################
	//######################################################################################
	//######################################################################################
	//######################################################################################
	$('body').tooltip(
	{
		selector: '[data-toggle="tooltip"]'
	});
	$('body').popover(
	{
		selector: 'a[data-toggle="popover"]'
	});
	$('.popoverelement').popover(
	{
		html : true,
		content: function()
		{
			return $($(this).data('element')).html();
		},
	}).on('shown.bs.popover', function(e)
	{
		var popover = $(this);
		$(this).parent().find('div.popover .close').on('click', function(e)
		{
			popover.popover('hide');
		});
	});
});