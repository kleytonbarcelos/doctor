<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bulas extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Bula');
	}

	public function index()
	{
		$data['Bulas'] = $this->Bula->limit(10)->get();
		$this->template->load('AdminLTE/index', 'bulas/index', $data);
	}
	public function bootstrap_table()
	{
		$limit  = (isset($_GET['limit']))  ? $_GET['limit']  : 10;
		$offset = (isset($_GET['offset'])) ? $_GET['offset'] : 0;
		$sort   = (isset($_GET['sort']))   ? $_GET['sort']   : '';
		$order  = (isset($_GET['order']))  ? $_GET['order']  : "asc";
		$search = (isset($_GET['search'])) ? $_GET['search'] : "";

		$customers = array();
		if ($search == "")
		{
			$customers = $this->Bula->order_by($sort, $order)->get();
		}
		else
		{
			if( $_GET['like_search'] == 'all' )
			{
				$campos = $this->db->query('DESC '.$this->Bula->order_by($sort, $order)->_table)->result();
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
			$customers = $this->Bula->order_by($sort, $order)->like($arraySearch)->get();
		}
		
		$count = sizeof($customers);
		$customers = array_slice($customers, $offset, $limit);

		echo "{";
			echo '"total": ' . $count . ',';
			echo '"rows": ';
			echo json_encode($customers);
		echo "}";
	}
}
/* End of file Bulas.php */
/* Location: ./application/controllers/Bulas.php */