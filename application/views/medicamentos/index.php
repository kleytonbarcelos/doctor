<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-medkit"></i> Bulas de A a Z</h3>
	</div>
	<div class="panel-body">
		<div class="letras">
			<?php
				$cont = 0;
				foreach(range('A', 'Z') as $letra)
				{
					?>
						<div class="pull-left" style="padding:5px;text-align: center;"><div class="divcircle cursor-pointer letra" style="width:40px;height:40px;background-color: #222D32" data-url="<?=$this->base_url_controller?>letra/<?=$letra?>"><?=$letra?></div></div>
					<?php
					if($cont==12)
					{
						//echo '<div class="clearfix"></div>';
					}
					$cont++;
				}
			?>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-precos">
	<div class="modal-dialog">
		<div class="modal-content modal-lg">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-dollar"></i> Preços médios</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle-o"></i> Fechar</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function()
	{
		$('.letra').click(function(event)
		{
			event.preventDefault();
			window.location.href=$(this).data('url');
		});
	});
</script>