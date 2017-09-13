<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cid10 extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cid10_model');
	}
	public function index($id=null)
	{
		$this->cid10_model->_table = 'cid10_capitulos';
		$data['dados'] = $this->cid10_model->get();
		$this->template->load('AdminLTE/index', 'Cid10/index', $data);
	}
	public function capitulos()
	{
		$html = null;

		$this->cid10_model->_table = 'cid10_capitulos';
		$capitulos = $data['dados'] = $this->cid10_model->get();
		foreach ($capitulos as $capitulo)
		{
			$html .= '<a href="javascript:void(0)" class="list-group-item" data-destino="grupos" data-id="'.$capitulo->id.'"><span class="label label-success label-cid10-capitulos">'.$capitulo->categoria_inicio.'-'.$capitulo->categoria_fim.'</span>'.$capitulo->descricao.'</a><div></div>';
		}

		$data['status'] = 1;
		$data['html'] = $html;
		echo json_encode($data);
	}
	public function grupos()
	{
		$html = null;
		$this->cid10_model->_table = 'cid10_grupos';

		$grupos = $this->cid10_model->get( array('capitulo_id'=>$this->input->post('id')) );
		foreach ($grupos as $grupo)
		{
			$html .= '<a href="javascript:void(0)" class="list-group-item" data-destino="categorias" data-id="'.$grupo->id.'"><span class="label label-info label-cid10-grupos">'.$grupo->categoria_inicio.'-'.$grupo->categoria_fim.'</span>'.$grupo->descricao.'</a><div></div>';
		}
		$data['status'] = 1;
		$data['html'] = $html;
		echo json_encode($data);
	}
	public function categorias()
	{
		$html = null;

		$this->cid10_model->_table = 'cid10_grupos';
		$grupo = $this->cid10_model->get( $this->input->post('id') );
		$intervalo = array();
		for($i=$grupo->categoria_inicio; $i <= $grupo->categoria_fim; $i++)
		{
			$intervalo[] = $i;
		}

		$this->cid10_model->_table = 'cid10_categorias';
		$categorias = $this->cid10_model->get(array('categoria'=>$intervalo));
		foreach ($categorias as $categoria)
		{
			$html .= '<a href="javascript:void(0)" class="list-group-item" data-destino="subcategorias" data-id="'.$categoria->id.'"><span class="label label-warning label-cid10-categorias">'.$categoria->categoria.'</span>'.$categoria->descricao.'</a><div></div>';
		}
		$data['status'] = 1;
		$data['html'] = $html;
		echo json_encode($data);
	}
	public function subcategorias()
	{
		$html = null;

		$this->cid10_model->_table = 'cid10_categorias';
		$categoria = $this->cid10_model->get( $this->input->post('id') );

		$this->cid10_model->_table = 'cid10_subcategorias';
		$sub_categorias = $this->cid10_model->like(array('categoria'=>$categoria->categoria))->get();
		foreach ($sub_categorias as $sub_categoria)
		{
			$html .= '<a href="javascript:void(0)" class="list-group-item" data-id="'.$sub_categoria->id.'"><span class="label label-danger label-cid10-subcategorias">'.$sub_categoria->categoria.'</span>'.$sub_categoria->descricao.'</a>';
		}
		$data['status'] = 1;
		$data['html'] = $html;
		echo json_encode($data);
	}
	public function pesquisar()
	{
		$html = null;
		//##################################################################################################################
		//##################################################################################################################
		$this->cid10_model->_table = 'cid10_grupos';
		$grupos = $this->cid10_model->find( array('descricao'=>$this->input->post('search')) );
		foreach ($grupos as $grupo)
		{
			$html .= '<a href="javascript:void(0)" class="list-group-item" data-destino="categorias" data-id="'.$grupo->id.'"><span class="label label-info label-cid10-grupos">'.$grupo->categoria_inicio.'-'.$grupo->categoria_fim.'</span><span class="descricao_cid10">'.$grupo->descricao.'</span></a><div></div>';
		}
		$this->cid10_model->_table = 'cid10_categorias';
		$categorias = $this->cid10_model->find( array('descricao'=>$this->input->post('search')) );
		foreach ($categorias as $categoria)
		{
			$html .= '<a href="javascript:void(0)" class="list-group-item" data-destino="subcategorias" data-id="'.$categoria->id.'"><span class="label label-warning label-cid10-categorias">'.$categoria->categoria.'</span><span class="descricao_cid10">'.$categoria->descricao.'</span></a><div></div>';
		}
		$this->cid10_model->_table = 'cid10_subcategorias';
		$sub_categorias = $this->cid10_model->find( array('descricao'=>$this->input->post('search')) );
		foreach ($sub_categorias as $sub_categoria)
		{
			$html .= '<a href="javascript:void(0)" class="list-group-item" data-id="'.$sub_categoria->id.'"><span class="label label-danger label-cid10-subcategorias">'.$sub_categoria->categoria.'</span><span class="descricao_cid10">'.$sub_categoria->descricao.'</span></a>';
		}
		//##################################################################################################################
		//##################################################################################################################
		$data['status'] = 1;
		$data['html'] = $html;
		echo json_encode($data);
	}
	// public function capitulos($capitulo_id=null,$grupo=null,$grupo_id=null)
	// {
	// 	if($capitulo_id)
	// 	{
	// 		$this->cid10_model->_table = 'cid10_grupos';
	// 		$data['grupos'] = $this->cid10_model->get( array('capitulo_id'=>$capitulo_id) );

	// 		foreach ($data['grupos'] as $key => $value)
	// 		{
	// 			$intervalo = array();
	// 			for($i=$value->categoria_inicio; $i <= $value->categoria_fim; $i++)
	// 			{
	// 				$intervalo[] = $i;
	// 			}
	// 			$this->cid10_model->_table = 'cid10_categorias';
	// 			$data['grupos'][$key]->{'categorias'} = $this->cid10_model->get(array('categoria'=>$intervalo));
	// 		}
	// 		$data['capitulo'] = $capitulo_id;
	// 		$data['grupo'] = $grupo;
	// 		$this->template->load('AdminLTE/index', 'Cid10/grupos', $data);
	// 	}
	// 	else
	// 	{
	// 		$this->cid10_model->_table = 'cid10_capitulos';
	// 		$data['dados'] = $this->cid10_model->get();
	// 		$this->template->load('AdminLTE/index', 'Cid10/capitulos', $data);
	// 	}
	// }
}
/* End of file Cid10.php */
/* Location: ./application/controllers/Cid10.php */