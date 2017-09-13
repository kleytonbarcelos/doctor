<!-- <h4>
	<span class="label label-info cursor-pointer" onclick="window.location.href='<?=$this->base_url_controller?>capitulos'"><i class="fa fa-tag"></i> Capítulos</span>
	&nbsp;&nbsp;
	<span class="label label-warning"><i class="fa fa-tag"></i> Grupos</span>
</h4>
<br>
<div class="list-group">
<?php
	foreach ($grupos as $grupo)
	{
		echo '<a class="list-group-item" href="'.$this->base_url_controller.'capitulos/'.$capitulo.'/grupo/'.$grupo->id.'"><span class="label label-warning">'.$grupo->categoria_inicio.' '.$grupo->categoria_fim.'</span> '.$grupo->descricao.'</a>';
		foreach ($grupo->categorias as $key => $categorias)
		{
			echo '<a style="text-indent:40px;" class="list-group-item" href="'.$this->base_url_controller.'capitulos/'.$capitulo.'/grupo/'.$grupo->id.'/categoria/'.$categorias->id.'"><span class="label label-warning">'.$categorias->categoria.'</span> '.$categorias->descricao.'</a></h4></li>';
		}
	}
?>
</div>
 -->
<h4>
	<span class="cursor-pointer" onclick="window.location.href='<?=$this->base_url_controller?>capitulos'"><i class="fa fa-tag"></i> <strong>Capítulos</strong></span>
	&nbsp;&raquo;&nbsp;
	<span>Grupos</span>
</h4>
<div class="list-group">
<?php
	foreach ($grupos as $grupo)
	{
		echo '<a class="list-group-item" href="'.$this->base_url_controller.'capitulos/'.$capitulo.'"><kbd>'.$grupo->categoria_inicio.'-'.$grupo->categoria_fim.'</kbd>&nbsp;'.$grupo->descricao.'</a>';
		foreach ($grupo->categorias as $key => $categorias)
		{
			echo '<a style="text-indent:40px;" class="list-group-item" href="'.$this->base_url_controller.'capitulos/'.$capitulo.'/grupo/'.$grupo->id.'/categoria/'.$categorias->id.'"><kbd>'.$categorias->categoria.'</kbd>&nbsp;'.$categorias->descricao.'</a></h4></li>';
		}
	}
?>
</div>
<style type="text/css">
	kbd
	{
		background-color: #eee;
		color: #333;
		border: 1px solid #ccc;
		font-weight: bold;
	}
</style>