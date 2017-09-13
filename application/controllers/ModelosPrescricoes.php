<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelosPrescricoes extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('modeloprescricao_model');
		$this->load->model('modeloprescricaoregistro_model');
	}
	public function index()
	{
		$this->template->load('AdminLTE/index', 'modelosprescricoes/index');
	}
	public function cadastrar()
	{
		$data['dados'] = (object) $this->modeloprescricao_model->desc_table(); //Preenche as variáveis com valores em branco
		$data['dados_registros'] = '';
		$this->template->load('AdminLTE/index', 'modelosprescricoes/formulario', $data);
	}
	public function editar($id)
	{
		$data['dados'] = $this->modeloprescricao_model->get($id);
		$data['dados_registros'] = $this->modeloprescricaoregistro_model->get( array('modelos_prescricoes_id'=>$id) );
		$this->template->load('AdminLTE/index', 'modelosprescricoes/formulario', $data);
	}
	public function visualizar($id)
	{
		$data['dados'] = $this->modeloprescricao_model->get($id);
		$this->template->load('AdminLTE/index', 'modelosprescricoes/visualizar', $data);
	}
	public function salvar()
	{
		$this->form_validation->set_rules('txtNome', strong('Nome'), 'trim|required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
					'usuario_id'=>$this->session->dados_usuario->id,
					'nome'=>$this->input->post('txtNome'),
				);
			if(!$this->input->post('id'))
			{
				$modeloprescricao_id = $this->modeloprescricao_model->insert($data);
				$data = null;

				if( sizeof($this->input->post('txtMedicamento')) > 0 )
				{
					$medicamentos = $this->input->post('txtMedicamento');
					$quantidades = $this->input->post('txtQuantidade');
					$posologias = $this->input->post('txtPosologia');
					for ($i=0; $i<sizeof($medicamentos); $i++)
					{
						$data[] = array(
							'modelos_prescricoes_id'=>$modeloprescricao_id,
							'medicamento'=>$medicamentos[$i],
							'quantidade'=>$quantidades[$i],
							'posologia'=>$posologias[$i],
						);
					}
					$this->modeloprescricaoregistro_model->insert_many($data);
				}

				$response['acao'] = 'cadastrar';
				$response['status'] = 1;
				$response['msg'] = 'Registro adicionado com sucesso!';
			}
			else
			{
				$this->modeloprescricao_model->update($this->input->post('id'), $data);
				$data = null;

				$this->modeloprescricaoregistro_model->delete_by( array('modelos_prescricoes_id'=>$this->input->post('id')) );
				if( sizeof($this->input->post('txtMedicamento')) > 0 )
				{

					$medicamentos = $this->input->post('txtMedicamento');
					$quantidades = $this->input->post('txtQuantidade');
					$posologias = $this->input->post('txtPosologia');
					for ($i=0; $i<sizeof($medicamentos); $i++)
					{
						$data[] = array(
							'modelos_prescricoes_id'=>$this->input->post('id'),
							'medicamento'=>$medicamentos[$i],
							'quantidade'=>$quantidades[$i],
							'posologia'=>$posologias[$i],
						);
					}
					$this->modeloprescricaoregistro_model->insert_many($data);
				}

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
			$return = $this->modeloprescricao_model->delete($value);
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
		$data['dados'] = $this->modeloprescricao_model->get($this->input->post('id'));
		echo json_encode($data);
	}
	public function ModelosPrescricoes()
	{
		$data['modelosprescricoes'] = $this->modeloprescricao_model->get( array('usuario_id'=>$this->session->dados_usuario->id) );
		echo json_encode($data);
	}
	public function modelosprescricoesregistros()
	{
		$data['modelosprescricoesregistros'] = $this->modeloprescricaoregistro_model->select('medicamento, posologia, quantidade')->get( array('modelos_prescricoes_id'=>$this->input->post('id')) );
		echo json_encode($data);
	}
	public function getvaluesinputs()
	{
		$data['inputs'] = $this->modeloprescricao_model->get($this->input->post('id'));
		foreach ($data['inputs'] as $key => $value)
		{
			$data_temp[sha1($this->modeloprescricao_model->table().'.'.$key)] = $value;
		}
		$data['inputs'] = $data_temp;
		echo json_encode($data);
	}
	public function verifica_alias()
	{
		$data['alias'] = $this->modeloprescricao_model->get( array('alias'=>$this->input->post('url')) );
		$data['status'] = ($data['url']) ? 1 : 0;
		echo json_encode($data);
	}
	public function typeahead()
	{
		$data['ModelosPrescricoes'] = $this->modeloprescricao_model->like( array('nome'=>$this->input->post('query')) )->get();
		$data['status'] = ($data['ModelosPrescricoes']) ? 1 : 0;
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
			$customers = $this->modeloprescricao_model->order_by($sort, $order)->get( array('usuario_id'=>$this->session->dados_usuario->id) );
		}
		else
		{
			if( $_GET['like_search'] == 'all' )
			{
				$campos = $this->db->query('DESC '.$this->modeloprescricao_model->order_by($sort, $order)->_table)->result();
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
			$customers = $this->modeloprescricao_model->order_by($sort, $order)->like($arraySearch)->get(array('usuario_id'=>$this->session->dados_usuario->id));
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
/* End of file ModelosPrescricoes.php */
/* Location: ./application/controllers/ModelosPrescricoes.php */