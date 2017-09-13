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
		$str = str_replace('$', '', str_replace('R$', '', $str)); // remove $ ou R$

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