<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expediente extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('expediente_model');
		$this->load->model('configuracoes_model');
	}
	public function index()
	{
		$data['Configuracoes'] = $this->configuracoes_model->get()[0];
		$this->template->load('AdminLTE/index', 'agenda/expediente', $data);
	}
	public function listaeventos()
	{
		$data['Dados'] = $this->expediente_model->as_array()->get();
		echo json_encode($data);
	}
	public function eventos()
	{
		$data['Expedientes'] = $this->expediente_model->get();
		echo json_encode($data);
	}
	// public function events()
	// {
	// 	$Dados = $this->expediente_model->as_array()->get();
	// 	$events = '';
	// 	foreach ($Dados as $key => $value)
	// 	{
	// 		$events .= "{";
	// 			$events .= "\"id\": \"".$value["id"]."\",";
	// 			$events .= "\"title\": \"".$value["titulo"]."\",";
	// 			$events .= "\"start\": \"".date_format(date_create($value["inicio"]), 'H:i')."\",\n";
	// 			$events .= "\"end\": \"".date_format(date_create($value["fim"]), 'H:i')."\",\n";
	// 			$events .= "\"dow\": [".$value["diadasemana"]."]\n";
	// 		$events .= "},";
	// 	}
	// 	$events = '['.substr($events, 0, -1).']';
	// 	return $events;
	// }
	public function events($json=true)
	{
		$events = array();
		$dados = $this->expediente_model->as_array()->get();
		foreach ($dados as $key => $value)
		{
			$tmp = array();

			$tmp['id'] = $value['id'];
			$tmp['title'] = $value['title'];
			$tmp['start'] = date_format(date_create($value["start"]), 'H:i');
			$tmp['end'] = date_format(date_create($value["end"]), 'H:i');
			$tmp['dow'] = '['.$value["dow"].']';

			array_push($events, $tmp);
		}

		if($json==true)
		{
			echo json_encode($events);
		}
		else
		{
			return json_encode($events);
		}
	}
	public function salvarexpediente()
	{
		$this->form_validation->set_rules('txtExpedienteInicio', strong('Horário Expediente (Inicío)'), 'required');
		$this->form_validation->set_rules('txtExpedienteFim', strong('Horário Expediente (Fim)'), 'required');
		$this->form_validation->set_rules('txtDuracaoDaConsulta', strong('Duração da consulta'), 'required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
				'horarioexpedienteinicio'=>$this->input->post('txtExpedienteInicio'),
				'horarioexpedientefim'=>$this->input->post('txtExpedienteFim'),
				'duracaoconsulta'=>$this->input->post('txtDuracaoDaConsulta'),
			);
			$this->configuracoes_model->update_all($data);

			$response['events'] = $this->events(false);
			$response['status'] = 1;
			$response['msg'] = 'Dados atualizados com sucesso';
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
	public function salvar()
	{
		$this->form_validation->set_rules('txtTitle', strong('Nome'), 'required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
					'title'=>$this->input->post('txtTitle'),
					'start'=>$this->input->post('txtStart'),
					'end'=>$this->input->post('txtEnd'),
					'dow'=>$this->input->post('txtDow')
				);
			if( empty($this->input->post('id')) )
			{
				$response['id'] = $this->expediente_model->insert($data);
				$response['acao'] = 'insert';
				$response['status'] = 1;
				$response['msg'] = 'Cadastro realizado com sucesso!';
			}
			else
			{
				$this->expediente_model->update($this->input->post('id'), $data);

				$response['id'] = $this->input->post('id');
				$response['acao'] = 'update';
				$response['status'] = 1;
				$response['msg'] = 'Dados atualizados com sucesso';
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
	public function excluir()
	{
		$ids = explode(',', $this->input->post('id'));
		foreach ($ids as $key => $value)
		{
			$return = $this->expediente_model->delete($value);
		}
		if($return)
		{
			$response['status'] = 1;
			$response['msg'] = 'Dado(s) excluído(s) com sucesso!';
		}
		else
		{
			$response['status'] = 0;
			$response['msg'] = 'Erro ocorrido na operação!';
		}
		echo json_encode($response);
	}
}