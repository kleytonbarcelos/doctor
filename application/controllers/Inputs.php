<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inputs extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('inputs_model');
	}
	public function index()
	{
		$data['Inputs'] = $this->inputs_model->limit(10)->get();
		$this->template->load('AdminLTE/index', 'Inputs/index', $data);
	}
	public function get()
	{
		$data['inputs'] = $this->inputs_model->get($this->input->post('id'));
		echo json_encode($data);
	}
	public function Inputs()
	{
		$data['Inputs'] = $this->inputs_model->get();
		echo json_encode($data);
	}
	public function getvaluesinputs()
	{
		$data['inputs'] = $this->inputs_model->get($this->input->post('id'));
		foreach ($data['inputs'] as $key => $value)
		{
			$data_temp[sha1($key)] = $value;
		}
		$data['inputs'] = $data_temp;
		echo json_encode($data);
	}
	public function typeahead()
	{
		$data['Inputs'] = $this->inputs_model->like( array('nome'=>$this->input->post('query')) )->get();
		$data['status'] = ($data['Inputs']) ? 1 : 0;
		echo json_encode($data);
	}
	public function salvar()
	{
		$this->form_validation->set_rules('txtName', strong('Name'), 'required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
					'inputs'=>$this->input->post('txtInputs'),
				);

			if(!$this->input->post('id'))
			{
				$this->inputs_model->insert($data);

				$response['status'] = 1;
				$response['msg'] = 'Registro adicionado com sucesso!';
			}
			else
			{
				$this->inputs_model->update($this->input->post('id'), $data);

				$response['status'] = 1;
				$response['msg'] = 'Registro atualizado com sucesso!';
			}
			echo json_encode($response);
		}
		else
		{
			$erros = array();
			foreach ($this->input->post() as $key => $value)
			{
				$erros[$key] = form_error($key);
			}
			$response['erros'] = array_filter($erros);
			$response['status'] = 0;
			echo json_encode($response);
		}
	}
	public function excluir()
	{
		$ids = explode(',', $this->input->post('id'));
		foreach ($ids as $key => $value)
		{
			$return = $this->inputs_model->delete($value);
		}
		if($return)
		{
			$response['status'] = 1;
			$response['msg'] = 'Registro(s) excluído(s) com sucesso!';
		}
		else
		{
			$response['status'] = 0;
			$response['msg'] = 'Erro ocorrido na operação!';
		}
		echo json_encode($response);
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
			$customers = $this->inputs_model->order_by($sort, $order)->get();
		}
		else
		{
			if( $_GET['like_search'] == 'all' )
			{
				$campos = $this->db->query('DESC '.$this->inputs_model->order_by($sort, $order)->_table)->result();
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
			$customers = $this->inputs_model->order_by($sort, $order)->like($arraySearch)->get();
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
/* End of file Inputs.php */
/* Location: ./application/controllers/Inputs.php */