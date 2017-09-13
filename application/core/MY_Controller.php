<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class MY_Controller extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();

			// if( property_exists($this->session, 'dados_usuario') )
			// {			
			// 	if( $this->session->dados_usuario->status == 'pendente' )
			// 	{
			// 		redirect('logoff', 'refresh');
			// 		exit;
			// 	}
			// }
			
			// date_default_timezone_set('America/Sao_Paulo');
			
			// $this->base_url = base_url();
			// $this->base_url_controller = base_url().$this->router->fetch_class().'/';
			// $this->controller = $this->router->fetch_class();

			// $this->session->document_root = str_replace('\\', '/', FCPATH);
			// $folder_base =  explode('/', base_url());
			// $this->session->folder_base = $folder_base[3];
			// //#######################################################################################
			// $this->load->library('CI_Minifier');
			// //$this->ci_minifier->init('js, css');
			// //#################################################################################
			// //#################################################################################
			// if( $this->session->dados_usuario )
			// {
			// 	// $controllers_publics = array(
			// 	// 	'Login',
			// 	// 	'Logoff',
			// 	// );
			// 	// if(!in_array($this->controller, $controllers_publics))
			// 	// {
			// 		$this->load->model('permissao_model');
			// 		$this->load->model('grupopermissao_model');
			// 		$method = ($this->uri->segment(2)) ? $this->uri->segment(2) : 'index';
			// 		$permissao = array_to_row($this->permissao_model->get( array('controller'=>$this->controller, 'method'=>$method) ));
			// 		$grupospermissoes = array_to_row($this->grupopermissao_model->get( array('permissao_id'=>$permissao->id, 'grupo_id'=>$this->session->dados_usuario->grupo_id) ));
			// 		if(!$grupospermissoes->acesso)
			// 		{
			// 			redirect('login/sempermissao','refresh');
			// 		}
			// 	//}
			// }
			// else
			// {
			// // 	$controller = ($this->controller) ? $this->controller : 'home';
			// // 	$this->session->url_redirect = base_url().$controller;
			// // 	redirect('login','refresh');
			// 	$this->session->url_redirect = base_url().$this->router->fetch_class();
			// 	redirect('login','refresh');
			// }
			//#######################################################################################
			// $controllers_nao_protegidos = array(
			// 	'cadastro',
			// );
			// if( !in_array($this->controller, $controllers_nao_protegidos) )
			// {
			// 	if( !$this->session->dados_usuario || $this->session->dados_usuario->status == 'pendente' )
			// 	{
			// 		$segments = $this->uri->segment_array();
			// 		$tmp = '';
			// 		foreach ($segments as $key => $value)
			// 		{
			// 			$tmp .= $value.'/';
			// 		}
			// 		$url = substr(base_url().$tmp, 0, -1);
			// 		$this->session->url_redirect = $url;
			// 		redirect('login','refresh');
			// 	}
			// }
			// //#######################################################################################
			// $this->form_validation->set_error_delimiters('', '');
		}
	}
	/* End of file MY_Controller.php */
	/* Location: ./application/core/MY_Controller.php */