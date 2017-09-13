<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cartasatestados extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cartaatestado_model');
	}
	public function index()
	{
		$this->template->load('AdminLTE/index', 'cartasatestados/index');
	}
	public function cadastrar()
	{
		$data['dados'] = (object) $this->cartaatestado_model->desc_table(); //Preenche as variáveis com valores em branco
		$this->template->load('AdminLTE/index', 'cartasatestados/formulario', $data);
	}
	public function editar($id)
	{
		$data['dados'] = $this->cartaatestado_model->get($id);
		$this->template->load('AdminLTE/index', 'cartasatestados/formulario', $data);
	}
	public function salvar()
	{
		$this->form_validation->set_rules('txtNome', strong('Nome'), 'trim|required');
		$this->form_validation->set_rules('txtTexto', strong('Texto'), 'trim|required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
					'usuario_id'=>$this->session->dados_usuario->id,
					'nome'=>$this->input->post('txtNome'),
					'texto'=>$this->input->post('txtTexto'),
				);

			if(!$this->input->post('id'))
			{
				$cartaatestado_id = $this->cartaatestado_model->insert($data);
				$response['acao'] = 'cadastrar';
				$response['status'] = 1;
				$response['msg'] = 'Registro adicionado com sucesso!';
			}
			else
			{
				$this->cartaatestado_model->update($this->input->post('id'), $data);
				$response['acao'] = 'editar';
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
			$return = $this->cartaatestado_model->delete($value);
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
		$data['cartaatestado'] = $this->cartaatestado_model->select('id, nome, texto')->get($this->input->post('id'));
		echo json_encode($data);
	}
	public function Cartasatestados()
	{
		$data['cartasatestados'] = $this->cartaatestado_model->select('id, nome')->get( array('tipo'=>'modelo') );
		echo json_encode($data);
	}
	public function getvaluesinputs()
	{
		$data['inputs'] = $this->cartaatestado_model->get($this->input->post('id'));
		foreach ($data['inputs'] as $key => $value)
		{
			$data_temp[sha1($this->cartaatestado_model->table().'.'.$key)] = $value;
		}
		$data['inputs'] = $data_temp;
		echo json_encode($data);
	}
	public function typeahead()
	{
		$data['Cartasatestados'] = $this->cartaatestado_model->like( array('nome'=>$this->input->post('query')) )->get();
		$data['status'] = ($data['Cartasatestados']) ? 1 : 0;
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
			$customers = $this->cartaatestado_model->order_by($sort, $order)->get( array('usuario_id'=>$this->session->dados_usuario->id) );
		}
		else
		{
			if( $_GET['like_search'] == 'all' )
			{
				$campos = $this->db->query('DESC '.$this->cartaatestado_model->order_by($sort, $order)->_table)->result();
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
			$customers = $this->cartaatestado_model->order_by($sort, $order)->like($arraySearch)->get(array('usuario_id'=>$this->session->dados_usuario->id));
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
/* End of file Cartasatestados.php */
/* Location: ./application/controllers/Cartasatestados.php */