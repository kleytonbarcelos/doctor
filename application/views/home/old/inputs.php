<script type="text/javascript">
	var json = [];
</script>
<style type="text/css">
	.group-inputs .panel-body
	{
		position: relative;
	}
	.divControls
	{
		display: none;
	}
	.group-inputs .panel-body:hover
	{
		border: 2px dashed #ddd;
		background-color: #fafafa;
		cursor: move;
	}
	.group-inputs .panel-body:hover .divControls
	{
		position:absolute;
		left:50%;
		top:50%;
		margin-top: -40px;
		margin-left: -50px;
		display: block;
	}
</style>
<div class="modal fade" id="modalCadastraInputs">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="formInputs" name="formInputs" action="<?=base_url('inputs/salvar')?>" method="POST">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-inbox"></i> Dados do Input</h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs nav-justified" role="tablist">
						<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Dados Básicos</a></li>
						<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Avançado</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="home">
							<div class="row">
								<div class="col-md-8">
									<div class="form-group form-group-sm">
										<label for="name" class="control-label">Nome</label>
										<input type="text" class="form-control" id="name" name="name" placeholder="Nome">
									</div>
								</div>
								<div class="col-md-4" style="margin-top:18px;">
									<div class="form-group form-group-sm">
										<div class="checkbox"><label><input type="checkbox" id="required" name="required" data-value="required"> Requerido</label></div>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<label for="value" class="control-label">Valor Padrão</label>
										<input type="text" class="form-control" id="value" name="value" placeholder="Valor Padrão">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<label for="type" class="control-label">Tipo</label>
										<select class="form-control" id="type" name="type">
											<option value="text">Text</option>
											<option value="email">Email</option>
											<option value="password">Password</option>
											<option value="radio">Radio</option>
											<option value="checkbox">Checkbox</option>
											<option value="select">Select</option>
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<label for="placeholder" class="control-label">Placeholder</label>
										<input type="text" class="form-control" id="placeholder" name="placeholder" placeholder="Placeholder">
									</div>
								</div>
							</div>
							<div class="row options">
								<hr>
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<input type="button" class="btn btn-default btn-sm btn-test3" value="Clique Aqui (Teste)">
										<script type="text/javascript">
											$(function()
											{
												$('.btn-test3').click(function(event)
												{
												});
											});
										</script>
										<label for="Options" class="control-label">Options <span class="btn btn-xs btn-success add-option"><i class="fa fa-plus"></i></span></label>
										<br><br>
										<div class="list_options">
											<div class="form-group form-group-sm">
												<div class="row">
													<div class="col-md-8 col-md-offset-2">
														<div class="input-group input-group-sm">
															<input type="text" class="form-control" data-value="" name="option1" placeholder="option">
															<div class="input-group-btn">
																<button type="button" class="btn btn-danger excluir_option"><i class="fa fa-minus"></i></button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane" id="profile">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="maxlength" class="control-label">Maxlength</label>
										<input type="text" class="form-control" id="maxlength" name="maxlength" placeholder="Maxlength">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="min" class="control-label">Min</label>
										<input type="text" class="form-control" id="min" name="min" placeholder="Min">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="max" class="control-label">Max</label>
										<input type="text" class="form-control" id="max" name="max" placeholder="Max">
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="step" class="control-label">Step</label>
										<input type="text" class="form-control" id="step" name="step" placeholder="Step">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label for="size" class="control-label">Size</label>
										<input type="text" class="form-control" id="size" name="size" placeholder="Size">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group form-group-sm">
										<label for="pattern" class="control-label">Pattern</label>
										<input type="text" class="form-control" id="pattern" name="pattern" placeholder="Pattern (regexp)">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<label for="autocomplete" class="control-label">autocomplete</label>
										<select id="autocomplete" name="autocomplete" class="form-control">
											<option value=""></option>
											<option value="on">on</option>
											<option value="off">off</option>
										</select>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<label for="spellcheck" class="control-label">spellcheck</label>
										<select id="spellcheck" name="spellcheck" class="form-control">
											<option value=""></option>
											<option value="off">off</option>
											<option value="on">on</option>
										</select>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<label for="dir" class="control-label">Dir</label>
										<select id="dir" name="dir" class="form-control">
											<option value=""></option>
											<option value="auto">auto</option>
										</select>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<div class="checkbox"><label><input type="checkbox" id="disabled" name="disabled" data-value="disabled"> disabled</label></div>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<div class="checkbox"><label><input type="checkbox" id="autofocus" name="autofocus" data-value="autofocus"> autofocus</label></div>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group form-group-sm">
										<div class="checkbox"><label><input type="checkbox" id="readonly" name="readonly" data-value="readonly"> readonly</label></div>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Criar Input</button>
			</div>
			</form>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">New Input</h3>
				</div>
				<div class="panel-body">
					<button class="btn btn-primary show_modal_input"><i class="fa fa-plus"></i> Add Input</button>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Fields</h3>
				</div>
				<div class="panel-body">
					<textarea rows="5" class="form-control console"></textarea>
					<br>
					<input type="button" class="btn btn-warning" value="JSON" onclick="aaa()">
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function aaa()
		{
			$('.console').val( JSON.stringify(json) );
		}
		function excluir_input(name)
		{
			json = json.filter(function(index)
			{
				return index.name != name;
			});
		}
		function clear_inputs_modal()
		{
			$('#formInputs input').val('');
			$('#formInputs textarea').val('');
			$('.options').hide();

			clear_form_erros();
			clear_options();
		}
		function clear_form_erros()
		{
			$('.msg-erro').html('');
			$('.has-error').removeClass('has-error');
			$('.modal-msg').html('');
			$('.nav-tabs').find('.cont').html(''); // Limpa contadores de erros (NAVTABS)
			$('.nav-tabs a:first').tab('show');
		}
		function clear_options()
		{
			$('.list_options .form-group').not(':first').remove();
		}
		function show_modal_input()
		{
			$('#modalCadastraInputs').modal('show');
			clear_inputs_modal();
		}
		function hide_modal_input()
		{
			$('#modalCadastraInputs').modal('hide');
		}
		$(function()
		{
			// ###########################################################################
			$('.options input').on('blur', function(event)
			{
				$element = $(this);
				slug = $element.val().slug();
				$element.attr({'data-value': slug});
			});
			// ###########################################################################
			$('#name').keyup(function(event)
			{
				$('#placeholder').val( $(this).val() );
			}).blur(function(event)
			{
				$('#placeholder').val( $(this).val() );
			});
			// ###########################################################################
			$('#type').change(function(event)
			{
				if( $(this).val() == 'select' || $(this).val() == 'radio' )
				{
					$('.options').show();
				}
				else
				{
					$('.options').hide();
				}
			});
			$('.show_modal_input').click(function(event)
			{
				show_modal_input();
			});
			$('.add-option').on('click', function(event)
			{
				event.preventDefault();
				cont = $('.options input:text').size() + 1;
				$('.list_options').append( $('.list_options').find('.form-group:last').clone() );
				$('.list_options').find('.form-group:last').find('input').val('').attr({'name':'option'+cont});
			});
			$('body').on('click', '.excluir_option', function(event)
			{
				event.preventDefault();
				if($('.list_options .form-group').size() > 1)
				{
					$(this).parents('.form-group').eq(0).remove();
				}
			});
			$('#formInputs').on('submit', function(event)
			{
				event.preventDefault();
				var input = {};
				//#######################################################################################
				// FIX para correção de erros de enviar input:checbox VAZIOS juntos com os outros campos via ajax.
				$(this).find(':checkbox').each(function(index, el)
				{
					if( $(el).prop('checked') == false )
					{
						value = ($(el).data('value')) ? $(el).data('value') : 'off';
						$(el).prop('value', value);
						$(el).prop('checked', false);
					}
					else
					{
						value = ($(el).data('value')) ? $(el).data('value') : 'on';
						$(el).prop('value', value);
						$(el).prop('checked', true);
					}
				});
				//#######################################################################################
				var inputs = $(this).serializeArray();
				$.each(inputs, function(index, val)
				{
					if(val.value)
					{
						input[val.name] = val.value;
					}
				});
				//#######################################################################################
				var options = {};
				$('.options input:text').each(function(index, el)
				{				
					console.log( $(el) );
					
					if( $(el).val().length ) // inputs (Options) não vazios
					{
						options[index] = {value:$(el).attr('data-value'), text:$(el).val()};
					}
				});
				if( sizeof(options) )
				{
					input['options'] = options;
				}
				//#######################################################################################
				if( (input.type != 'select') && (input.type != 'radio') && (input.type != 'checkbox') )
				{
					var attributes = '';
					var attributes_accepts = ['name','value','type','placeholder','maxlength','min','max','step','size','pattern','autocomplete','spellcheck','dir'];
					$.each(input, function(index, val)
					{
						if( $.inArray(index, attributes_accepts) >= 0 )
						{
							attributes +=' '+index+'='+val;
						}
					});
					var html = '';
					html = '<li id="'+($('.group-inputs li').size()+1)+'"><div class="panel panel-default"><div class="panel-body"><div class="form-group form-group-sm"><label class="control-label" for="'+input.name+'">'+input.name+'</label><input class="form-control"'+attributes+'></div><div class="divControls"><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Editar</button> <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Excluir</button></div></li>';
					$(html).appendTo('.group-inputs');
				}
				else
				{
					if(input.type == 'select')
					{
						var attributes = '';
						var attributes_accepts = ['name','value'];
						$.each(input, function(index, val)
						{
							if( $.inArray(index, attributes_accepts) >= 0 )
							{
								attributes +=' '+index+'='+val;
							}
						});
						var html = '';
						input_html = '<select class="form-control"'+attributes+'>';
						html = '<div class="form-group form-group-sm"><label class="control-label" for="'+input.name+'">'+input.name+'</label>'+input_html+'</div>';
						$(html).appendTo('.group-inputs');
						$.each(options, function(key, val)
						{
							$('[name="'+input.name+'"]').append('<option value="'+val.value+'">'+val.text+'</option>');
						});
					}
					else if(input.type == 'checkbox')
					{
						var attributes = '';
						var attributes_accepts = ['name','value', 'type'];
						$.each(input, function(index, val)
						{
							if( $.inArray(index, attributes_accepts) >= 0 )
							{
								attributes +=' '+index+'='+val;
							}
						});
						var html = '';
						html = '<div class="checkbox"><label><input'+attributes+'>'+input.name+'</label></div>';
						$(html).appendTo('.group-inputs');

						var html_radio = '';
						$.each(options, function(key, value)
						{
							html_radio += '<input type="'+input.type+'" name="'+input.name+'">';
							// $('[name="'+input.name+'"]')
							// .append($('<option></option>')
							// .attr('value', value.value)
							// .text(value.text));
						});
					}
					else if(input.type == 'radio')
					{
						var attributes = '';
						var attributes_accepts = ['name','value'];
						$.each(input, function(index, val)
						{
							if( $.inArray(index, attributes_accepts) >= 0 )
							{
								attributes +=' '+index+'='+val;
							}
						});
						var html = '';
						select = '<select class="form-control"'+attributes+'>';
						html = '<div class="form-group form-group-sm"><label class="control-label" for="'+input.name+'">'+input.name+'</label>'+select+'</div>';
						$(html).appendTo('.group-inputs');

						var html_radio = '';
						$.each(options, function(key, value)
						{
							html_radio += '<input type="'+input.type+'" name="'+input.name+'">';
							// $('[name="'+input.name+'"]')
							// .append($('<option></option>')
							// .attr('value', value.value)
							// .text(value.text));
						});
					}
				}
				json.push(input);
				hide_modal_input();
				//$('.list_inputs').append();
				// $.ajax(
				// {
				//	 url: Form.attr('action'),
				//	 type: Form.attr('method'),
				//	 data: Form.serialize(),
				//	 dataType: 'input',
				//	 success: function(data)
				//	 {
				//		 if(data.status == 1)
				//		 {
				//			 if( data.acao == 'update' )
				//			 {
			
				//			 }
							
				//			 $('#ModalInputs').modal('hide');
				//		 }
				//		 else
				//		 {
				//			 $.each(data.erros, function(campo, valor)
				//			 {
				//				 $('[name='+campo+']').next().html(valor);
				//				 $('[name='+campo+']').parent().addClass('has-error');
				//			 });
				//		 }
				//	 }
				// });
			});
		});
	</script>
	<br><br><br>
	<link rel="stylesheet" href="<?=base_url()?>assets/libs/jquery-ui/jquery-ui-1.12.0.custom/jquery-ui.min.css">
	<style>
		#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
		#sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
		html>body #sortable li { height: 1.5em; line-height: 1.2em; }
		.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
	</style>
	<script src="<?=base_url()?>assets/libs/jquery-ui/jquery-ui-1.12.0.custom/jquery-ui.min.js"></script>
	<script>
		$(function()
		{
			var panelList = $('.group-inputs');
			panelList.sortable(
			{
				update: function()
				{
					$('.panel', panelList).each(function(index, elem)
					{
						 var $listItem = $(elem), newIndex = $listItem.index();
						 //console.log($listItem.index());
					});
				}
			});
		});
	</script>
	<ul class="group-inputs list-unstyled">
