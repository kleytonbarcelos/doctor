<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends MY_Model
{
	public $_table = 'usuarios';
	public $primary_key = 'id';

	public function verifica_login($Usuario, $Senha)
	{
		// $this->db->where('usuario', $Usuario);
		// $this->db->where('senha', $Senha);
		// $consulta = $this->db->get('usuarios');

		$consulta = $this->db->query('SELECT * FROM usuarios WHERE email="'.$Usuario.'" AND senha="'.$Senha.'"')->row();

		// if(!$consulta)
		// {
		// 	$consulta = $this->db->query('SELECT * FROM clientes WHERE email="'.$Usuario.'" AND senha="'.$Senha.'"')->row();
		// }

		if( $consulta )
		{
			$this->session->dados_usuario = $consulta;
			return true;
		}
		else
		{
			return false;
		}
	}

}

/* End of file Usuario.php */
/* Location: ./application/models/Usuario.php */