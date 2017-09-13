<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Bulario_model extends MY_Model
	{
		public function __construct()
		{
			parent::__construct();
		}

		public $_table = 'bulas';
		public $primary_key = 'id';

		protected $medicamento = '';
		protected $letra = ''; // Letra do Medicamento (A-Z ou ALL)
		protected $empresa = '';
		protected $nu_expediente = '';
		protected $data_publicacao_i = '';
		protected $data_publicacao_f = '';
		protected $hdd_order_by = 'medicamento';
		protected $hdd_sort_by = 'asc';
		protected $hdd_page_absolute = 1;
		protected $page_size = 10;
		//########################################################################################
		public function get_medicamento()
		{
			return $this->medicamento;
		}
		public function set_medicamento($medicamento)
		{
			$this->medicamento = $medicamento;
		}
		public function get_letra()
		{
			return $this->letra;
		}
		public function set_letra($letra)
		{
			$this->letra = $letra;
		}
		public function get_empresa()
		{
			return $this->empresa;
		}
		public function set_empresa($empresa)
		{
			$this->empresa = $empresa;
		}
		public function get_nu_expediente()
		{
			return $this->nu_expediente;
		}
		public function set_nu_expediente($nu_expediente)
		{
			$this->nu_expediente = $nu_expediente;
		}
		public function get_data_publicacao_i()
		{
			return $this->data_publicacao_i;
		}
		public function set_data_publicacao_i($data_publicacao_i)
		{
			$this->data_publicacao_i = $data_publicacao_i;
		}
		public function get_data_publicacao_f()
		{
			return $this->data_publicacao_f;
		}
		public function set_data_publicacao_f($data_publicacao_f)
		{
			$this->data_publicacao_f = $data_publicacao_f;
		}
		public function get_hdd_order_by()
		{
			return $this->hdd_order_by;
		}
		public function set_hdd_order_by($hdd_order_by)
		{
			$this->hdd_order_by = $hdd_order_by;
		}
		public function get_hdd_sort_by()
		{
			return $this->hdd_sort_by;
		}
		public function set_hdd_sort_by($hdd_sort_by)
		{
			$this->hdd_sort_by = $hdd_sort_by;
		}
		public function get_hdd_page_absolute()
		{
			return $this->hdd_page_absolute;
		}
		public function set_hdd_page_absolute($hdd_page_absolute)
		{
			$this->hdd_page_absolute = $hdd_page_absolute;
		}
		public function get_page_size()
		{
			return $this->page_size;
		}
		public function set_page_size($page_size=NULL)
		{
			$this->page_size = $page_size;
		}
		//########################################################################################
		public function list_all()
		{
			$this->set_letra('ALL');
			return $this->busca_anvisa();
		}
		public function busca_anvisa() // Letra do Medicamento (A-Z ou ALL)
		{
			$html = $this->curl->_simple_call('post', 'http://www.anvisa.gov.br/datavisa/fila_bula/frmResultado.asp',
			[
				'txtMedicamento' => $this->get_medicamento(),
				'hddLetra' => $this->get_letra(), // Letra do Medicamento (A-Z ou ALL)
				'txtEmpresa' => '',
				'txtNuExpediente' => $this->get_nu_expediente(),
				'txtDataPublicacaoI' => $this->get_data_publicacao_i(),
				'txtDataPublicacaoF' => $this->get_data_publicacao_f(),
				'hddOrderBy' => $this->get_hdd_order_by(),
				'hddSortBy' => $this->get_hdd_sort_by(),
				'hddPageAbsolute' => $this->get_hdd_page_absolute(),
				'txtPageSize' => $this->get_page_size(),
			]);

			libxml_use_internal_errors(true);

			$dom = new DOMDocument();
			$dom->loadHTML($html);
			$xpath = new DOMXPath($dom);

			$nenhum_resultado = $xpath->query('//b[text()="Nenhuma bula na fila de análise"]');
			if($nenhum_resultado->length)
			{
				//return array('status'=>0, msg=>'Nenhum resultado encontrado!');
				return false;
			}
			else
			{
				$labels = $xpath->query('//label');
				$paginas = array();
				$label_tmp = '';

				foreach ($labels as $label)
				{
					if($label->getAttribute('title') == 'Página Atual')
					{
						$paginas['atual'] = trim(preg_replace("/[\r\n]+/", " ", $label->nodeValue));
					}
					else if($label->getAttribute('title') == 'Fim' )
					{
						$paginas['ultima_pagina'] = str_replace(');', '', str_replace('fPaginar(', '', $label->getAttribute('onclick')) );
					}
					else
					{
						$label_tmp = str_replace(');', '', str_replace('fPaginar(', '', $label->getAttribute('onclick')) );
						if (!in_array($label_tmp, $paginas))
						{
							$paginas[$label_tmp] = $label_tmp;
						}
					}
				}
				if (!array_key_exists('ultima_pagina', $paginas))
				{
					$paginas['ultima_pagina'] = end($paginas);
				}
				//#########################################################################################
				//#########################################################################################
				$contador_tr = 1;
				$contador_td = 0;
				$medicamentos_bula = array();
			
				$trs = $xpath->query('//*[@id="tblResultado"]//tbody//tr');
				foreach ($trs as $tr)
				{
					$tds = $tr->getElementsByTagName('td');
					foreach ($tds as $td)
					{
						if($contador_td == 0)
						{
							$medicamentos_bula[$contador_tr]['medicamento'] = nome_proprio($td->nodeValue);
						}
						if($contador_td == 1)
						{
							$medicamentos_bula[$contador_tr]['empresa'] = nome_proprio($td->nodeValue);
						}
						if($contador_td == 2)
						{
							$medicamentos_bula[$contador_tr]['expediente'] = trim($td->nodeValue);
						}
						if($contador_td == 3)
						{
							$medicamentos_bula[$contador_tr]['data_publicacao'] = trim($td->nodeValue);
						}
						if($contador_td == 4)
						{
							$Ancoras = $td->getElementsByTagName('a');
							foreach( $Ancoras as $Ancora)
							{
								$Onclick = $Ancora->getAttribute('onclick'); //MODELO >>>> <a title="Clique para visualizar a Bula de Paciente" href="#" onclick="fVisualizarBula(\'9888582015\', \'2942998\')">
								$explode = explode(',', $Onclick);
								$strTransacao = trim(rtrim(str_replace("fVisualizarBula('", "", $explode[0]), "'"));
								$strAnexo = trim(rtrim(str_replace("'", '', $explode[1]), ")"));

								$medicamentos_bula[$contador_tr]['bula_paciente_transacao'] = $strTransacao;
								$medicamentos_bula[$contador_tr]['bula_paciente_anexo'] = $strAnexo;
							}
						}
						if($contador_td == 5)
						{
							$Ancoras = $td->getElementsByTagName('a');
							foreach( $Ancoras as $Ancora)
							{
								$Onclick = $Ancora->getAttribute('onclick'); //MODELO >>>> <a title="Clique para visualizar a Bula de Paciente" href="#" onclick="fVisualizarBula(\'9888582015\', \'2942998\')">
								$explode = explode(',', $Onclick);
								$strTransacao = trim(rtrim(str_replace("fVisualizarBula('", "", $explode[0]), "'"));
								$strAnexo = trim(rtrim(str_replace("'", '', $explode[1]), ")"));

								$medicamentos_bula[$contador_tr]['bula_profissional_transacao'] = $strTransacao;
								$medicamentos_bula[$contador_tr]['bula_profissional_anexo'] = $strAnexo;
							}
						}
						$contador_td++;
					}
					$contador_tr++;
					$contador_td=0;
				}

				$variaveis = array(
					'medicamento' => $this->get_medicamento(),
					'letra' => $this->get_letra(), // Letra do Medicamento (A-Z ou ALL)
					'empresa' => $this->get_empresa(),
					'nu_expediente' => $this->get_nu_expediente(),
					'data_publicacao_i' => $this->get_data_publicacao_i(),
					'data_publicacao_f' => $this->get_data_publicacao_f(),
					'hdd_order_by' => $this->get_hdd_order_by(),
					'hdd_sort_by' => $this->get_hdd_sort_by(),
					'hdd_page_absolute' => $this->get_hdd_page_absolute(),
					'page_size' => $this->get_page_size(),
				);
				return array('paginas'=>$paginas, 'medicamentos'=>$medicamentos_bula, 'variaveis'=>$variaveis);
			}
		}
	}