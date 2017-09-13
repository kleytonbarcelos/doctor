<?php
	/**
	 * Funcções para Gerar SelectBox (HTML)
	 * @param [type]  $NomeDoSelect	   [description]
	 * @param array   $Opcoes			 [description]
	 * @param boolean $OptionInicialVazio [description]
	 * @param string  $ValorPadrao		[description]
	 */
	function SelectBox($NomeDoSelect, $Opcoes = array(), $OptionInicialVazio = false, $ValorPadrao='')
	{
		$Selected = '';

		$Html = '<select name="'.$NomeDoSelect.'" class="form-control">';
		if($OptionInicialVazio == true){ $Html .= '<option></option>'; }
		foreach ($Opcoes as $key => $value)
		{
			if($ValorPadrao == $key)
			{
				$Selected = ' selected';
			}
			$Html .= '<option value="'.$key.'"'.$Selected.'>'.$value.'</option>';
			$Selected = '';
		}
		$Html .= '</select>';
		return $Html;
	}
?>