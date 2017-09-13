<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Bulario extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('bulario_model');
		}
		public function index()
		{
			$data['dados'] = $this->bulario_model->list_all();
			$data['dados']['html_medicamentos_bootstrap'] = medicamentos_bootstrap_anvisa($data['dados']['medicamentos']);
			$data['dados']['html_paginacao_bootstrap'] = paginacao_bootstrap_anvisa($data['dados']['paginas']);
			$this->template->load('AdminLTE/index', 'bulario/bulario', $data);
		}
		public function lista()
		{
			$this->bulario_model->set_medicamento($this->input->post('medicamento'));
			$this->bulario_model->set_letra($this->input->post('letra'));
			$this->bulario_model->set_empresa($this->input->post('empresa'));
			$this->bulario_model->set_nu_expediente($this->input->post('nu_expediente'));
			$this->bulario_model->set_data_publicacao_i($this->input->post('data_publicacao_i'));
			$this->bulario_model->set_data_publicacao_f($this->input->post('data_publicacao_f'));
			$this->bulario_model->set_hdd_order_by($this->input->post('hdd_order_by'));
			$this->bulario_model->set_hdd_sort_by($this->input->post('hdd_sort_by'));
			$this->bulario_model->set_hdd_page_absolute($this->input->post('hdd_page_absolute'));
			$this->bulario_model->set_page_size($this->input->post('page_size'));

			if( $this->bulario_model->busca_anvisa() )
			{
				$data['dados'] = $this->bulario_model->busca_anvisa();
				$data['dados']['html_medicamentos_bootstrap'] = medicamentos_bootstrap_anvisa($data['dados']['medicamentos']);
				$data['dados']['html_paginacao_bootstrap'] = paginacao_bootstrap_anvisa($data['dados']['paginas']);
				$data['status'] = 1;
			}
			else
			{
				$data['status'] = 0;
				$data['msg'] = 'Nenhum resultado encontrado!';
			}
			echo json_encode($data);
		}
		public function cron()
		{
			$this->template->load('AdminLTE/index', 'bulario/cron');
		}
		public function salvar()
		{
			$this->bulario_model->set_hdd_page_absolute($this->input->post('hdd_page_absolute'));
			$this->bulario_model->set_page_size($this->input->post('page_size'));
			$data['dados'] = $this->bulario_model->list_all();
			$this->bulario_model->insert_many($data['dados']['medicamentos']);

			$response['dados'] = $data['dados'];
			$response['status'] = 1;
			echo json_encode($response);
		}
	}
/* End of file Bulario.php */
/* Location: ./application/controllers/Bulario.php */