<?php
	if (!function_exists('query_array_to_row'))
	{
	    function query_array_to_row($array_multi_row=array())
	    {
	        return ( array_key_exists(0, $array_multi_row) ) ? $array_multi_row[0]: $array_multi_row;
	    }
	}
	function str_to_strong($str)
	{
		return '<strong>'.$str.'</strong>';
	}
	function strong($str)
	{
		return str_to_strong($str);
	}
	function nome_proprio($str)
	{
		$str = trim($str);
		$str = strtr(strtolower($str),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
		$partesNome = explode(' ', $str);
		$exclude = array('da', 'das', 'de', 'do', 'dos', 'e');
		$nomeCapitalizado = '';
		foreach ($partesNome as $parte)
		{
			if (!in_array($parte, $exclude))
			{
				$parte = ucfirst_utf8($parte);
			}
			$nomeCapitalizado .= $parte.' ';
		}
		return trim($nomeCapitalizado);
	}
	function ucfirst_utf8($str)
	{
		if (mb_check_encoding($str,'UTF-8'))
		{
			$first = mb_substr(mb_strtoupper($str, "utf-8"),0,1,'utf-8');
			return $first.mb_substr(mb_strtolower($str,"utf-8"),1,mb_strlen($str),'utf-8');
		}
		else
		{
			return $str;
		}
	}
	function array_replace_key($array, $key_old, $key_new)
	{
	    $keys = array_keys($array);
	    $index = array_search($key_old, $keys);
	 
	    if ($index !== false) {
	        $keys[$index] = $key_new;
	        $array = array_combine($keys, $array);
	    }
	 
	    return $array;
	}
	function nome_abreviado($nome)
	{
		$nome_completo = explode(' ', $nome);
		return $nome_completo[0].' '.$nome_completo[count($nome_completo)-1];
	}



















	function converte_maiuscula_minuscula_com_acento($str, $tipo = 'upper')
	{
		if ($tipo == 'upper')
		{
			return strtr(strtoupper($str),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
		}
		else
		{
			return strtr(strtolower($str),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
		}
	}
    function acento_to_maiusculo($Str,$Maisculo=0)
    {
            $Str = ereg_replace("[á]","Á",$Str);
            $Str = ereg_replace("[à]","Á",$Str);
            $Str = ereg_replace("[â]","Â",$Str);
            $Str = ereg_replace("[ã]","Ã",$Str);

            $Str = ereg_replace("[é]","É",$Str);
            $Str = ereg_replace("[è]","È",$Str);
            $Str = ereg_replace("[ê]","Ê",$Str);

            $Str = ereg_replace("[í]","Í",$Str);
            $Str = ereg_replace("[ì]","Ì",$Str);
            $Str = ereg_replace("[î]","Î",$Str);
            $Str = ereg_replace("[ï]","I",$Str);

            $Str = ereg_replace("[ó]","Ó",$Str);
            $Str = ereg_replace("[ò]","Ò",$Str);
            $Str = ereg_replace("[ô]","Ô",$Str);
            $Str = ereg_replace("[õ]","Õ",$Str);

            $Str = ereg_replace("[ú]","Ú",$Str);
            $Str = ereg_replace("[ù]","Ù",$Str);
            $Str = ereg_replace("[û]","Û",$Str);

            $Str = str_replace("ç","Ç",$Str);

            if($Maisculo)
                    $Str = strtoupper($Str);

            return $Str;
    }
    function retira_acentos($Texto)
    {
            $TextoComAcentuado = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
            , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç"," ","'","´","`","/","\\","~",
            "^","¨","#","%"," ",",","<",">",";",":","/","?","°","[","{","ª","]","}","º","=","§","+","-",")","(","*","&","¨","¬","¢","%","$","£","³","²","¹","@","#","!","'","\"");

            $TextoSemAcentuado = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
            , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C","","","","","","","",
            "","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");

            return str_replace($TextoComAcentuado, $TextoSemAcentuado, $Texto);
    }