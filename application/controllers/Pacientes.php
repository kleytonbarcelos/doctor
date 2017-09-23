<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Pacientes extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('paciente_model');
		}
		public function index()
		{
			$this->template->load('AdminLTE/index', 'pacientes/index');
		}
		public function cadastrar()
		{
			$data['dados'] = (object) $this->paciente_model->desc_table(); //Preenche as variáveis com valores em branco
			$this->template->load('AdminLTE/index', 'pacientes/formulario', $data);
		}
		public function editar($id)
		{
			$data['dados'] = $this->paciente_model->get_by('MD5(id)', $id);
			if($data['dados'])
			{
				$this->template->load('AdminLTE/index', 'pacientes/formulario', $data);
			}
			else
			{
				redirect('home','refresh');
			}
		}
		public function visualizar($id)
		{
			$data['dados'] = $this->paciente_model->get_by('MD5(id)', $id);
			if($data['dados'])
			{
				grava_log($this->base_url_controller, 'Visualizou (pacientes) registro ID:'.$data['dados']->id);
				$this->template->load('AdminLTE/index', 'pacientes/visualizar', $data);
			}
			else
			{
				redirect('home','refresh');
			}
		}
		public function salvar()
		{
			$this->form_validation->set_rules('txtNome', strong('Nome'), 'required');
			$this->form_validation->set_rules('txtDataNascimento', strong('Data nascimento'), 'required');
			$this->form_validation->set_rules('txtSexo', strong('Sexo'), 'required');
			$this->form_validation->set_rules('txtCelular', strong('Celular'), 'required');

			if( $this->form_validation->run() == true )
			{
				$data = array(
						'nome'=>$this->input->post('txtNome'),
						'datanascimento'=>$this->input->post('txtDataNascimento'),
						'sexo'=>$this->input->post('txtSexo'),
						'email'=>$this->input->post('txtEmail'),
						'cpf'=>$this->input->post('txtCpf'),
						'rg'=>$this->input->post('txtRg'),
						'celular'=>$this->input->post('txtCelular'),
						'telefone'=>$this->input->post('txtTelefone'),
						'telefonetrabalho'=>$this->input->post('txtTelefoneTrabalho'),
						'sms'=>$this->input->post('txtSms'),
						'cep'=>$this->input->post('txtCep'),
						'endereco'=>$this->input->post('txtEndereco'),
						'numero'=>$this->input->post('txtNumero'),
						'complemento'=>$this->input->post('txtComplemento'),
						'bairro'=>$this->input->post('txtBairro'),
						'cidade'=>$this->input->post('txtCidade'),
						'uf'=>$this->input->post('txtUf'),
						'naturalidade'=>$this->input->post('txtNaturalidade'),
						'ufnaturalidade'=>$this->input->post('txtUfNaturalidade'),
						'estadocivil'=>$this->input->post('txtEstadoCivil'),
						'religiao'=>$this->input->post('txtReligiao'),
						'profissao'=>$this->input->post('txtProfissao'),
						'escolaridade'=>$this->input->post('txtEscolaridade'),
						'cns'=>$this->input->post('txtCns'),
						'obs'=>$this->input->post('txtObs'),
						'convenio'=>$this->input->post('txtConvenio'),
						'planoconvenio'=>$this->input->post('txtPlanoConvenio'),
						'carteiraconvenio'=>$this->input->post('txtCarteiraConvenio'),
						'validadeconvenio'=>$this->input->post('txtValidadeConvenio'),
						'acomodacaoconvenio'=>$this->input->post('txtAcomodacaoConvenio'),
				);

				if(!$this->input->post('id'))
				{
					$insert_id = $this->paciente_model->insert($data);
					grava_log($this->base_url_controller, 'Cadastrou (pacientes) registro ID:'.$insert_id);
					$response['action'] = 'insert';
					$response['status'] = 1;
					$response['msg'] = 'Registro adicionado com sucesso!';
				}
				else
				{
					$this->paciente_model->update($this->input->post('id'), $data);
					grava_log($this->base_url_controller, 'Atualizou (pacientes) registro ID:'.$this->input->post('id'));
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
				$return = $this->paciente_model->delete($value);
				grava_log($this->base_url_controller, 'Excluiu (pacientes) registro ID:'.$value);
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
				$data['paciente'] = $this->paciente_model->select('id, nome, sexo, celular, telefone, email')->get($this->input->post('id'));
			}
			else
			{
				$data['dados'] = $this->paciente_model->select('id, nome, sexo, celular, telefone, email')->get($this->input->post('id'));
			}
			echo json_encode($data);
		}
		public function getvaluesinputs()
		{
			$data['inputs'] = $this->paciente_model->get($this->input->post('id'));
			foreach ($data['inputs'] as $key => $value)
			{
				$data_temp[sha1($this->paciente_model->table().'.'.$key)] = $value;
			}
			$data['inputs'] = $data_temp;
			echo json_encode($data);
		}
		public function typeahead($id=null)
		{
			if($id)
			{
				$data['dados'] = $this->paciente_model->get($id);
			}
			else
			{
				$search = array(
					'nome'=>$this->input->post('query'),
				);
				$data['dados'] = $this->paciente_model->like($search)->get();
			}
			$data['status'] = ($data['dados']) ? 1 : 0;
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
				$customers = $this->paciente_model->order_by($sort, $order)->get();
			}
			else
			{
				if( $_GET['like_search'] == 'all' )
				{
					$campos = $this->db->query('DESC '.$this->paciente_model->order_by($sort, $order)->_table)->result();
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
				$customers = $this->paciente_model->order_by($sort, $order)->like($arraySearch)->get();
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
	/* End of file Pacientes.php */
	/* Location: ./application/controllers/Pacientes.php */