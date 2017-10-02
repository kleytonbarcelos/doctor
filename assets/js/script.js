//############################################################################################################
//#################################			FUNCTIONS PACKAGE (Start)			##############################
//############################################################################################################
function alert_msg($element='.msg', $msg, $type='danger')
{
	// if($tipo=='success'){$icone='fa-check-circle';}
	// if($tipo=='danger'){$icone='fa-times-circle';}
	// if($tipo=='warning'){$icone='fa-exclamation-triangle';}

	$html = ''+
				'<div class="alert alert-'+$type+' alert-dismissible" role="alert">'+
					'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					''+$msg+''+
				'</div>'+
			'';
	$($element).html( $html );
}
function str_replace(str, de, para)
{
	var pos = str.indexOf(de);
	while (pos > -1)
	{
		str = str.replace(de, para);
		pos = str.indexOf(de);
	}
	return (str);
}
function HexToRGB(hex)
{
	var hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
	return {r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF)};
}
function URLencode( sStr )
{
	return escape( sStr ).replace( /\+/g, '%2C' ).replace( /\"/g,'%22' ).replace( /\'/g, '%27' );
}
function trim( str )
{
	return str.replace( /^\s*|\s*$/g,"" );
}
function number_format(number, decimals, dec_point, thousands_sep)
{
	var exponent  = "";
	var numberstr = number.toString ();
	var eindex    = numberstr.indexOf ("e");

	if(numberstr.match(',') && numberstr.match('.')) {
		return numberstr;
	}

	if (eindex > -1)
	{
		exponent = numberstr.substring (eindex);
		number = parseFloat (numberstr.substring (0, eindex));
	}

	if (decimals != null)
	{
		var temp = Math.pow (10, decimals);
		number   = Math.round (number * temp) / temp;
	}

	var sign       = number < 0 ? "-" : "";
	var integer    = (number > 0 ?	Math.floor (number) : Math.abs (Math.ceil (number))).toString ();
	var fractional = number.toString().substring (integer.length + sign.length);

	dec_point  = dec_point != null ? dec_point : ".";
	fractional = decimals != null && decimals > 0 || fractional.length > 1 ? (dec_point + fractional.substring (1)) : "";

	if (decimals != null && decimals > 0)
	{
		for (i = fractional.length - 1, z = decimals; i < z; ++i)
		fractional += "0";
	}

	thousands_sep = (thousands_sep != dec_point || fractional.length == 0) ? thousands_sep : null;

	if (thousands_sep != null && thousands_sep != "")
	{
		for (i = integer.length - 3; i > 0; i -= 3)
		integer = integer.substring (0 , i) + thousands_sep + integer.substring (i);
	}

	return sign + integer + fractional + exponent;
}

function getURLParam(strParamName){
  var strReturn = "";
  var strHref = window.location.href;
  if ( strHref.indexOf("?") > -1 ){
    var strQueryString = strHref.substr(strHref.indexOf("?")).toLowerCase();
    var aQueryString = strQueryString.split("&");
    for ( var iParam = 0; iParam < aQueryString.length; iParam++ ){
      if (aQueryString[iParam].indexOf(strParamName.toLowerCase() + "=") > -1 ){
        var aParam = aQueryString[iParam].split("=");
        strReturn = aParam[1];
        break;
      }
    }
  }
  return unescape(strReturn);
}
function escapeAll(string)
{
    var decHex = function(dec) {
        var chars = '0123456789ABCDEF';
        
        return chars.charAt(Math.floor(dec / 16)) + chars.charAt(dec % 16);
    };
    
    var out = '';
    
    for(var i = 0; i < string.length; i++) {
        var code = string.charCodeAt(i);
        
        if(code > 255)
            out += '%3F'; //coloca uma interrogacao caso o caractere seja desconhecido
        else
            out += '%' + decHex(code);
    }
    return out;
}
function url_to_array(query)
{
   var ArrayUrl = {};
   if ( ! query ) {return ArrayUrl;}// return empty object
   var Pairs = query.split(/[;&]/);
   for ( var i = 0; i < Pairs.length; i++ ) {
      var KeyVal = Pairs[i].split('=');
      if ( ! KeyVal || KeyVal.length != 2 ) {continue;}
      var key = unescape( KeyVal[0] );
      var val = unescape( KeyVal[1] );
      val = val.replace(/\+/g, ' ');
      ArrayUrl[key] = val;
   }
   return ArrayUrl;
}
function removeHTMLTags(str)
{
	str = str.replace(/&(lt|gt);/g, function (strMatch, p1){ return (p1 == "lt")? "<" : ">";	});
	var str = str.replace(/<\/?[^>]+(>|$)/g, "");
	return str;
}
function rand(n)
{
	return ( Math.floor ( Math.random ( ) * n + 1 ) );
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
function cookies_to_object()
{
	var theCookies = document.cookie.split(';'),
	cookieObj = {},	tmp, tmpName, tmpVal;
	for (var i = 1 ; i <= theCookies.length; i++)
	{
		tmp = theCookies[i-1].split('=');
		if ( tmp[0] !== undefined && tmp[1] !== undefined )
		{
			tmpName = decodeURIComponent(tmp[0].trim());
			tmpVal = decodeURIComponent(tmp[1].trim());
			if ( tmpName.indexOf('[') > -1 && tmpName.indexOf(']') > -1 )
			{
				cookieObj[tmpName.split('[')[0]] = cookieObj[tmpName.split('[')[0]] || {};
				cookieObj[tmpName.split('[')[0]][tmpName.split('[')[1].replace(']', '')] = tmpVal;
			}
			else
			{
				cookieObj[tmpName] = tmpVal;
			}
		}
	}
	return cookieObj;
}
function empty(val)
{
	// test results
	//---------------
	// []        true, empty array
	// {}        true, empty object
	// null      true
	// undefined true
	// ""        true, empty string
	// ''        true, empty string
	// 0         false, number
	// true      false, boolean
	// false     false, boolean
	// Date      false
	// function  false

	if (val === undefined)
	return true;

	if (typeof (val) == 'function' || typeof (val) == 'number' || typeof (val) == 'boolean' || Object.prototype.toString.call(val) === '[object Date]')
	return false;

	if (val == null || val.length === 0)// null or 0 length array
	return true;

	if (typeof (val) == "object") {
	// empty object

	var r = true;

	for (var f in val)
	r = false;

		return r;
	}

	return false;
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
function date_to_br(str)
{
	var data = new Date(str);
	var dia = ('00'+ (data.getUTCDate())).slice(-2);
	var mes = ('00'+(data.getUTCMonth()+1)).slice(-2);
	var ano = data.getUTCFullYear();
	return [dia, mes, ano].join('/');
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
function formata_bulario()
{
	$('.bulario').find('td').each(function(index, el)
	{
		len = parseInt($(el).text().length);
		console.log(len);
		rest = 300-len;

		dots = '';
		for(i=0;i<rest;i++)
		{
			dots += '.';
		}
		$(el).text( $(el).text()+' '+dots );
		dots = '';
	});
}
function parcelas_paypal(valor, numero_parcelas=1)
{
	valor = parseInt(valor);
	numero_parcelas = parseInt(numero_parcelas);

	taxa_parcela = 2.39;
	taxa_avista = 4.99;
	if(numero_parcelas==1)
	{
		taxa_total = taxa_avista;
	}
	else
	{
		taxa_total = ( (numero_parcelas-1) * taxa_parcela) + taxa_avista;
	}
	acrescimo = valor * (taxa_total/100);
	return number_format(valor + acrescimo, 2);
}
//############################################################################################################
//#################################			FUNCTIONS PACKAGE (End)			##################################
//############################################################################################################



//############################################################################################################
//#############################			SCRIPTS - JQUERY REQUIRED (Start)			##########################
//############################################################################################################
//############################################################################################################
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
		var inputs_vars_pdf = '';
		$.each(settings, function(index, val)
		{
			inputs_vars_pdf += '<input name="'+index+'" value="'+val+'">';
		});
		console.log(inputs_vars_pdf);
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
	//#######################################################################
	css = '';
	// css = $('link[href$=".css"]').map(function(index, elem)
	// {
	// 	return $(elem).attr('href');
	// }).get().join(',');
	style = $.trim($('style').text().replace(/[\t\n]+/g,' '));
	//#######################################################################
	textarea_html = '';
	conteudo = $.trim( $(element).html().replace(/\n\s+|\n+|\t/g, "") );
	conteudo = split_str(conteudo, 10000);
	$.each(conteudo, function(index, val)
	{
		textarea_html += '<textarea name="html[]">'+val+'</textarea>';
	});
	//#######################################################################
	$('.divformpdf').remove();
	//#######################################################################
	formpdf_html = ''+
		'<form action="'+base_url+'pdf" id="formpdf" target="'+target+'" method="post" style="display:none;">'+
			'<textarea name="style">'+style+'</textarea>'+
			'<textarea name="css">'+css+'</textarea>'+
			''+textarea_html+''+
			''+inputs_vars_pdf+''+
			'<input type="submit">'+
		'</form>'+
		'<iframe id="iframempdf" name="iframempdf" style="display:none;"></iframe>'+
	'';
	$('body').append( $('<div class="divformpdf">').html(formpdf_html) );
	setTimeout(function()
	{
		$('#formpdf').attr({'target':target});
		$('#formpdf').trigger('submit');
	}, 5000);
}
function msg(element, texto, tipo)
{
	if(tipo=='success')
	{
		icone='fa-check-circle-o';

		setTimeout(function()
		{
			removemsg();
		}, 10000);
	}
	if(tipo=='danger')
	{
		icone='fa-times-circle';
	}
	$(element).html('<div class="alert alert-'+tipo+' alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa '+icone+'"></i> '+texto+'</div>').show('slow');
}
function alert_success(element, texto)
{		
	$(element).html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-check-circle-o"></i> '+texto+'</div>').show('slow');
	setTimeout(function()
	{
		removemsg();
	}, 10000);
}
function alert_danger(element, texto)
{		
	$(element).html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-times-circle"></i> '+texto+'</div>').show('slow');
}
function removemsg()
{
	$('.alert').hide('slow', function(){$(this).remove();});
}
function excluirregistro(id, pg)
{
	Url = 'pg=excluir'+pg+'&id='+id;
	if (confirm('Você realmente deseja excluir este registro?'))
	{
		Url = 'pg=excluir'+pg+'&id='+id;
		$.ajax(
		{
			url: URL+'ajax.php',
			type: 'POST',
			data: Url,
			dataType: 'json',
			success: function(data)
			{
				if( data.status == 1 )
				{
					window.location.href = window.location;
				}
			}
		});
	}
}
function excluirregistroscheckbox(pg)
{
	var id = '';
	var contador = 0;
	$("input[type='checkbox']").each(function()
	{
		if( $(this).attr('checked') == true )
		{
			id += $(this).val()+',';
			contador++;
		}
	});
	if( contador == 0 )
	{
		alert('AVISO!\n\nSelecione pelo menos 1 registro para executar a ação.\n');
	}
	else
	{
		id = id.substring(0,id.length-1);
		if (confirm('Você realmente deseja excluir este(s) registro(s) ?			 '))
		{
			Url = 'pg=excluir'+pg+'&id='+id;
			$.ajax(
			{
				url: URL+'ajax.php',
				type: 'POST',
				data: Url,
				dataType: 'json',
				success: function(data)
				{
					if( data.status == 1 )
					{
						window.location.href = window.location;
					}
				}
			});
		}
	}
}
//####################################################################################################################################### Forms AJAX
//#######################################################################################################################################
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
	//###############################################################################################################
	//$('[data-resposta-secundaria="true"]').find('.resposta-secundaria').hide();
	$('body').on('change', '[data-resposta-secundaria="true"]', function(event)
	{
		event.preventDefault();
		if( $(this).val() == 'sim' )
		{
			$(this).parent('.form-group').find('.resposta-secundaria').show();
		}
		else
		{
			$(this).parent('.form-group').find('.resposta-secundaria').hide();
			$(this).parent('.form-group').find('.resposta-secundaria').find('input').val('');
		}
	});
	//###############################################################################################################
	//################################################## Busca CEP (início) #########################################
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
							$('#txtCep').next().html('');
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
	//###############################################################################################################
	$('body').tooltip(
	{
		selector: '[data-toggle="tooltip"]'
	});
	$('body').popover(
	{
		selector: '[data-toggle="popover"]'
	});
	$('.popoverelement').popover(
	{
		html : true,
		content: function()
		{
			return $($(this).data('element')).html();
		},
		// title: function()
		// {
		// 	return $(this).data('title')+'<span class="close">&times;</span>';
		// }
	}).on('shown.bs.popover', function(e)
	{
		var popover = $(this);
		$(this).parent().find('div.popover .close').on('click', function(e)
		{
			popover.popover('hide');
		});
	});
});
//############################################################################################################
//#############################			SCRIPTS - JQUERY REQUIRED (Start)			##########################
//############################################################################################################
//############################################################################################################