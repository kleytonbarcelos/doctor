<?php
	function alert_success($msg)
	{
		$html = '
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						'.$msg.'
					</div>
				';
		return $html;
	}
	function alert_danger($msg)
	{
		$html = '
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						'.$msg.'
					</div>
				';
		return $html;
	}
	function alert_warning($msg)
	{
		// if($tipo=='success'){$icone='fa-check-circle';}
		// if($tipo=='danger'){$icone='fa-times-circle';}
		// if($tipo=='warning'){$icone='fa-exclamation-triangle';}

		$html = '
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						'.$msg.'
					</div>
				';
		return $html;
	}