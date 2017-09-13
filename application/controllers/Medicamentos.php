<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medicamentos extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('medicamento_model');
	}
	public function bula($url)
	{
		$data['medicamento'] = query_array_to_row( $this->medicamento_model->like( array('url'=>$url) )->get() );
		if($data['medicamento'])
		{
			$this->template->load('AdminLTE/index', 'medicamentos/bula', $data);
		}
		else
		{
			redirect('medicamentos','refresh');
		}
	}
	public function letra($letra)
	{
		$data['medicamentos'] = $this->db->select('id, nome')->query('SELECT * FROM medicamentos WHERE nome LIKE "'.$letra.'%"')->result();
		if($data['medicamentos'])
		{
			$data['letra'] = $letra;
			$this->template->load('AdminLTE/index', 'medicamentos/medicamentosporletra', $data);
		}
		else
		{
			redirect('medicamentos','refresh');
		}
	}
	public function index()
	{
		$this->template->load('AdminLTE/index', 'medicamentos/index');
	}
	public function cron()
	{
		$this->template->load('AdminLTE/index', 'medicamentos/cron');
	}
	public function salva($pg=null)
	{
		set_time_limit(0);

		$pg = (!$pg) ? 1 : $pg;
		$total_pg = count(range('A', 'Z'));

		if($pg == $total_pg )
		{
			$data['status'] = 'concluido';
			echo json_encode($data);
		}
		else
		{
			$cont = 1;
			$letras = [];

			foreach(range('A', 'Z') as $letra)
			{
				$letras[$cont] = $letra;
				$cont++;
			}
			//########################################################
			$url = 'http://www.minhavida.com.br/saude/bulas/a-z/'.$letras[$pg];
			foreach ($this->getListaDeMedicamentos($url) as $value)
			{
				$medicamentos[] = $value;
			}
			//########################################################
			foreach ($medicamentos as $key => $value)
			{
				$bula = $this->getDadosMedicamento($value['url']);
				$bula = preg_replace('/(\s\s+|\t|\n)/', ' ', $bula); //REMOVE TABS|NEW LINE

				$data = array(
					'nome'=>$value['nome'],
					'url'=>$value['url'],
					'bula'=>$bula,
				);
				$this->medicamento_model->insert($data);
				unset($data);
			}
			$pg++;

			$data['pg'] = $pg;
			$data['status'] = 'processando';
			echo json_encode($data);
		}
	}
	private function getListaDeMedicamentos($url)
	{
		libxml_use_internal_errors(true);

		$tmp = [];
		$tmp2 = [];

		$html = file_get_contents($url);
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);

		$elements = $xpath->query('//*[@class="lista-letra"]//li');
		foreach ($elements as $element)
		{
			$Ancoras = $element->getElementsByTagName('a');
			foreach( $Ancoras as $Ancora)
			{
				$tmp['nome'] = $Ancora->nodeValue;
				$tmp['url'] = 'http://www.minhavida.com.br'.$Ancora->getAttribute('href');
				array_push($tmp2, $tmp);
			}
		}
		return $tmp2;
	}
	private function getDadosMedicamento($url)
	{
		libxml_use_internal_errors(true);

		$tmp = null;
		//$html = file_get_contents("http://www.minhavida.com.br/saude/bulas/13-omeprazol-capsula");
		$html = file_get_contents($url);
		$dom = new DOMDocument();
		$dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$html);
		$xpath = new DOMXPath($dom);
		//############################################################################################
		$elements = $xpath->query('//h2/a'); // REMOVE LINKS EXTERNOS JÁ EXISTENTES NO TEXTO
		foreach ($elements as $element)
		{
			$new_element = $dom->createTextNode($element->nodeValue);
			$element->parentNode->replaceChild($new_element, $element);
		}
		//############################################################################################
		$publicidades = $xpath->query('//*[@class="publicidade"]'); //REMOVE PUBLICIDADE
		foreach ($publicidades as $publicidade)
		{
			$publicidade->parentNode->removeChild($publicidade);
		}
		//############################################################################################
		$tmp .= '<div class="cabecalho-medicamento">';
			$tmp .= '<div class="pull-right cursor-pointer"><h4><span data-url="'.$xpath->query('//*[@class="disclaimer-bulas"]/a')->item(0)->getAttribute('href').'"class="bula label label-info"><i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Bula Original</span></h4></div>';
			$titulo = $xpath->query('//*[@itemprop="name"]')->item(0);
			$tmp .= '<h1><i class="fa fa-medkit"></i> '.$titulo->nodeValue.'</h1>';
			$medicamento_generico = $xpath->query('//*[@class="medicamento-generico"]');
			if($medicamento_generico->length)
			{
				$tmp .= '<img src="'.base_url().'assets/img/medicamentogenerico.jpg">';
			}
			//$links = $xpath->query('//*[@class="va-direto-ao-ponto"]')->item(0);
			//$tmp .= $dom->saveHTML($links);
			$tmp .= '<div class="links"><a href="#indicacao" class="label label-success">Para que serve?</a>&nbsp;&nbsp;&nbsp;<a href="#como_usar" class="label label-success">Como usar</a></div>';
		$tmp .= '</div>';
		//############################################################################################
		$elements = $xpath->query('//*[contains(@class, "panel-group")]');
		foreach ($elements as $element)
		{
			$tmp .= $dom->saveHTML($element);
		}
		//############################################################################################
		$tmp = str_replace('/saude/bulas/', 'http://www.minhavida.com.br/saude/bulas/', $tmp); // ADICIONA URL EXTERNA (COMPLETA)
		return $tmp;
	}
	public function precos_medicamento()
	{
		libxml_use_internal_errors(true);

		$tmp = null;
		$html = file_get_contents($this->input->post('url'));
		$dom = new DOMDocument();
		$dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$html);
		$xpath = new DOMXPath($dom);

		$html = $xpath->query('//*[@class="panel-group"]')->item(0);
		$data['html'] = str_replace('tabela-preco-medicamentos', 'tabela-preco-medicamentos table table-striped', $dom->saveHTML($html));
		//$data['html'] = $dom->saveHTML($html);
		$data['status'] = 1;
		echo json_encode($data);
	}
}
/* End of file Medicamentos.php */
/* Location: ./application/controllers/Medicamentos.php */