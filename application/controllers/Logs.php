<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('log_model');
	}
	public function index()
	{
		$this->template->load('AdminLTE/index', 'logs/index');
	}
	public function visualizar($id)
	{
		$data['dados'] = $this->log_model->get_by('MD5(id)', $id);
		if($data['dados'])
		{
			$this->template->load('AdminLTE/index', 'logs/visualizar', $data);
		}
		else
		{
			redirect('home','refresh');
		}
	}
	public function bootstrap_table()
	{
		$limit  = (isset($_GET['limit']))  ? $_GET['limit']  : 10;
		$offset = (isset($_GET['offset'])) ? $_GET['offset'] : 0;
		$sort   = (isset($_GET['sort']))   ? $_GET['sort']   : '';
		$order  = (isset($_GET['order']))  ? $_GET['order']  : "asc";
		$search = (isset($_GET['search'])) ? $_GET['search'] : "";
		#################################################################################
		#################################################################################
		if ($search == "")
		{
			$customers = $this->log_model->order_by($sort, $order)->get( array('usuario_id'=>$this->session->dados_usuario->id) );
		}
		else
		{
			if( $_GET['like_search'] == 'all' )
			{
				$campos = $this->db->query('DESC '.$this->log_model->order_by($sort, $order)->_table)->result();
				foreach ($campos as $campo)
				{
					$arraySearch[$campo->Field] = "".$search."";
				}
			}
			else
			{
				$campos = explode('|', $_GET['like_search']);
				foreach ($campos as $campo)
				{
					$arraySearch[$campo] = "".$search."";
				}
			}
			$customers = $this->log_model->order_by($sort, $order)->like($arraySearch)->get(array('usuario_id'=>$this->session->dados_usuario->id));
		}
		#################################################################################
		#################################################################################
		$count = sizeof($customers);
		$customers = array_slice($customers, $offset, $limit);

		echo "{";
			echo '"total": ' . $count . ',';
			echo '"rows": ';
			echo json_encode($customers);
		echo "}";
	}
}
/* End of file Logs.php */
/* Location: ./application/controllers/Logs.php */