<?php
	function grava_log($url, $msg)
	{
		$CI =& get_instance();
		$CI->load->model('log_model');
		$data = array(
			'usuario_id'=>$CI->session->dados_usuario->id,
			'data'=>date('Y-m-d H:i:s'),
			'ip'=>str_replace('::1', '127.0.0.1', $_SERVER['REMOTE_ADDR']),
			'browser'=>$_SERVER['HTTP_USER_AGENT'],
			'url'=>$url,
			'mensagem'=>$msg,
		);
		$CI->log_model->insert($data);
	}