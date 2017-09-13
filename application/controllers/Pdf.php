<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Pdf extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function index()
		{
			$margin_left = ($this->input->post('margin_left')) ? $this->input->post('margin_left') : 15;
			$margin_right = ($this->input->post('margin_right')) ? $this->input->post('margin_right') : 15;
			$margin_top = ($this->input->post('margin_top')) ? $this->input->post('margin_top') : 35;
			$margin_bottom = ($this->input->post('margin_bottom')) ? $this->input->post('margin_bottom') : 25;
			$margin_header = ($this->input->post('margin_header')) ? $this->input->post('margin_header') : 15;
			$margin_footer = ($this->input->post('margin_footer')) ? $this->input->post('margin_footer') : 10;
			$output = ($this->input->post('output')) ? $this->input->post('output') : 'view';

			$this->load->library('mpdf2');
			$mpdf = new mPDF('utf-8','A4', 0, '', $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, 'P'); //mode - default '' | format - A4, for example, default '' | font size - default 0 | default font family | margin_left | margin right | margin top | margin bottom | margin header | margin footer| L - landscape, P - portrait
			$mpdf->useDefaultCSS2 = true;
			//########################################################################################### // HTML (post)
			$html = $this->input->post('html');
			//########################################################################################### // Insere todos os CSS e STYLE no PDF
			if( $this->input->post('css') || $this->input->post('style') )
			{
				$css = '';
				if($this->input->post('css'))
				{
					$files_css = explode(',', $this->input->post('css'));
					foreach ($files_css as $value)
					{
						$css .= file_get_contents($value);
					}
				}
				$css .= $this->input->post('style');
				$mpdf->WriteHTML($css, 1);
			}
			//########################################################################################### //headerimage => IMAGEM NO CABEÇALHO
			$pattern = "#<\s*?headerimage\b[^>]*>(.*?)</headerimage\b[^>]*>#s";
			preg_match_all($pattern, $html, $matches);
			$headerimage = $matches[1][0];
			$html = trim(preg_replace($pattern, '', $html));
			//########################################################################################### //footerimage => IMAGEM NO RODAPÉ
			$pattern = "#<\s*?footerimage\b[^>]*>(.*?)</footerimage\b[^>]*>#s";
			preg_match_all($pattern, $html, $matches);
			$footerimage = $matches[1][0];
			$html = trim(preg_replace($pattern, '', $html));
			//########################################################################################### // TAG header => CABEÇADO DA PÁGINA
			$pattern = "#<\s*?header\b[^>]*>(.*?)</header\b[^>]*>#s";
			preg_match_all($pattern, $html, $matches);
			$header = $matches[1][0];
			$html = trim(preg_replace($pattern, '', $html));
			//########################################################################################### // TAG footer => RODAPÉ DA PÁGINA
			$pattern = "#<\s*?footer\b[^>]*>(.*?)</footer\b[^>]*>#s";
			preg_match_all($pattern, $html, $matches);
			$footer = $matches[1][0];
			$html = trim(preg_replace($pattern, '', $html));
			//###########################################################################################
			$mpdf->SetHTMLHeader($header);
			$mpdf->SetHTMLFooter($footer);
			if($headerimage){$mpdf->SetHTMLHeader($headerimage);}  // Imagens ideais 680px
			if($footerimage){$mpdf->SetHTMLFooter($footerimage);}  // Imagens ideais 680px
			//###########################################################################################
			$mpdf->WriteHTML($html);
			if($output=='view'){$mpdf->Output();}else{$mpdf->Output(substr(str_shuffle('abcefghijklmnopqrstuvwxyz1234567890'), 0, 30).'.pdf', 'D');}
		}
	}
// <?php
// 	defined('BASEPATH') OR exit('No direct script access allowed');

// 	class Pdf extends MY_Controller
// 	{
// 		public function __construct()
// 		{
// 			parent::__construct();
// 		}
// 		public function index()
// 		{
// 			$margin_left = 15;
// 			$margin_right = 15;
// 			$margin_top = 35;
// 			$margin_bottom = 25;
// 			$margin_header = 15;
// 			$margin_footer = 10;

// 			$output = 'view';

// 			$this->load->library('mpdf2');
// 			$mpdf = new mPDF('utf-8','A4', 0, '', $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, 'P'); //mode - default '' | format - A4, for example, default '' | font size - default 0 | default font family | margin_left | margin right | margin top | margin bottom | margin header | margin footer| L - landscape, P - portrait
// 			$mpdf->useDefaultCSS2 = true;
// 			//###########################################################################################
// 			$html = $_POST['html'];
// 			$imagem_cabecalho = '';//'<img src="'.base_url().'assets/img/cabecalhoprontuario.png">'; // Imagens ideais 680px
// 			$imagem_background = '
// 			<style type="text/css">
// 				body{background: url('.base_url().'assets/img/bgprontuario.jpg) no-repeat;}
// 			</style>
// 			';
// 			if($imagem_background){$html=$imagem_background.$html;}
// 			//########################################################################################### // Insere todos os CSS e STYLE no PDF
// 			if( $_POST['css'] || $_POST['style'] )
// 			{
// 				$css = '';
// 				if($_POST['css'])
// 				{
// 					$files_css = explode(',', $_POST['css']);
// 					foreach ($files_css as $value)
// 					{
// 						$css .= file_get_contents($value);
// 					}
// 				}
// 				$css .= $_POST['style'];
// 				$mpdf->WriteHTML($css, 1);
// 			}
// 			//###########################################################################################
// 			$pattern = "#<\s*?footer\b[^>]*>(.*?)</footer\b[^>]*>#s";
// 			preg_match_all($pattern, $html, $matches);
// 			$footer = $matches[1][0];
// 			$html = trim(preg_replace($pattern, '', $html));
// 			//###########################################################################################
// 			$mpdf->SetHTMLHeader('<div style="border-bottom: 1px solid #000000; font-weight: bold; font-size: 10pt;">Dr. Saulo Blunck<br>Ortopedista e Traumatologista</div>');
// 			$mpdf->SetHTMLFooter('
// 				'.$footer.'
// 									<div style="clear: both; margin: 0pt; padding: 0pt;"></div>
// 									<br><br>
// 									<div style="border-top:1px solid #000;"></div>
// 									<div style="float: left; width: 33%;font-weight: bold; font-size: 10px;text-align:left;">{DATE d/m/Y}</div>
// 									<div style="float: right; width: 33%;font-weight: bold; font-size: 10px;text-align:right;">{PAGENO}</div>
// 									<div style="display: inline-block; width: 33%;font-weight: bold; font-size: 10px;text-align:center;">CLÍNICA SÃO MIGUEL ARCANJO<br>28 3553-9782<br>www.oneclinic.com.br</div>
// 								');
// 			if($imagem_cabecalho){$mpdf->SetHTMLHeader($imagem_cabecalho);}
// 			$mpdf->WriteHTML($html);
// 			if($output=='view'){$mpdf->Output();}else{$mpdf->Output(substr(str_shuffle('abcefghijklmnopqrstuvwxyz1234567890'), 0, 30).'.pdf', 'D');}
// 		}
// 	}