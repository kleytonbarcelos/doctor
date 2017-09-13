<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Setup extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function index()
		{
			//$this->template->load('AdminLTE/index', 'home/home');
			$this->load->view('setup/index');
		}
		public function salvar()
		{
			$this->load->model('usuario_model');
			$this->load->model('clinica_model');
			$this->load->model('clinicausuario_model');

			$this->form_validation->set_rules('txtNome', strong('Nome'), 'trim|required');
			$this->form_validation->set_rules('txtEspecialidade', strong('Especialidade'), 'trim|required');

			if( $this->form_validation->run() == true )
			{
				$data = array(
						'nome'=>$this->input->post('txtNomeClinica'),
						'telefone'=>$this->input->post('txtTelefone'),
						'numeroprofissionaissaude'=>$this->input->post('txtProfissionaisDeSaude'),
				);
				$clinica_id = $this->clinica_model->insert($data);
				//##################################################################
				$data = null;
				$data = array(
						'pronome'=>$this->input->post('txtPronome'),
						'nome'=>$this->input->post('txtNome'),
						'profissao_id'=>$this->input->post('txtProfissao'),
						'especialidade_id'=>$this->input->post('txtEspecialidade'),
						'conselho_id'=>$this->input->post('txtConselho'),
						'numeroconselho'=>$this->input->post('txtNumeroConselho'),
						'celular'=>$this->input->post('txtCelular'),
						'status'=>'cadastrocompleto',
				);
				$this->usuario_model->update($this->input->post('usuario_id'), $data);
				//##################################################################
				$data = null;
				$data = array(
					'clinica_id'=>$clinica_id,
					'usuario_id'=>$this->input->post('usuario_id'),
				);
				$this->clinicausuario_model->insert($data);
				//##################################################################
				$response['status'] = 1;
				$response['msg'] = 'Registro cadastrado com sucesso!';

				$this->session->dados_usuario->status = 'cadastrocompleto';

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
		public function pronomes()
		{
			$this->load->model('pronome_model');
			$data['pronomes'] = $this->pronome_model->select('id, nome')->get();
			echo json_encode($data);
		}
		public function profissoes()
		{
			$this->load->model('profissao_model');
			$data['profissoes'] = $this->profissao_model->select('id, nome')->get();
			echo json_encode($data);
		}
		// public function especialidades()
		// {
		// 	$this->load->model('especialidade_model');
		// 	$data['especialidades'] = $this->especialidade_model->select('id, nome')->get();
		// 	echo json_encode($data);
		// }
		// public function conselhos()
		// {
		// 	$this->load->model('conselho_model');
		// 	$data['conselhos'] = $this->conselho_model->select('id, nome')->get();
		// 	echo json_encode($data);
		// }
	}