<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prontuarios extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('prontuario_model');
		$this->load->model('paciente_model');
		$this->load->model('agenda_model');

		$this->load->model('prontuariocartaatestado_model');
		$this->load->model('prontuarioexameanexo_model');
		$this->load->model('prontuariocid10_model');
		$this->load->model('prontuarioprescricao_model');
		$this->load->model('prontuarioodontograma_model');
	}
	public function index()
	{
		redirect('home','refresh');
	}
	public function paciente($id)
	{
		$data['dados_paciente'] = $this->paciente_model->get($id);

		if($data['dados_paciente'])
		{
			$data['dados_event'] = (object) ['id'=>0];
			$this->template->load('AdminLTE/index', 'prontuarios/index', $data);
		}
		else
		{
			redirect('home','refresh');
		}
	}
	public function criaevento($action='novo')
	{
		if($action == 'novo')
		{
			$data = array(
					'title'=>$this->input->post('txtTitle'),
					'start'=>$this->input->post('txtStart'),
					'end'=>$this->input->post('txtEnd'),
					
					'tipo'=>$this->input->post('txtTipo'),
					'convenio'=>$this->input->post('txtConvenio'),
					'obs'=> $this->input->post('txtObs'),

					'paciente_id'=>$this->input->post('paciente_id'),
					'status'=>$this->input->post('txtStatus'),
			);

			$response['id'] = $this->agenda_model->insert($data);
			$response['status'] = 1;
			$response['msg'] = 'Registro adicionado com sucesso!';
			echo json_encode($response);
		}
		else
		{
			$this->load->model('configuracoes_model');
			$data = query_array_to_row( $this->configuracoes_model->select('duracaoconsulta')->get() );
			echo json_encode($data);
		}
	}
	public function atendimento($event_id='')
	{
		if($event_id)
		{
			$data['dados_event'] = $this->agenda_model->get($event_id);
			if( $data['dados_event'] )
			{
				if( $data['dados_event']->status == 'Paciente atendido' )
				{
					redirect('home','refresh');
				}
				else
				{
					$data['event_id'] = $data['dados_event']->id;
					$data['dados_paciente'] = $this->paciente_model->get( $data['dados_event']->paciente_id );
					$data['dados_prontuario'] = $this->prontuario_model->get( array('event_id'=>$data['dados_event']->id) );

					if( $data['dados_prontuario'] ) // CONTINUAR ATENDIMENTO
					{

					}
					else
					{

					}
					$this->template->load('AdminLTE/index', 'prontuarios/index', $data);
				}
			}
			else
			{
				redirect('home','refresh');				
			}
		}
	}
	public function criar_prontuario()
	{
		$data = array(
				'usuario_id'=>$this->session->dados_usuario->id,
				'paciente_id'=>$this->input->post('paciente_id'),
				'event_id'=>$this->input->post('event_id'),
				'status'=>'atendimento',
		);
		$prontuario_id = $this->prontuario_model->insert($data);
		unset($data);
		$data['dados_prontuario'] = $this->prontuario_model->select('id')->get($prontuario_id);
		echo json_encode($data);
	}
	public function salvar()
	{
		$this->form_validation->set_rules('txtQueixaPrincipal', strong('Queixa Principal'), 'trim|required');
		// $this->form_validation->set_rules('txtHistoria', strong('História'), 'trim|required');
		// $this->form_validation->set_rules('txtAnamnese', strong('Anamnese'), 'trim|required');
		// $this->form_validation->set_rules('txtAltura', strong('Altura'), 'trim|required');
		// $this->form_validation->set_rules('txtPeso', strong('Peso'), 'trim|required');
		// $this->form_validation->set_rules('txtFrequenciaCardiaca', strong('Frequencia Cardíca'), 'trim|required');
		// $this->form_validation->set_rules('txtPressaoArterialSistolica', strong('Pressão Arterial Sistólica'), 'trim|required');
		// $this->form_validation->set_rules('txtPressaoArterialDiastolica', strong('Pressão Arterial Diastólica'), 'trim|required');
		// $this->form_validation->set_rules('txtDiagnostico', strong('Hipótese diagnóstica'), 'trim|required');
		// $this->form_validation->set_rules('txtEvolucao', strong('Evolução'), 'trim|required');
		// $this->form_validation->set_rules('txtPrescricao', strong('Prescrição'), 'trim|required');
		// $this->form_validation->set_rules('txtDataCartaAtestado', strong('Data Carta e Atestado'), 'trim|required');
		// $this->form_validation->set_rules('txtCartasAtestados', strong('Carta e Atestado'), 'trim|required');

		if( $this->form_validation->run() == true )
		{
			$status = '';

			if( $this->input->post('acao') == 'encerrar')
			{
				$this->agenda_model->update($this->input->post('event_id'), array('status'=>'Paciente atendido'));
				$status = 'concluido';
			}

			$data = array(
					'queixaprincipal'=>$this->input->post('txtQueixaPrincipal'),
					'historia'=>$this->input->post('txtHistoria'),
					'anamnese'=>$this->input->post('txtAnamnese'),
					'temperatura'=>$this->input->post('txtTemperatura'),
					'altura'=>$this->input->post('txtAltura'),
					'examefisico'=>$this->input->post('txtExameFisico'),
					'peso'=>$this->input->post('txtPeso'),
					'frequenciacardiaca'=>$this->input->post('txtFrequenciaCardiaca'),
					'pressaoarterialsistolica'=>$this->input->post('txtPressaoArterialSistolica'),
					'pressaoarterialdiastolica'=>$this->input->post('txtPressaoArterialDiastolica'),
					'diagnostico'=>$this->input->post('txtDiagnostico'),
					'evolucao'=>$this->input->post('txtEvolucao'),
					// 'datacartaatestado'=>$this->input->post('txtDataCartaAtestado'),
					// 'cartaatestado'=>$this->input->post('txtCartasAtestados'),
					'dataprescricao'=>$this->input->post('txtDataPrescricao'),
					
					'tempoatendimento'=>$this->input->post('tempoatendimento'),
					'data'=>date('Y-m-d H:i:s'),

					'status'=>$status,
			);

			$this->prontuario_model->update($this->input->post('prontuario_id'), $data);
			$response['acao'] = 'editar';
			$response['status'] = 1;
			$response['msg'] = 'Registro atualizado com sucesso!';

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
			$result = $this->prontuario_model->delete($value);
		}
		if($result)
		{
			$response['status'] = 1;
			$response['msg'] = 'Registro(s) excluído(s) com sucesso!';
		}
		else
		{
			$response['status'] = 0;
			$response['msg'] = 'Erro ocorrido na operação!';
		}
		echo json_encode($response);
	}
	public function salvarmodeloprescricao()
	{
		$this->load->model('modeloprescricao_model');
		$this->load->model('modeloprescricaoregistro_model');

		$this->form_validation->set_rules('txtNomeModeloPrescricao', strong('Nome'), 'trim|required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
					'usuario_id'=>$this->session->dados_usuario->id,
					'nome'=>$this->input->post('txtNomeModeloPrescricao'),
				);
			$modeloprescricao_id = $this->modeloprescricao_model->insert($data);
			$data = null;

			if( sizeof($this->input->post('txtMedicamento')) > 0 )
			{
				$medicamentos = $this->input->post('txtMedicamento');
				$quantidades = $this->input->post('txtQuantidade');
				$posologias = $this->input->post('txtPosologia');
				for ($i=0; $i<sizeof($medicamentos); $i++)
				{
					$data[] = array(
						'modelos_prescricoes_id'=>$modeloprescricao_id,
						'medicamento'=>$medicamentos[$i],
						'quantidade'=>$quantidades[$i],
						'posologia'=>$posologias[$i],
					);
				}
				$this->modeloprescricaoregistro_model->insert_many($data);
			}

			$response['acao'] = 'cadastrar';
			$response['status'] = 1;
			$response['msg'] = 'Registro adicionado com sucesso!';
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
	public function get()
	{
		$data['prontuario'] = $this->prontuario_model->get($this->input->post('id'));
		echo json_encode($data);
	}
	public function Prontuarios()
	{
		if( $this->input->post('paciente_id') )
		{
			$data['prontuarios'] = $this->prontuario_model->get( array('paciente_id'=>$this->input->post('paciente_id'), 'status'=>'concluido') );
		}
		else
		{
			$data['prontuarios'] = $this->prontuario_model->select('id, nome')->get();
		}
		echo json_encode($data);
	}
	public function getvaluesinputs()
	{
		$data['inputs'] = $this->prontuario_model->get($this->input->post('id'));
		foreach ($data['inputs'] as $key => $value)
		{
			$data_temp[sha1($this->prontuario_model->table().'.'.$key)] = $value;
		}
		$data['inputs'] = $data_temp;
		echo json_encode($data);
	}
	public function cid10()
	{
		$data['cid10'] = $this->prontuariocid10_model->get( array('prontuario_id'=>$this->input->post('id')) );
		echo json_encode($data);
	}
	public function prescricoes()
	{
		$data['prescricoes'] = $this->prontuarioprescricao_model->select('id, medicamento, posologia, quantidade')->get( array('prontuario_id'=>$this->input->post('id')) );
		echo json_encode($data);
	}
	public function examesanexos()
	{
		//sleep(2);
		$data['examesanexos'] = $this->prontuarioexameanexo_model->get( array('prontuario_id'=>$this->input->post('id')) );
		echo json_encode($data);
	}
	public function cartasatestados()
	{
		//sleep(2);
		$data['cartasatestados'] = $this->prontuariocartaatestado_model->get( array('prontuario_id'=>$this->input->post('id')) );
		echo json_encode($data);
	}
	public function odontograma()
	{
		$data['odontograma'] = $this->prontuarioodontograma_model->get( array('prontuario_id'=>$this->input->post('id')) );
		echo json_encode($data);
	}
	//############################################################################################################
	//############################################################################################################
	public function Upload()
	{
		$config['upload_path']	= './uploads/';
		if( !is_dir($config['upload_path']) ){ mkdir($config['upload_path']); } // Criar pasta se não existir
		$config['allowed_types'] = 'gif|jpg|png|pdf';
		// $config['max_size']= 1;
		// $config['min_width']= 800;
		$config['file_ext_tolower'] = true;
		$config['encrypt_name']  = TRUE;
		// $config['max_width']= 800;
		//$config['max_height'] = 500;
		$this->load->library('upload', $config);

		if( !$this->upload->do_upload('file') )
		{
			$erros = array();
			$erros['file'] = $this->upload->display_errors();
			$response['erros'] = array_filter($erros);
			$response['status'] = 0;
			echo json_encode($response);
			exit;
		}
		else
		{
			$upload = $this->upload->data();
			// $config['image_library'] = 'gd2';
			// $config['source_image'] = './uploads/'.$upload['file_name'];
			// $config['maintain_ratio'] = TRUE;
			// $config['width'] = 800;
			// $this->load->library('image_lib', $config);
			// $this->image_lib->resize();

			$data = array(
				'prontuario_id'=>$this->input->post('prontuario_id'),
				'arquivo'=>$upload['file_name'],
				'data'=>date('Y-m-d H:i:s'),
				'descricao'=>$this->input->post('txtDescricaoExamesAnexos'),
			);
			$this->prontuarioexameanexo_model->insert($data);

			$response['arquivos'] = $this->prontuarioexameanexo_model->get( array('prontuario_id'=>$this->input->post('prontuario_id')) );

			$response['status'] = 1;
			$response['arquivo']  = $upload['file_name'];
			$response['msg'] = 'Registro adicionado com sucesso!';
		}
		echo json_encode($response);
	}
	public function excluir_upload()
	{
		$tmp = (object) $this->prontuarioexameanexo_model->get( $this->input->post('id') );
		if( $tmp )
		{
			$this->prontuarioexameanexo_model->delete( $this->input->post('id') );
			@unlink('uploads/'.$tmp->arquivo);

			$response['status'] = 1;
			$response['msg'] = 'Registro excluído com sucesso!';
		}
		else
		{
			$response['status'] = 0;
			$response['msg'] = 'Erro ocorrido na operação!';
		}
		echo json_encode($response);
	}
	public function salvarcartasatestados()
	{
		$this->form_validation->set_rules('txtDataCartaAtestado', strong('Data'), 'trim|required');
		$this->form_validation->set_rules('txtCartasAtestados', strong('Cartas e Atestados'), 'trim|required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
				'prontuario_id'=>$this->input->post('prontuario_id'),
				'texto'=>$this->input->post('txtCartasAtestados'),
				'data'=>date_to_us($this->input->post('txtDataCartaAtestado')),
			);
			$this->prontuariocartaatestado_model->insert($data);
			$response['status'] = 1;
			$response['msg'] = 'Registro adicionado com sucesso!';
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
		}
		echo json_encode($response);
	}
	public function excluir_cartaatestado()
	{
		$tmp = $this->prontuariocartaatestado_model->delete( $this->input->post('id') );
		if( $tmp )
		{
			$response['status'] = 1;
			$response['msg'] = 'Registro excluído com sucesso!';
		}
		else
		{
			$response['status'] = 0;
			$response['msg'] = 'Erro ocorrido na operação!';
		}
		echo json_encode($response);
	}
	public function salvarcid10()
	{
		$data = array(
			'prontuario_id'=>$this->input->post('prontuario_id'),
			'cid10'=>$this->input->post('cid10'),
		);
		$this->prontuariocid10_model->insert($data);
		$response['status'] = 1;
		$response['msg'] = 'Registro adicionado com sucesso!';
		echo json_encode($response);
	}
	public function excluir_cid10()
	{
		$tmp = $this->prontuariocid10_model->delete( $this->input->post('id') );
		if( $tmp )
		{
			$response['status'] = 1;
			$response['msg'] = 'Registro excluído com sucesso!';
		}
		else
		{
			$response['status'] = 0;
			$response['msg'] = 'Erro ocorrido na operação!';
		}
		echo json_encode($response);
	}
	public function salvarprescricoes()
	{
		$this->form_validation->set_rules('txtMedicamento', strong('Medicamento'), 'trim|required');
		$this->form_validation->set_rules('txtQuantidade', strong('Quantidade'), 'trim|required');
		$this->form_validation->set_rules('txtPosologia', strong('Posologia'), 'trim|required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
				'prontuario_id'=>$this->input->post('prontuario_id'),
				'medicamento'=>$this->input->post('txtMedicamento'),
				'quantidade'=>$this->input->post('txtQuantidade'),
				'posologia'=>$this->input->post('txtPosologia'),
			);
			$this->prontuarioprescricao_model->insert($data);
			$response['status'] = 1;
			$response['msg'] = 'Registro adicionado com sucesso!';
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
		}
		echo json_encode($response);
	}
	public function excluir_prescricao()
	{
		$tmp = $this->prontuarioprescricao_model->delete( $this->input->post('id') );
		if( $tmp )
		{
			$response['status'] = 1;
			$response['msg'] = 'Registro excluído com sucesso!';
		}
		else
		{
			$response['status'] = 0;
			$response['msg'] = 'Erro ocorrido na operação!';
		}
		echo json_encode($response);
	}
	public function salvarodontograma()
	{
		$this->form_validation->set_rules('txtProcedimento', strong('Procedimento'), 'trim|required');

		if( $this->form_validation->run() == true )
		{
			$data = array(
				'prontuario_id'=>$this->input->post('prontuario_id'),
				'local'=>$this->input->post('txtLocal'),
				'procedimento'=>$this->input->post('txtProcedimento'),
			);
			$this->prontuarioodontograma_model->insert($data);
			$response['status'] = 1;
			$response['msg'] = 'Registro adicionado com sucesso!';
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
		}
		echo json_encode($response);
	}
	public function excluir_odontograma()
	{
		$tmp = $this->prontuarioodontograma_model->delete( $this->input->post('id') );
		if( $tmp )
		{
			$response['status'] = 1;
			$response['msg'] = 'Registro excluído com sucesso!';
		}
		else
		{
			$response['status'] = 0;
			$response['msg'] = 'Erro ocorrido na operação!';
		}
		echo json_encode($response);
	}
}
/* End of file Prontuarios.php */
/* Location: ./application/controllers/Prontuarios.php */
