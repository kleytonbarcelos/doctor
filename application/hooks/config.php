<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Config
{
	public function __construct()
	{
		
	}
	protected function ci()
	{
		return get_instance();
	}
	function config()
	{
		if( property_exists($this->ci()->session, 'dados_usuario') )
		{			
			if( $this->ci()->session->dados_usuario->status == 'pendente' )
			{
				redirect('logoff', 'refresh');
				exit;
			}
		}
		//#################################################################################
		//#################################################################################
		date_default_timezone_set('America/Sao_Paulo');
		//#################################################################################
		$this->ci()->base_url = base_url();
		$this->ci()->base_url_controller = base_url().$this->ci()->router->fetch_class().'/';
		$this->ci()->controller = $this->ci()->router->fetch_class();
		//#######################################################################################
		$this->ci()->session->document_root = str_replace('\\', '/', FCPATH);
		$folder_base =  explode('/', base_url());
		$this->ci()->session->folder_base = $folder_base[3];
		//#######################################################################################
		$this->ci()->load->library('CI_Minifier');
		//$this->ci()->ci_minifier->init('js, css');
		//#################################################################################
		//#################################################################################
		//#################################################################################
		$controllers_publics = array('login');
		if(!in_array($this->ci()->controller, $controllers_publics))
		{
			if( !$this->ci()->session->dados_usuario )
			{
			// 	$controller = ($this->ci()->controller) ? $this->ci()->controller : 'home';
			// 	$this->ci()->session->url_redirect = base_url().$controller;
			// 	redirect('login','refresh');
				$this->ci()->session->url_redirect = $this->ci()->base_url_controller;
				redirect('login','refresh');
			}
			else
			{
				$this->ci()->load->model('permissao_model');
				$permissoes = $this->ci()->permissao_model->get();
				if($permissoes)
				{
					$this->ci()->load->model('permissao_model');
					$this->ci()->load->model('grupopermissao_model');
					$method = ($this->ci()->uri->segment(2)) ? $this->ci()->uri->segment(2) : 'index';
					$permissao = array_to_row($this->ci()->permissao_model->get( array('controller'=>$this->ci()->controller, 'method'=>$method) ));
					$grupospermissoes = array_to_row($this->ci()->grupopermissao_model->get( array('permissao_id'=>$permissao->id, 'grupo_id'=>$this->ci()->session->dados_usuario->grupo_id) ));
					// echo '<pre>';	
					// 	print_r($grupospermissoes);
					// echo '</pre>';
					// exit;
					if(!$grupospermissoes->acesso)
					{
						redirect('login/sempermissao','refresh');
					}
				}
			}
		}
		//#################################################################################
		//#################################################################################
		//#################################################################################
	}
}
/* End of file login.php */
/* Location: ./application/hooks/login.php */