<!-- 		<li id="1">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group form-group-sm">
						<label for="txtInput" class="control-label">Input</label>
						<input type="text" class="form-control" id="txtInput" name="txtInput" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('NomeDoCampoNoDB')?>" placeholder="Input" value="<?=set_value('txtInput')?>">
					</div>
				</div>
			</div>
		</li>
		<li id="2">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group form-group-sm">
						<label for="txtSexo" class="control-label">Sexo</label>
						<input type="text" class="form-control" id="txtSexo" name="txtSexo" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('sexo')?>" placeholder="Sexo" value="<?=set_value('txtSexo')?>">
						<small class="msg-erro text-danger"></small>
					</div>
				</div>
			</div>
		</li> -->
	</ul>
	<p>aaaaaaaaaaaaaaaaaaaaaaa</p>
	<input type="button" class="btn btn-danger btn-sm btn-test2" value="Clique Aqui (Teste)">
	<script type="text/javascript">
		$(function()
		{
			$('.btn-test2').click(function(event)
			{
				console.log( $('#group-inputs').sortable('toArray') );
			});
			// $('.group-inputs li').on('mouseenter mouseleave', function(event)
			// {
			// 	$(this).find('.divControls').show();
			// 	top = ($(this).height()/2) - ($('.divControls').height()/2);
			// 	left = ($(this).width()/2) - ($('.divControls').width()/2);
			// 	console.log( 'TOP: '+top+'  |   LEFT:'+left );
			// });



			// $('.group-inputs li').on('hover', function()
			// {
			// 	$(this).find('.divControls').show();
			// 	top = ($(this).height()/2) - ($('.divControls').height()/2);
			// 	left = ($(this).width()/2) - ($('.divControls').width()/2);
			// 	console.log( 'TOP: '+top+'  |   LEFT:'+left );
			// 	// $('.divControls').css({'top':top, 'left':left}).show();
			// },function()
			// {
			// 	console.log( 'NÂO SOBRE' );
			// });
		});
	</script>
</div>