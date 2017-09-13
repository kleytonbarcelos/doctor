<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	/**
	 * [is_unique description]
	 *
	 * @Override
	 *
	 * @param  string  $str   [description]
	 * @param  string  $field [description]
	 * @return boolean        [description]
	 */
	public function is_unique($str, $field)
	{
		if (substr_count($field, '.') == 3)
		{
			list($table, $field, $id_field, $id_val) = explode('.', $field);
			$query = $this->CI->db->limit(1)->where($field, $str)->where($id_field . ' != ', $id_val)->get($table);
		} else {
			list($table, $field)=explode('.', $field);
			$query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
		}

		return $query->num_rows() === 0;
	}
	public function oldpassword_check($old_password)
	{
		$old_password_hash = $old_password;//md5($old_password);
		$old_password_db_hash = $this->yourmodel->fetchPasswordHashFromDB();

		if($old_password_hash != $old_password_db_hash)
		{
			$this->form_validation->set_message('oldpassword_check', 'Preencha o compra confirmação de senha.');
			return FALSE;
		} 
		return TRUE;
	}
}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */