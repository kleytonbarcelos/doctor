<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tiss extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('tiss_model');
	}
	public function index()
	{
		$this->template->load('AdminLTE/index', 'tiss/index');
	}
	public function cadastrar()
	{
		$data['dados'] = (object) $this->tiss_model->desc_table(); //Preenche as variáveis com valores em branco
		$this->template->load('AdminLTE/index', 'tiss/formulario', $data);
	}
	public function editar($id)
	{
		$data['dados'] = $this->tiss_model->get($id);
		$this->template->load('AdminLTE/index', 'tiss/formulario', $data);
	}
	public function salvar()
	{
		$this->form_validation->set_rules('registroans_id', strong('Registro ANS'), 'trim|required');
		$this->form_validation->set_rules('txtNumeroGuias', strong('Número Guias'), 'trim|required');
		$this->form_validation->set_rules('txtNumeroCartao', strong('Número Cartao'), 'trim|required');
		$this->form_validation->set_rules('txtNome', strong('Nome Paciente'), 'trim|required');
		$this->form_validation->set_rules('txtTipoDocumentoPrestador', strong('Tipo Documento Prestador'), 'trim|required');
		$this->form_validation->set_rules('txtCodigoCnes', strong('Código Cnes'), 'trim|required');
		$this->form_validation->set_rules('txtUfExecutor', strong('Uf Executor'), 'trim|required');
		$this->form_validation->set_rules('txtDataConsulta', strong('Data Consulta'), 'trim|required');
		$this->form_validation->set_rules('txtTipoConsulta', strong('Tipo Consulta'), 'trim|required');
		$this->form_validation->set_rules('txtValorProcedimento', strong('Valor Procedimento'), 'trim|required');
		// $this->form_validation->set_rules('paciente_id', strong('Paciente'), 'trim|required');
		// $this->form_validation->set_rules('txtNumeroGuiasOperadora', strong('Número Guias Operadora'), 'trim|required');
		// $this->form_validation->set_rules('txtValidadeCarteira', strong('Validade Carteira'), 'trim|required');
		// $this->form_validation->set_rules('txtNumeroCns', strong('Número Cns'), 'trim|required');
		// $this->form_validation->set_rules('txtDocumentoPrestador', strong('Documento Prestador'), 'trim|required');
		// $this->form_validation->set_rules('txtNomePrestador', strong('Nome Prestador'), 'trim|required');
		// $this->form_validation->set_rules('txtNomeExecutor', strong('Nome Executor'), 'trim|required');
		// $this->form_validation->set_rules('txtConselho', strong('Conselho'), 'trim|required');
		// $this->form_validation->set_rules('txtNumeroConselho', strong('Número Conselho'), 'trim|required');
		// $this->form_validation->set_rules('txtCbos', strong('Cbos'), 'trim|required');
		// $this->form_validation->set_rules('txtIndicacaoAcidente', strong('Indicação Acidente'), 'trim|required');
		// $this->form_validation->set_rules('txtCodigoTabela', strong('Código Tabela'), 'trim|required');
		// $this->form_validation->set_rules('codigoprocedimento_id', strong('Código Procedimento'), 'trim|required');
		// $this->form_validation->set_rules('txtObservacao', strong('Observação'), 'trim|required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
					'usuario_id'=>$this->session->dados_usuario->id,
					'paciente_id'=>$this->input->post('paciente_id'),
					'registroans_id'=>$this->input->post('registroans_id'),
					'numeroguias'=>$this->input->post('txtNumeroGuias'),
					'numeroguiasoperadora'=>$this->input->post('txtNumeroGuiasOperadora'),
					'numerocartao'=>$this->input->post('txtNumeroCartao'),
					'validadecarteira'=>date_to_us($this->input->post('txtValidadeCarteira')),
					'recemnascido'=>$this->input->post('txtRecemNascido'),
					'nomepaciente'=>$this->input->post('txtNome'),
					'numerocns'=>$this->input->post('txtNumeroCns'),
					'tipodocumentoprestador'=>$this->input->post('txtTipoDocumentoPrestador'),
					'documentoprestador'=>$this->input->post('txtDocumentoPrestador'),
					'nomeprestador'=>$this->input->post('txtNomePrestador'),
					'codigocnes'=>$this->input->post('txtCodigoCnes'),
					'nomeexecutor'=>$this->input->post('txtNomeExecutor'),
					'conselho_id'=>$this->input->post('txtConselho'),
					'numeroconselho'=>$this->input->post('txtNumeroConselho'),
					'ufexecutor'=>$this->input->post('txtUfExecutor'),
					'cbo_id'=>$this->input->post('txtCbos'),
					'indicacaoacidente_id'=>$this->input->post('txtIndicacaoAcidente'),
					'dataconsulta'=>date_to_us($this->input->post('txtDataConsulta')),
					'tipoconsulta_id'=>$this->input->post('txtTipoConsulta'),
					'codigotabela_id'=>$this->input->post('txtCodigoTabela'),
					'codigoprocedimento_id'=>$this->input->post('codigoprocedimento_id'),
					'valorprocedimento'=>br_to_decimal($this->input->post('txtValorProcedimento')),
					'observacoes'=>$this->input->post('txtObservacao'),
				);

			if(!$this->input->post('id'))
			{
				$tiss_id = $this->tiss_model->insert($data);
				$response['acao'] = 'cadastrar';
				$response['status'] = 1;
				$response['msg'] = 'Registro adicionado com sucesso!';
			}
			else
			{
				$this->tiss_model->update($this->input->post('id'), $data);
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
			$return = $this->tiss_model->delete($value);
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
		$data['tiss'] = $this->tiss_model->select('id, nome, texto')->get($this->input->post('id'));
		echo json_encode($data);
	}
	public function registrosans()
	{
		$this->load->model('registroans_model');
		$data['registrosans'] = $this->registroans_model->get();
		echo json_encode($data);
	}
	//##############################################################################################
	//##############################################################################################
	//##############################################################################################
	public function tiss_conselhos($id=null)
	{
		$this->load->model('tissconselho_model');
		$data['tiss_conselhos'] = $this->tissconselho_model->select('id, nome, descricao')->get($id);
		echo json_encode($data);
	}
	public function tiss_cbos($id=null)
	{
		$this->load->model('tisscbo_model');
		$data['tiss_cbos'] = $this->tisscbo_model->select('id, codigo, nome')->get($id);
		echo json_encode($data);
	}
	public function tiss_tipoconsultas($id=null)
	{
		$this->load->model('tisstipoconsulta_model');
		$data['tiss_tipoconsultas'] = $this->tisstipoconsulta_model->select('id, codigo, nome')->get($id);
		echo json_encode($data);
	}
	public function tiss_indicacaoacidentes($id=null)
	{
		$this->load->model('tissindicacaoacidente_model');
		$data['tiss_indicacaoacidentes'] = $this->tissindicacaoacidente_model->select('id, codigo, nome')->get($id);
		echo json_encode($data);
	}
	public function tiss_codigotabelas($id=null)
	{
		$this->load->model('tisscodigotabela_model');
		$data['tiss_codigotabelas'] = $this->tisscodigotabela_model->select('id, codigo, nome')->get($id);
		echo json_encode($data);
	}
	public function tiss_codigoprocedimentos($id=null)
	{
		$this->load->model('tisscodigoprocedimento_model');
		$data['tiss_codigoprocedimentos'] = $this->tisscodigoprocedimento_model->select('id, codigo, nome')->get($id);
		echo json_encode($data);
	}
	public function typeahead_codigoprocedimentos($id=null)
	{
		$this->load->model('tisscodigoprocedimento_model');
		if($id)
		{
			$data['dados'] = $this->tisscodigoprocedimento_model->get($id);
		}
		else
		{
			$search = array(
				'codigo'=>$this->input->post('query'),
				'nome'=>$this->input->post('query'),
			);
			$data['dados'] = $this->tisscodigoprocedimento_model->like($search)->get();
		}
		$data['status'] = ($data['dados']) ? 1 : 0;
		echo json_encode($data);
	}	
	public function typeahead_registrosans($id=null)
	{
		$this->load->model('registroans_model');

		if($id)
		{
			$data['dados'] = $this->registroans_model->get($id);
		}
		else
		{
			$this->load->model('registroans_model');
			$search = array(
				'registroans'=>$this->input->post('query'),
				'razaosocial'=>$this->input->post('query'),
				'nomefantasia'=>$this->input->post('query'),
				'cnpj'=>$this->input->post('query'),
			);
			$data['dados'] = $this->registroans_model->like($search)->get();
		}
		$data['status'] = ($data['dados']) ? 1 : 0;
		echo json_encode($data);
	}
	public function typeahead()
	{
		$data['Tiss'] = $this->tiss_model->like( array('nome'=>$this->input->post('query')) )->get();
		$data['status'] = ($data['Tiss']) ? 1 : 0;
		echo json_encode($data);
	}
	//##############################################################################################
	//##############################################################################################
	//##############################################################################################
	public function Tiss()
	{
		$data['tiss'] = $this->tiss_model->select('id, nome')->get();
		echo json_encode($data);
	}
	public function getvaluesinputs()
	{
		$data['inputs'] = $this->tiss_model->get($this->input->post('id'));
		foreach ($data['inputs'] as $key => $value)
		{
			$data_temp[sha1($this->tiss_model->table().'.'.$key)] = $value;
		}
		$data['inputs'] = $data_temp;
		echo json_encode($data);
	}
	public function verifica_alias()
	{
		$data['alias'] = $this->tiss_model->get( array('alias'=>$this->input->post('url')) );
		$data['status'] = ($data['url']) ? 1 : 0;
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
			$customers = $this->tiss_model->order_by($sort, $order)->get( array('usuario_id'=>$this->session->dados_usuario->id) );
		}
		else
		{
			if( $_GET['like_search'] == 'all' )
			{
				$campos = $this->db->query('DESC '.$this->tiss_model->order_by($sort, $order)->_table)->result();
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
			$customers = $this->tiss_model->order_by($sort, $order)->like($arraySearch)->get(array('usuario_id'=>$this->session->dados_usuario->id));
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
/* End of file Tiss.php */
/* Location: ./application/controllers/Tiss.php */