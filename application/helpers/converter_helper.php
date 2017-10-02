<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	function array_to_row($array_multi_row=array())
	{
		return ( array_key_exists(0, $array_multi_row) ) ? $array_multi_row[0]: $array_multi_row;
	}
	function date_to_us($str)
	{
		$year = substr($str, 6, 4);
		$month = substr($str, 3, 2);
		$day = substr($str, 0, 2);
		return $year . '-' . $month . '-' . $day;
	}
	function datetime_to_us($str)
	{
		$year = substr($str, 6, 4);
		$month = substr($str, 3, 2);
		$day = substr($str, 0, 2);
		$hour = substr($str, 11, 8);
		return $year . '-' . $month . '-' . $day . ' ' . $hour;
	}
	function date_to_br($str)
	{
		$year = substr($str, 0, 4);
		$month = substr($str, 5, 2);
		$day = substr($str, 8, 2);
		return $day . '/' . $month . '/' . $year;
	}
	function datetime_to_br($str)
	{
		$year = substr($str, 0, 4);
		$month = substr($str, 5, 2);
		$day = substr($str, 8, 2);
		$hour = substr($str, 11, 8);
		return $day . '/' . $month . '/' . $year . ' ' . $hour;
	}
	function br_to_decimal($str)
	{
		$str = str_replace('R$', '', str_replace('$', '', $str)); // remove $ ou R$

		if( preg_match('/,/', $str) && preg_match('/./', $str) ) // us
		{
			return str_replace(',','.',str_replace('.','',$str));
		}
		else if( preg_match('/,/', $str) ) // br
		{
			return str_replace(',','.',$str);
		}
		else
		{
			return $str;
		}
	}
	function decimal_to_br($str)
	{
		return number_format($str, 2, ',', '.');
	}
	function rand_keys($len=8, $type=true)
	{
		$letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$str = substr(str_shuffle($letters), 0, $len);
		return ($type==true) ? $str : strtolower($str);
	}
	function get_array_diff($a1, $a2)
	{
		$result = array();
		// If First Array is Bigger than Second
		if( count($a1) > count($a2) )
		{
			$result=array_diff($a1,$a2);
		}
		// If Second Array is Bigger than First
		if( count($a1) < count($a2) )
		{
			$result=array_diff($a2,$a1);
		}
		// If Both array are same but, data values are different.
		else
		{
			$result = array_merge (array_diff($a2,$a1), array_diff($a1,$a2));   
		}
		return $result;
	}
	function alert_msg($msg, $type='danger')
	{
		// if($tipo=='success'){$icone='fa-check-circle';}
		// if($tipo=='danger'){$icone='fa-times-circle';}
		// if($tipo=='warning'){$icone='fa-exclamation-triangle';}

		$html = '
					<div class="alert alert-'.$type.' alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						'.$msg.'
					</div>
				';
		return $html;
	}