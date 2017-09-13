<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agenda extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('agenda_model');
		$this->load->model('prontuario_model');
		$this->load->model('expediente_model');
		$this->load->model('configuracoes_model');
	}
	public function index()
	{
		$data['Expedientes'] = $this->expediente_model->as_array()->get();
		$data['Dados'] = $this->agenda_model->as_array()->get();
		$data['Configuracoes'] = $this->configuracoes_model->get()[0];
		$this->template->load('AdminLTE/index', 'agenda/agenda', $data);
	}
	public function eventos()
	{
		$data['Agendas'] = $this->agenda_model->get();
		echo json_encode($data);
	}
	public function businesshours()
	{
		$businesshours = array();
		$expedientes = $this->expediente_model->as_array()->get();
		foreach ($expedientes as $key => $value)
		{
			$tmp = array();
			$tmp['start'] = $value['start'];
			$tmp['end'] = $value['end'];
			$tmp['dow'] = '['.$value['dow'].']';

			array_push($businesshours, $tmp);
		}
		echo json_encode($businesshours);
	}
	public function events($json=true)
	{
		$events = array();
		$dados = $this->agenda_model->as_array()->get();
		foreach ($dados as $key => $value)
		{
			$tmp = array();
			$tmp['id'] = $value['id'];
			$tmp['title'] = $value['title'];
			$tmp['start'] = $value['start'];
			$tmp['end'] = $value['end'];
			$tmp['className'] = 'event-'.$value['tipo'];
			$tmp['status'] = $value['status'];
			$tmp['paciente_id'] = $value['paciente_id'];
			array_push($events, $tmp);
		}

		if($json ==true)
		{
			echo json_encode($events);
		}
		else
		{
			return json_encode($events);
		}
	}
	public function get()
	{
		$data['event'] = $this->agenda_model->get($this->input->post('id'));
		echo json_encode($data);
	}
	public function getvaluesinputs()
	{
		$data['inputs'] = $this->agenda_model->get($this->input->post('id'));
		foreach ($data['inputs'] as $key => $value)
		{
			$data_temp[sha1($key)] = $value;
		}
		$data['inputs'] = $data_temp;
		echo json_encode($data);
	}
	public function drop()
	{
		if($this->input->post('id'))
		{
			$data = array(
					'start'=>$this->input->post('txtStart'),
					'end'=>$this->input->post('txtEnd'),
			);
			$this->agenda_model->update($this->input->post('id'), $data);

			$response['id'] = $this->input->post('id');
			$response['acao'] = 'update';
			$response['status'] = 1;
			$response['msg'] = 'Dados atualizados com sucesso!';
		}
		echo json_encode($response);
	}
	public function changestatus()
	{
			$data = array(
					'status'=>$this->input->post('status'),
			);
		$this->agenda_model->update($this->input->post('id'), $data);

		$response['id'] = $this->input->post('event_id');
		$response['status'] = 1;
		$response['msg'] = 'Dados atualizados com sucesso!';
		echo json_encode($response);
	}
	public function salvar()
	{
		$this->form_validation->set_rules('txtTitle', strong('Paciente'), 'required');
		$this->form_validation->set_rules('txtTipo', strong('Tipo Consulta'), 'required');

		if( $this->form_validation->run() == true )
		{
			if( $this->input->post('txtTipo') == 'consulta' )
			{
				$className = 'event-consulta';
			}
			else if( $this->input->post('txtTipo') == 'retorno' )
			{
				$className = 'event-retorno';
			}
			//############################################################
			$data = array(
					'title'=>$this->input->post('txtTitle'),
					'start'=>$this->input->post('txtStart'),
					'end'=>$this->input->post('txtEnd'),
					
					'tipo'=>$this->input->post('txtTipo'),
					'convenio'=>$this->input->post('txtConvenio'),
					'obs'=> $this->input->post('txtObs'),

					'paciente_id'=>$this->input->post('paciente_id'),
			);
			if(!$this->input->post('event_id'))
			{
				$data['status'] = 'Agendado';

				$response['id'] = $this->agenda_model->insert($data);
				$response['acao'] = 'insert';
				$response['status'] = 1;
				$response['msg'] = 'Cadastro realizado com sucesso!';
			}
			else
			{
				$this->agenda_model->update($this->input->post('event_id'), $data);

				$response['id'] = $this->input->post('event_id');
				$response['acao'] = 'update';
				$response['status'] = 1;
				$response['msg'] = 'Dados atualizados com sucesso!';
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
			$return = $this->agenda_model->delete($value);
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
/* End of file Agenda.php */
/* Location: ./application/controllers/Agenda.php */