<?php
	function medicamentos_bootstrap_anvisa($medicamentos = array())
	{
		$html_medicamentos = '';
		foreach ($medicamentos as $value => $key)
		{
			//$html_medicamentos .= '<a class="list-group-item" href="javascript:void(0)" onclick="mostra_dados_medicamentos(\''.$medicamentos[$value]['medicamento'].'\',\''.$medicamentos[$value]['empresa'].'\',\''.$medicamentos[$value]['expediente'].'\',\''.$medicamentos[$value]['data_publicacao'].'\',\''.$medicamentos[$value]['bula_paciente_transacao'].'\',\''.$medicamentos[$value]['bula_paciente_anexo'].'\',\''.$medicamentos[$value]['bula_profissional_transacao'].'\',\''.$medicamentos[$value]['bula_profissional_anexo'].'\')">'.$medicamentos[$value]['medicamento'].'</a>';


			// LINK PARA MODAL (Precisa descomentar MODAL na View)
			//<td><a style="color:#000;" href="javascript:void(0)" onclick="mostra_dados_medicamentos(\''.$medicamentos[$value]['medicamento'].'\',\''.$medicamentos[$value]['empresa'].'\',\''.$medicamentos[$value]['expediente'].'\',\''.$medicamentos[$value]['data_publicacao'].'\',\''.$medicamentos[$value]['bula_paciente_transacao'].'\',\''.$medicamentos[$value]['bula_paciente_anexo'].'\',\''.$medicamentos[$value]['bula_profissional_transacao'].'\',\''.$medicamentos[$value]['bula_profissional_anexo'].'\')">'.$medicamentos[$value]['medicamento'].'</a></td>



									// <td>'.nome_proprio($medicamentos[$value]['medicamento']).'</td>
									// <td>'.nome_proprio($medicamentos[$value]['empresa']).'</td>

			$html_medicamentos .= '
								<tr>
									<td>'.nome_proprio($medicamentos[$value]['medicamento']).'</td>
									<td>'.nome_proprio($medicamentos[$value]['empresa']).'</td>
									<td class="text-center">'.$medicamentos[$value]['expediente'].'</td>
									<td class="text-center" style="width:120px;"><div class="badge bg-green">'.$medicamentos[$value]['data_publicacao'].'</div></td>
									<td class="text-center" style="width:140px;"><a target="_black" href="http://www.anvisa.gov.br/datavisa/fila_bula/frmVisualizarBula.asp?pNuTransacao='.$medicamentos[$value]['bula_paciente_transacao'].'&pIdAnexo='.$medicamentos[$value]['bula_paciente_anexo'].'"><img width="24" height="24" src="'.base_url('assets/img/iconepdf.png').'"></a></td>
									<td class="text-center" style="width:140px;"><a target="_black" href="http://www.anvisa.gov.br/datavisa/fila_bula/frmVisualizarBula.asp?pNuTransacao='.$medicamentos[$value]['bula_profissional_transacao'].'&pIdAnexo='.$medicamentos[$value]['bula_profissional_anexo'].'"><img width="24" height="24" src="'.base_url('assets/img/iconepdf.png').'"></a></td>
								</tr>';
		}
		//$html_medicamentos = '<div class="list-group">'.$html_medicamentos.'</div>';
		$html_medicamentos = '
							<table class="table table-striped table-bordered">
								<tbody>
									<tr>
										<th>Nome</th>
										<th>Empresa</th>
										<th class="text-center">Expediente</th>
										<th class="text-center">Publicação</th>
										<th class="text-center">Bula paciente</th>
										<th class="text-center">Bula profissional</th>
									</tr>
									'.$html_medicamentos.'
								</tbody>
							</table>
						';

		return $html_medicamentos;
	}
	function paginacao_bootstrap_anvisa($paginas = array()) // keys=> índices conts | values => número das páginas
	{
		if( sizeof($paginas) == 0 )
		{
			return false;
		}
		//######################################################################################################################
		$html_paginas = '';
		$link_anterior = '';
		$link_posterior = '';
		$pg_tmp = '';

		$ultima_pagina = $paginas['ultima_pagina'];
		$pagina_atual = $paginas['atual'];
		$paginas = array_unique($paginas);

		foreach($paginas as $key => $pagina)
		{
			if( $key == 'atual' )
			{
				$html_paginas .= '<li class="active"><a href="javascript:void(0)">'.$pagina.' <span class="sr-only">(current)</span></a></li>';
			}
			else
			{
				$html_paginas .= '<li><a href="javascript:void(0)" onclick="javascript:pg('.$pagina.')">'.$pagina.'</a></li>';
			}
		}
		//######################################################################################################################
		if($pagina_atual == 1)
		{
			$link_anterior = '<li class="disabled"><a href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		}
		else
		{
			$link_anterior = '<li><a href="javascript:void(0)" onclick="javascript:pg('.($pagina_atual-1).')" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		}

		if( $pagina_atual == $ultima_pagina )
		{
			$link_posterior = '<li class="disabled"><a href="javascript:void(0)" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		}
		else
		{
			$link_posterior = '<li><a href="javascript:void(0)" onclick="javascript:pg('.($pagina_atual+1).')" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		}
		//######################################################################################################################
		$paginacao = '
			<nav>
				<ul class="pagination pagination-sm no-margin pull-right">
					'.$link_anterior.'
					'.$html_paginas.'
					'.$link_posterior.'
				</ul>
			</nav>
		';
		return $paginacao;
	}