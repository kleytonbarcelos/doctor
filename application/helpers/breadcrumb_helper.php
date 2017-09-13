<?php
	function breadcrumb($Pg, $Acao)
	{
		$Html = '';
		$Html .= '<ol class="breadcrumb">';
		if( $Pg != 'home' )
		{
			if( !empty($Pg) && !empty($Acao) )
			{
				$Html .= '<li><a href="'.base_url().'"><i class="fa fa-home"></i> <strong>Home</strong></a></li>';
				$Html .= '<li><a href="'.base_url().$Pg.'">'.ucfirst($Pg).'</a></li>';
				$Html .= '<li class="active">'.ucfirst($Acao).'</li>';
			}
			else if( !empty($Pg) && empty($Acao) )
			{
				$Html .= '<li><a href="'.base_url().'"><i class="fa fa-home"></i> <strong>Home</strong></a></li>';
				$Html .= '<li class="active"><a href="'.base_url().'/'.$Pg.'"'.ucfirst($Pg).'</a></li>';
			}
			else if( empty($Pg) && empty($Acao) )
			{
				$Html .= '<li><a href="'.base_url().'"><i class="fa fa-home"></i> <strong>Home</strong></a></a></li>';
			}
		}
		else
		{
			$Html .= '<li><a href="'.base_url().'"><i class="fa fa-home"></i> <strong>Home</strong></a></a></li>';
		}
		$Html .= '</ol>';
		return $Html;
	}