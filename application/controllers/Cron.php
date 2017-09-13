<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Cron extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function index()
		{
		}
		public function ans()
		{
			$this->template->load('AdminLTE/index', 'home/ans');
		}
		public function registrosans()
		{
			$this->load->model('RegistroAns_model');

			$data['registrosans'] = $this->RegistroAns_model->select('registroans')->get();
			echo json_encode($data);
		}
		public function salva_ans()
		{
			$this->load->model('RegistroAns_model');
			//######################################################################### // Corrigindo registrosANS com menos de 6 digitos.
			$registroans = $this->input->post('id');
			$len = strlen($registroans);
			$diff_len = 6 - $len;
			
			if( $diff_len != 0 )
			{
				for ($i=0; $i < $diff_len; $i++)
				{
					$registroans = '0'.$registroans;
				}
			}
			//#########################################################################
			$url = 'http://www.ans.gov.br/ConsultaPlanosConsumidor/pages/ConsultaPlanos.xhtml?windowId='.rand(0,9).rand(0,9).rand(0,9).'&coOperadora='.$registroans;
			$html = file_get_contents($url);

			$dom = new DOMDocument();
			@$dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$html);
			$xpath = new DOMXPath($dom);

			$data['razaosocial'] = $xpath->query('//*[@id="formHome:outRazaoSocial"]')->item(0);
			$data['razaosocial'] = trim($data['razaosocial']->nodeValue);

			$data['registroans'] = $xpath->query('//*[@id="formHome:outRegANS"]')->item(0);
			$data['registroans'] = $registroans;//trim($data['registroans']->nodeValue);

			$data['cnpj'] = $xpath->query('//*[@id="formHome:outCNPJ"]')->item(0);
			$data['cnpj'] = trim($data['cnpj']->nodeValue);

			$data['nomefantasia'] = $xpath->query('//*[@id="formHome:outFantasia"]')->item(0);
			$data['nomefantasia'] = trim($data['nomefantasia']->nodeValue);

			$data['modalidade'] = $xpath->query('//*[@id="formHome:outModalidade"]')->item(0);
			$data['modalidade'] = trim($data['modalidade']->nodeValue);

			echo json_encode($data);
			$this->RegistroAns_model->update_by( array('registroans'=>$this->input->post('id')), $data );
		}
	}