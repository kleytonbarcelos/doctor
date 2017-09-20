//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@      FUNÇÕES      @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
function empty( val )
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
	//pega apenas as palavras e tira todos os espa�os em branco.
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
function Url2Array(query)
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
function Rnd(n)
{
	return ( Math.floor ( Math.random ( ) * n + 1 ) );
}