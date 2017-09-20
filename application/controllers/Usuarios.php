<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');
	}
	public function cadastro()
	{
		$this->load->view('usuarios/cadastro');
	}
	public function index()
	{
		$this->template->load('adminlte/index', 'usuarios/index');
	}
	public function visualizar($id)
	{
		$data['dados'] = $this->usuario_model->get($id);
		$this->template->load('adminlte/index', 'usuarios/visualizar', $data);
	}
	public function cadastrar()
	{
		$data['dados'] = (object) $this->usuario_model->desc_table(); //Preenche as variáveis com valores em branco
		$this->template->load('adminlte/index', 'usuarios/formulario', $data);
	}
	public function editar($id)
	{
		$data['dados'] = $this->usuario_model->get($id);
		$this->template->load('adminlte/index', 'usuarios/formulario', $data);
	}
	public function salvar()
	{
		$this->form_validation->set_rules('txtNome', strong('Nome'), 'trim|required');
		$this->form_validation->set_rules('txtTipo', strong('Tipo'), 'trim|required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
					//'usuario_id'=>$this->session->dados_usuario->id,
					'nome'=>$this->input->post('txtNome'),
					'email'=>$this->input->post('txtEmail'),
					'senha'=>$this->input->post('txtSenha'),
					'tipo'=>$this->input->post('txtTipo'),
				);

			if(!$this->input->post('id'))
			{
				$this->usuario_model->insert($data);

				$response['status'] = 1;
				$response['msg'] = 'Registro adicionado com sucesso!';
			}
			else
			{
				$this->usuario_model->update($this->input->post('id'), $data);

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
			$return = $this->usuario_model->delete($value);
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
		$data['usuario'] = $this->usuario_model->select('id, nome')->get($this->input->post('id'));
		echo json_encode($data);
	}
	public function Usuarios()
	{
		$data['dados'] = $this->usuario_model->select('id, nome')->get();
		echo json_encode($data);
	}
	public function getvaluesinputs()
	{
		$data['inputs'] = $this->usuario_model->get($this->input->post('id'));
		foreach ($data['inputs'] as $key => $value)
		{
			$data_temp[sha1($this->usuario_model->table().'.'.$key)] = $value;
		}
		$data['inputs'] = $data_temp;
		echo json_encode($data);
	}
	public function verifica_alias()
	{
		$data['alias'] = $this->usuario_model->get( array('alias'=>$this->input->post('url')) );
		$data['status'] = ($data['url']) ? 1 : 0;
		echo json_encode($data);
	}
	public function typeahead()
	{
		$data['Usuarios'] = $this->usuario_model->like( array('nome'=>$this->input->post('query')) )->get();
		$data['status'] = ($data['Usuarios']) ? 1 : 0;
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
			$customers = $this->usuario_model->order_by($sort, $order)->get();
		}
		else
		{
			if( $_GET['like_search'] == 'all' )
			{
				$campos = $this->db->query('DESC '.$this->usuario_model->order_by($sort, $order)->_table)->result();
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
			$customers = $this->usuario_model->order_by($sort, $order)->like($arraySearch)->get();
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
/* End of file Usuarios.php */
/* Location: ./application/controllers/Usuarios.php */