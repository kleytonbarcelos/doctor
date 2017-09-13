<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Permissoes extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('permissao_model');
			$this->load->model('grupo_model');
			$this->load->model('grupopermissao_model');
		}
		public function index()
		{
			//############################################################################################################
			$tmp = '';
			$permissoes = $this->permissao_model->order_by('controller', 'asc')->get();
			$permissoes_banco_de_dados2 = array();
			if($permissoes)
			{
				foreach ($permissoes as $value)
				{
					if($tmp!=$value->controller)
					{
						$tmp=$value->controller;
						$i=0;
					}
					$grupos_permissoes = $this->grupopermissao_model->get( array('permissao_id'=>$value->id) );
					$permissoes_banco_de_dados[$tmp][$i] = array(
						'method'=>$value->method,
						'permissao'=>$grupos_permissoes,
					);
					$i++;
				}
				ksort($permissoes_banco_de_dados);
				$data['controllers'] = $permissoes_banco_de_dados;
				$data['grupos'] = $this->grupo_model->get();
			}
			else
			{
				$data['controllers'] = '';
				$data['grupos'] = $this->grupo_model->get();
			}
			$this->template->load('AdminLTE/index', 'permissoes/index', $data);
		}
		public function mudastatus()
		{
			$data = array(
				'grupo_id'=>$this->input->post('grupo_id'),
				'permissao_id'=>$this->input->post('permissao_id'),
			);
			$status = $this->grupopermissao_model->update_by( $data, array('acesso'=>$this->input->post('acesso')) );

			$response['status'] = ($status) ? 1 : 0;
			$response['acesso'] = $this->input->post('acesso');
			echo json_encode($response);
		}		
		public function sync()
		{
			grava_log($this->base_url_controller, 'Sincronizou (permissoes)');
			$this->load->library('controllerlist');
			//############################################################################################################
			//############################################################################################################
			//############################################################################################################
			//############################################################################################################
			//############################################################################################################
			$controllers = $this->controllerlist->getControllers();
			foreach ($controllers as $controller => $value)
			{
				//##############################################################
				//##############################################################
				foreach ($controllers[$controller] as $method)
				{
					$methods[$controller] = $method;// Pegando todos os METHOD para verificar se eles ainda existem no BANCO, caso não existam eles serão excluídos no final (EXCLUIR EXCESSO >>>>)
					//############################################################
					$data = array(
						'controller'=>$controller,
						'method'=>$method,
					);
					$permissao = array_to_row($this->permissao_model->order_by('controller', 'asc')->get( $data )); // Verifica se existe o CONTROLLER e o METHOD no banco
					if($permissao)
					{
						//$this->grupopermissao_model->delete_by( array('permissao_id'=>$permissao->id) );
						$grupos = $this->grupo_model->get();
						foreach ($grupos as $grupo)
						{
							$data_grupos_permissoes = array('grupo_id'=>$grupo->id, 'permissao_id'=>$permissao->id);
							$grupos_permissoes = array_to_row($this->grupopermissao_model->get( $data_grupos_permissoes ));
							if(!$grupos_permissoes) // Verifica se o CONTROLLER e o METHOD estão para todos os (GRUPOS_USUARIOS), caso não, ele insere para os que faltavam
							{
								//$tmp = array('acesso'=>0);
								//$data_grupos_permissoes = array_merge($data_grupos_permissoes, $tmp); // Acrescenta o acesso no array
								$this->grupopermissao_model->insert( $data_grupos_permissoes );
							}
						}
					}
					else // o CONTROLLER e o METHOD não existe no banco, eles serão inseridos
					{
						//echo $controller.'<br>';
						$permissao_id = $this->permissao_model->insert($data); // Inseriu em (permissoes) o CONTROLLER e o METHOD
						$grupos = $this->grupo_model->get();
						foreach ($grupos as $grupo)
						{
							$data_grupos = array(
								'grupo_id'=>$grupo->id,
								'permissao_id'=>$permissao_id,
								//'acesso'=>0,
							);
							$this->grupopermissao_model->insert($data_grupos); // Inseriu em (grupos_permissoes) o CONTROLLER e o METHOD para cada (GRUPOS_USUARIOS) existentes
							//echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$method.' ('.$grupo->nome.')<br>';
						}
					}
				}
			}
			//############################################################################################################
			// Exclui todos as PERMISSÕES de GRUPOS que não existem mais
			$this->db->query('DELETE FROM grupos_permissoes WHERE grupos_permissoes.grupo_id NOT IN (SELECT id FROM grupos)'); 
			//############################################################################################################
			// Verfica se existem CONTROLLERS excluídos do CODIGO, caso sim, eles serão excluídos do BANCO com seus respectivos METHODS.
			$controllers_arquivo = array();
			foreach ($controllers as $controller => $value)
			{
				$controllers_arquivo[] = $controller;
			}
			$controllers_list_db = $this->db->query('SELECT DISTINCT(controller) FROM permissoes')->result();
			$controllers_db = array();
			foreach ($controllers_list_db as $value)
			{
				$controllers_db[] = $value->controller;
			}
			foreach (get_array_diff($controllers_arquivo, $controllers_db) as $value)
			{
				$permissoes = $this->permissao_model->order_by('controller', 'asc')->get( array('controller'=>$value) ); // Verifica se existe o CONTROLLER e o METHOD no banco
				foreach ($permissoes as $permissao)
				{
					$grupos_permissoes = $this->grupopermissao_model->get( array('permissao_id'=>$permissao->id) );
					$this->permissao_model->delete($permissao->id);
					$this->grupopermissao_model->delete_by( array('permissao_id'=>$permissao->id) );
					// echo '<pre>';
					// 	print_r($permissao);
					// 	print_r($grupos_permissoes);
					// echo '</pre>';
				}
			}
			//############################################################################################################
			// Verifica se existem (methods) excluídos do CODIGO, caso sim, eles serão excluídos do BANCO
			$tmp = '';
			$controllers = $this->controllerlist->getControllers();
			$controllers_db = $this->permissao_model->order_by('controller', 'asc')->get();
			foreach ($controllers_db as $value)
			{
				if($tmp!=$value->controller)
				{
					$tmp=$value->controller;
					$i=0;
				}
				$permissoes_banco_de_dados[$tmp][$i] = $value->method;
				$i++;
			}
			ksort($controllers);
			ksort($permissoes_banco_de_dados);
			foreach ($controllers as $controller => $value)
			{
				$tmp = get_array_diff($controllers[$controller], $permissoes_banco_de_dados[$controller]);
				if($tmp)
				{
					foreach ($tmp as $value)
					{
						$permissoes = $this->permissao_model->order_by('controller', 'asc')->get( array('controller'=>$controller, 'method'=>$value) ); // Verifica se existe o CONTROLLER e o METHOD no banco
						foreach ($permissoes as $permissao)
						{
							$grupos_permissoes = $this->grupopermissao_model->get( array('permissao_id'=>$permissao->id) );
							$this->permissao_model->delete($permissao->id);
							$this->grupopermissao_model->delete_by( array('permissao_id'=>$permissao->id) );
							// echo '<pre>';
							// 	print_r($permissao);
							// 	print_r($grupos_permissoes);
							// echo '</pre>';
						}
					}
				}
			}
			//############################################################################################################
			// Adiciona permissão total ao GRUPO (id) = 1. Pois este será o administrador total do sistema
			//$this->grupopermissao_model->update_by( array('grupo_id'=>1), array('acesso'=>1) );
			//############################################################################################################
			//############################################################################################################
			// ADICIONA PERMISSÕES INICIAIS AO SISTEMA - ÁREAS COMUNS PARA TODOS OS USUÁRIOS.
			// $sql = '
			// 		UPDATE grupos_permissoes as GP
			// 			INNER JOIN permissoes as P ON (GP.permissao_id=P.id)
			// 		SET
			// 			GP.acesso=1
			// 		WHERE
			// 			P.controller="Home"
			// 			OR
			// 			P.controller="Permissoes"
			// 			OR
			// 			P.controller="Login"
			// ';
			// $this->db->query($sql);
			//############################################################################################################
			//############################################################################################################
			//############################################################################################################
			$response['status'] = 1;
			$response['msg'] = 'Sincronição realizada com sucesso!';
			echo json_encode($response);
		}
	}
	/* End of file Permissoes.php */
	/* Location: ./application/controllers/Permissoes.php */