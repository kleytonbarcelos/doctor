<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Login extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('usuario_model');
		}
		//#######################################################
		public function index()
		{
			$this->load->view('login/login');
		}
		public function sempermissao()
		{
			$this->load->view('login/sempermissao');
		}
		public function verifica()
		{
			$this->form_validation->set_rules('txtUsuario', str_to_strong('Usuario'), 'trim|required');
			$this->form_validation->set_rules('txtSenha', str_to_strong('Senha'), 'trim|required');

			if( $this->form_validation->run() == true )
			{
				$login = $this->usuario_model->verifica_login($this->input->post('txtUsuario'), $this->input->post('txtSenha'));
				grava_log($this->base_url_controller, 'Logou no sistema');
				if($login)
				{
					$response['usuario_status'] = $this->session->dados_usuario->status;
					$response['url_redirect'] = $this->session->url_redirect;
					$response['status'] = 1;
				}
				else
				{
					$response['msg'] = str_to_strong('Usuário').' ou '.str_to_strong('Senha').' estão incorretos';
					$response['status'] = 0;
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
		// public function verifica()
		// {
		// 	$this->form_validation->set_rules('txtUsuario', str_to_strong('Usuario'), 'required');
		// 	$this->form_validation->set_rules('txtSenha', str_to_strong('Senha'), 'required');

		// 	if( $this->form_validation->run() == true )
		// 	{
		// 		$login = $this->usuario_model->verifica_login($this->input->post('txtUsuario'), $this->input->post('txtSenha'));
		// 		if($login)
		// 		{
		// 			redirect($this->session->url_redirect,'refresh');
		// 		}
		// 		else
		// 		{
		// 			$this->session->set_flashdata('msg', alert_danger( str_to_strong('Usuário').' ou '.str_to_strong('Senha').' estão incorretos' ) );
		// 			$this->index();
		// 		}
		// 	}
		// 	else
		// 	{
		// 		$this->session->set_flashdata('msg', alert_danger(validation_errors()));
		// 		$this->index();
		// 	}
		// }
	}