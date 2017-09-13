<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('grupo_model');
	}
	public function index()
	{
		$this->template->load('AdminLTE/index', 'grupos/index');
	}
	public function cadastrar()
	{
		$data['dados'] = (object) $this->grupo_model->desc_table(); //Preenche as variáveis com valores em branco
		$this->template->load('AdminLTE/index', 'grupos/formulario', $data);
	}
	public function editar($id)
	{
		$data['dados'] = $this->grupo_model->get_by('MD5(id)', $id);
		if($data['dados'])
		{
			$this->template->load('AdminLTE/index', 'grupos/formulario', $data);
		}
		else
		{
			redirect('home','refresh');
		}
	}
	public function visualizar($id)
	{
		$data['dados'] = $this->grupo_model->get_by('MD5(id)', $id);
		if($data['dados'])
		{
			grava_log($this->base_url_controller, 'Visualizou (grupos) registro ID:'.$data['dados']->id);
			$this->template->load('AdminLTE/index', 'grupos/visualizar', $data);
		}
		else
		{
			redirect('home','refresh');
		}
	}
	public function salvar()
	{
		$this->form_validation->set_rules('txtNome', strong('Nome'), 'trim|required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
				'nome'=>$this->input->post('txtNome'),
			);

			if(!$this->input->post('id'))
			{
				$insert_id = $this->grupo_model->insert($data);
				grava_log($this->base_url_controller, 'Cadastrou (grupos) registro ID:'.$insert_id);
				$response['action'] = 'insert';
				$response['status'] = 1;
				$response['msg'] = 'Registro adicionado com sucesso!';
			}
			else
			{
				$this->grupo_model->update($this->input->post('id'), $data);
				grava_log($this->base_url_controller, 'Atualizou (grupos) registro ID:'.$this->input->post('id'));
				$response['action'] = 'update';
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
			$return = $this->grupo_model->delete($value);
			grava_log($this->base_url_controller, 'Excluiu (grupos) registro ID:'.$value);
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
	public function get()
	{
		if( $this->input->post('id') )
		{
			$data['grupo'] = $this->grupo_model->select('id, nome')->get($this->input->post('id'));
		}
		else
		{
			$data['dados'] = $this->grupo_model->select('id, nome')->get();
		}
		echo json_encode($data);
	}
	public function getvaluesinputs()
	{
		$data['inputs'] = $this->grupo_model->get($this->input->post('id'));
		foreach ($data['inputs'] as $key => $value)
		{
			$data_temp[sha1($this->grupo_model->table().'.'.$key)] = $value;
		}
		$data['inputs'] = $data_temp;
		echo json_encode($data);
	}
	public function typeahead()
	{
		$data['Grupos'] = $this->grupo_model->like( array('nome'=>$this->input->post('query')) )->get();
		$data['status'] = ($data['Grupos']) ? 1 : 0;
		echo json_encode($data);
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
			$customers = $this->grupo_model->order_by($sort, $order)->get();
		}
		else
		{
			if( $_GET['like_search'] == 'all' )
			{
				$campos = $this->db->query('DESC '.$this->grupo_model->order_by($sort, $order)->_table)->result();
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
			$customers = $this->grupo_model->order_by($sort, $order)->like($arraySearch)->get();
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
/* End of file Grupos.php */
/* Location: ./application/controllers/Grupos.php */