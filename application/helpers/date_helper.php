<?php
	function NOW()
	{
		return date('Y-m-d H:i:s');
	}
	function data_input_mysql($data='')
	{
		return substr($data,-4).'-'.substr($data,3,2).'-'.substr($data,0,2);
	}
	function data_mysql_input($data='')
	{
		$data = substr($data, 0, 10);
		return substr($data,-2).'/'.substr($data,5,2).'/'.substr($data,0,4);
	}
	// ###############################################################
	// ###############################################################
	// ###############################################################
	// ###############################################################
	function date_ultimo_dia_do_mes($mes, $ano)
	{
		return date('t',mktime(0, 0, 0, $mes,1,$ano));
	}
	function EntreDatas($timestampAntes, $timestampDepois)
	{

		//string de retorno
		$strRetorno = '';

		//diferença entre as datas em segundos
		$meRestaSegundos = $timestampDepois-$timestampAntes;

		//quantidade de anos
		$anos = $meRestaSegundos/31536000;

		//se houver anos
		$intAnos = floor($anos);
		if($intAnos >= 1){

			//mostra quantos anos passaram
			$strRetorno .= ($intAnos == 1) ? $intAnos.' ano, ' : $intAnos.' anos, ';

			//retira do total, o tempo em segundos dos anos passados
			$meRestaSegundos = $meRestaSegundos-($intAnos*31536000);
		}

		//quantidade de meses (anos/12 e não dias*30)
		$meses = $meRestaSegundos/2628000;

		//se houver meses
		$intMeses = floor($meses);
		if($intMeses >= 1){

			//mostra quantos meses passaram
			$strRetorno .= ($intMeses == 1) ? $intMeses.' mês, ' : $intMeses.' meses, ';

			//retira do total, o tempo em segundos dos meses passados
			$meRestaSegundos = $meRestaSegundos-($intMeses*2628000);
		}

		//quantidade de semanas
		$semanas = $meRestaSegundos/604800;

		//se houver semanas
		$intSemanas = floor($semanas);
		if($intSemanas >= 1){

			//mostra quantas semanas passaram
			$strRetorno .= ($intSemanas == 1) ? $intSemanas.' semana, ' : $intSemanas.' semanas, ';

			//retira do total, o tempo em segundos das semanas passados
			$meRestaSegundos = $meRestaSegundos-($intSemanas*604800);
		}

		//quantidade de dias
		$dias = $meRestaSegundos/86400;

		//se houver dias
		$intDias = floor($dias);
		if($intDias >= 1){

			//mostra quantos dias passaram
			$strRetorno .= ($intDias == 1) ? $intDias.' dia, ' : $intDias.' dias, ';

			//retira do total, o tempo em segundos dos dias passados
			$meRestaSegundos = $meRestaSegundos-($intDias*86400);
		}

		//quantidade de horas
		$horas = $meRestaSegundos/3600;

		//se houver horas
		$intHoras = floor($horas);
		if($intHoras >= 1){

			//mostra quantas horas passaram
			$strRetorno .= ($intHoras == 1) ? $intHoras.' hora, ' : $intHoras.' horas, ';

			//retira do total, o tempo em segundos das horas passados
			$meRestaSegundos = $meRestaSegundos-($intHoras*3600);
		}

		//quantidade de minutos
		$minutos = $meRestaSegundos/60;

		//se houver minutos
		$intMinutos = floor($minutos);
		if($intMinutos >= 1){

			//mostra quantos minutos passaram
			$strRetorno .= ($intMinutos == 1) ? $intMinutos.' minuto, ' : $intMinutos.' minutos, ';

			//retira do total, o tempo em segundos dos minutos passados
			$meRestaSegundos = $meRestaSegundos-($intMinutos*60);
		}

		//mostra quantos minutos passaram
		if($meRestaSegundos > 0)
			$strRetorno .= ceil($meRestaSegundos).' segundos, ';

		//retira a ultima virgula
		$strRetorno = rtrim($strRetorno, ', ');

		//coloca "e" no lugar da ultima virgula
		$arrExplode = explode(',', $strRetorno);
		$strRetornoFinal = '';
		$nPedacos = count($arrExplode);
		for($i=0; $i<$nPedacos; $i++){
			if($i == ($nPedacos-1))
				$strRetornoFinal .= ' e '.$arrExplode[$i];
			elseif($i == ($nPedacos-2))
				$strRetornoFinal .= $arrExplode[$i];
			else
				$strRetornoFinal .= $arrExplode[$i].',';
		}

		//retorna o tempo decorrido formatado
		return '<font color="#000000"><b>'.$strRetornoFinal.'</b></font>';
		//date('d/m/Y',strtotime($dataDB));
	}
	function date_idade($data)
	{
			$dataAtual_dia = date ( "d" );
			$dataAtual_mes = date ( "m" );
			$dataAtual_ano = date ( "Y" );

			$data = explode ( "/", $data );

			$idade = ($dataAtual_ano - $data [2]) - 1;

			if ($dataAtual_mes > $data [1] || (dataAtual_mes == $data [1] && $dataAtual_dia >= $data [0])) {
					$idade ++;
			}
			return $idade;
	}
	function date_proximo_dia_util($data='amanha', $saida = 'd/m/Y')
	{
			if( $data == 'amanha' )
			{
				$timestamp = strtotime("+1 days");
				$data = date('Y', $timestamp).'-'.date('m', $timestamp).'-'.date('d', $timestamp);
			}
			/**
			* Função para calcular o próximo dia útil de uma data
			* Formato de entrada da $data: AAAA-MM-DD
			*/
			// Converte $data em um UNIX TIMESTAMP
			$timestamp = strtotime($data);

			// Calcula qual o dia da semana de $data
			// O resultado será um valor numérico:
			// 1 -> Segunda ... 7 -> Domingo
			$dia = date('N', $timestamp);

			// Se for sábado (6) ou domingo (7), calcula a próxima segunda-feira
			if ($dia >= 6)
			{
		   		$timestamp_final = $timestamp + ((8 - $dia) * 3600 * 24);
			}
			else
			{
				// Não é sábado nem domingo, mantém a data de entrada
				$timestamp_final = $timestamp;
			}
			return date($saida, $timestamp_final);
	}
    function date_timestamp($str, $type='br')
    {
    	if($type=='br')
    	{		
	        $partes = explode('/', $str);
	        return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
    	}
    	else
    	{
	        $partes = explode('-', $str);
	        return mktime(0, 0, 0, $partes[1], $partes[2], $partes[0]);
    	}
    }
	function date_interval($date_start, $date_end, $format='us', $type='d')
	{
		if( $format == 'us')
		{
			$dia1 = date_timestamp($date_start, 'us');
			$dia2 = date_timestamp($date_end, 'us');
			$tempo = ($dia2-$dia1);

			if( $type == 'd' )
			{
					return round(($tempo/60/60/24));
			}
			else if( $type == 'h' )
			{
					return round(($tempo/60/60));
			}
			else if( $type == 'i' )
			{
					return round(($tempo/60));
			}
		}
		else
		{
			$dia1 = date_timestamp($date_start);
			$dia2 = date_timestamp($date_end);
			$tempo = ($dia2-$dia1);

			if( $type == 'd' ) // days
			{
					return round(($tempo/60/60/24));
			}
			else if( $type == 'h' ) //
			{
					return round(($tempo/60/60));
			}
			else if( $type == 'i' )
			{
					return round(($tempo/60));
			}
		}
	}