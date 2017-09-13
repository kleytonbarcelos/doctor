<script type="text/javascript">
	$('.titulo').html('<i class="fa fa-calendar"></i> Agenda');
</script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/agenda.css">
<script type="text/javascript">
	var hide_controls_events = null;

	var list_status_events =
	{
		'Agendado':
		{
			'style':'color:#666',
			'icon':'fa fa-calendar',
		},
		'Confirmado':
		{
			//'style':'color:#2095D3',
			'icon':'fa fa-thumbs-o-up',
			'icon':'fa fa-check-circle',
			'style':'color:#1F8332',
		},
		'Aguardando atendimento':
		{
			'style':'color:#FFB342',
			'icon':'fa fa-clock-o',
		},
		'Não compareceu':
		{
			'style':'color:#E70101',
			'icon':'fa fa-ban',
		},
		'Paciente atendido':
		{
			'style':'color:#0378b2',
			'icon':'fa fa-check',
		},
	};

	var duracaoconsulta = <?=$Configuracoes->duracaoconsulta?>;
	var horarioexpedienteinicio = '<?=$Configuracoes->horarioexpedienteinicio?>:00';
	var horarioexpedientefim = '<?=$Configuracoes->horarioexpedientefim?>:00';

	function clear_form()
	{
		$('#formCadastraEvento input').val('');
		$('#formCadastraEvento textarea').val('');
		$('.selectpicker').each(function(index, el)
		{
			$(this).selectpicker('val', $(this).find('option:first').val() );
		});

		clear_form_erros();
	}
	function clear_form_erros()
	{
		$('.msg-erro').html('');
		$('.has-error').removeClass('has-error');
		$('.modal-msg').html('');
		$('.nav-tabs').find('.cont').html(''); // Limpa contadores de erros (NAVTABS)
		$('.nav-tabs a:first').tab('show');
	}
	function excluir()
	{
		id = $('#event_id').val();
		if(id)
		{
			excluir_ajax(id);
		}
	}
	function excluir_ajax(id)
	{
		alertify.confirm('<strong><i class="fa fa-exclamation-circle"></i>&nbsp;Confirmação</strong>', '<strong>Você realmente deseja excluir este(s) registro(s) ?</strong>', function()
		{
			$.ajax(
			{
				url: base_url_controller+'excluir',
				type: 'POST',
				data: 'id='+id,
				dataType: 'json',
				success: function(data)
				{
					if( data.status == 1 )
					{
						//alert_success('.msg', data.msg);
						alertify.success(data.msg);
						
						$('#CadastraEvento').modal('hide');
						$('#modal_event').modal('hide');

						$('#calendar').fullCalendar('removeEvents', id);
						$('#calendar').fullCalendar('refresh');
					}
					else
					{
						alert_danger('.msg', data.msg);
					}
				}
			});
		}, function()
		{

		});
	}
	var FullCalendarOptions =
	{
		// eventColor: '#D0EAF3',
		// eventBorderColor: '#50C2EC',
		// eventTextColor:'#66A7C3',
		nowIndicator:true,
		height: 'auto',
		defaultDate: moment().format('YYYY-MM-DD'),
		defaultView: 'agendaWeek',
		slotDuration: '00:'+duracaoconsulta+':00',
		minTime: horarioexpedienteinicio,
		maxTime: horarioexpedientefim,
		allDaySlot: false,
		slotLabelFormat: 'hh:mm',
		slotLabelInterval: '00:30:00',
		axisFormat: 'hh[h]mm',
		columnFormat: 'dddd DD/MM',
		//dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
		//dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
		defaultDate: moment().format('YYYY-MM-DD'),
		selectable: true,
		selectHelper: true,
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		defaultView: 'agendaWeek',
		customButtons:
		{
			btnCalendario:
			{
				click: function()
				{
					$('#CalendarioAgenda').modal('show');
				}
			},
			btnPesquisa:
			{
				click: function()
				{
					//$('#CalendarioAgenda').modal('show');
				}
			},
			btnImprimir:
			{
				click: function()
				{
					$('#calendar').print();
				}
			},
			btnCadastro:
			{
				click: function()
				{
					//$('#CalendarioAgenda').modal('show');
				}
			},
		},
		header:
		{
			left: 'agendaWeek,agendaDay',
			center: 'prev,today,next',
			right: 'btnCalendario btnPesquisa,btnImprimir btnCadastro'
		},
		select: function(start, end) // Cadastra Evento
		{
			var intervalo = moment.duration(end.diff(start));
			if(intervalo.asMinutes() > parseInt(duracaoconsulta))
			{
				$('#calendar').fullCalendar('unselect');
				return false;
			}
			$('#CadastraEvento').modal('show');
			$('#CadastraEvento').find('#txtStart').val(start.format());
			$('#CadastraEvento').find('#txtEnd').val(end.format());
		},
		eventClick: function(event, jsEvent, view) //Visualiza Evento
		{
			$('#event_id').val(event.id);
			$('#paciente_id').val(event.paciente_id);
			$('#txtTitle').val(event.title);
			$('#txtStart').val(event.start.format());
			$('#txtEnd').val(event.end.format());
			show_event();
		},
		eventDrop: function(event, delta, revertFunc)
		{
			if(event.status == 'Paciente atendido' )
			{
				revertFunc();
			}
			else
			{			
				var URL = 'id='+event.id+'&txtStart='+event.start.format()+'&txtEnd='+event.end.format();
				$.ajax(
				{
					url: base_url_controller+'drop',
					type: 'POST',
					data: URL,
					dataType: 'json',
					success: function(data){}
				});
			}
		},
		eventResize: function(event, delta, revertFunc)
		{
			revertFunc();
			// var intervalo = moment.duration(event.end.diff(event.start));
			// if(intervalo.asMinutes() > parseInt(duracaoconsulta))
			// {
			// 	revertFunc();
			// 	return false;
			// }
			// $.ajax(
			// {
			// 	url: base_url_controller+'salvar',
			// 	type: 'POST',
			// 	data: 'txtTitle='+event.title+'&txtStart='+event.start.format()+'&txtEnd='+event.end.format()+'&paciente_id='+event.paciente_id+'&id='+event.id,
			// 	dataType: 'json',
			// 	success: function(data){}
			// });
		},
		eventAfterRender:function(event, element, view )
		{
			if( event.status == 'Paciente atendido' )
			{
				element.find('.fc-content').css({'cursor': 'no-drop'});
				element.find('.fc-time').append('<i style="font-size:11px;font-weight:bold;margin-right:3px;margin-top:3px;'+list_status_events[event.status].style+'" data-toggle="tooltip" data-container="body" title="'+event.status+'" class="'+list_status_events[event.status].icon+' pull-right"></i>');
			}
			else
			{
				element.find('.fc-time').append('<i style="font-size:11px;font-weight:bold;margin-right:3px;margin-top:3px;'+list_status_events[event.status].style+'" data-toggle="tooltip" data-container="body" title="'+event.status+'" class="'+list_status_events[event.status].icon+' pull-right"></i>');
			}
		},
		eventAfterAllRender: function() // Executado após carregamento da Agenda
		{
			// $('.fc-time').each(function(index, el)
			// {
			// 	$(el).append('<i class="fa fa-check"></i>');
			// });

			$('.fc-day-header').each(function(index, el)
			{
				if( $(el).text().indexOf(' ') > 0 )
				{
					Str = $(el).text().split(' ');
					$(el).html( '<div class="nome-da-semana">'+Str[0]+'</div><div class="dia-da-semana">'+Str[1]+'</div>' );
				}
			});
			//$('.fc-nonbusiness').html('<div style="text-align:center;padding-top:50%;font-size:11px;color:#000;">Indisponível</div>');
			$('.fc-nonbusiness').each(function(index, el)
			{
				altura_elemento = $(el).height();
				position = (altura_elemento>40) ? ((altura_elemento/2) - 28) : ((altura_elemento/2) - 10);
				$(el).html('<div style="text-align:center;margin-top:'+position+'px;font-size:12px;color:#333;font-family:tahoma;">Indisponível</div>');
			});
			//$('.fc-slats table tr:even td').css({'border-top':'transparent', 'border-top':'1px dashed #ccc'});
			//$('.fc-widget-header').css({'border-bottom':'1px dashed #ccc'});



			var segunda_semana_corrente = moment().day(0).format('YYYY-MM-DD');
			var sabado_semana_corrente = moment().day(6).format('YYYY-MM-DD');

			//console.log( moment(segunda_semana_corrente).format('DD') );
			//console.log( moment(sabado_semana_corrente).format('DD') );
			
			var textobtnCalendario = moment(segunda_semana_corrente).format('DD')+'/'+moment(segunda_semana_corrente).format('MM')+' à '+moment(sabado_semana_corrente).format('DD')+'/'+moment(sabado_semana_corrente).format('MM');

			//$('.fc-btnCalendario-button').html('<img src="'+base_url+'assets/img/calendar.png" class="imgCalendarioAgenda">'+textobtnCalendario );

			$('.fc-btnCalendario-button').html('<i class="fa fa-calendar"></i> '+textobtnCalendario);
			$('.fc-btnImprimir-button').html('<i class="fa fa-print"></i>');
			$('.fc-btnPesquisa-button').html('<i class="fa fa-search"></i>');
			$('.fc-btnCadastro-button').html('<i class="fa fa-plus"></i> Adicionar');
			$('.fc-btnCadastro-button').css({'margin-top':'0px'}).removeClass('fc-button fc-state-default fc-corner-left fc-corner-right').addClass('btn btn-primary');
		},
		selectConstraint: 'businessHours',
		eventConstraint: 'businessHours',
		businessHours:
		[
			<?php
				foreach ($Expedientes as $key => $value)
				{
					echo "{\n";
						echo "start: \"".$value["start"]."\",\n";
						echo "end: \"".$value["end"]."\",\n";
						echo "dow: [".$value["dow"]."]\n";
					echo "},\n";
				}
			?>
		],
		events: base_url_controller+'events',
	};
	$(function()
	{
		$('#calendar').fullCalendar(FullCalendarOptions);
		
		$('#CadastraEvento').on('hide.bs.modal', function(e)
		{
			clear_form();
		});
		$('body').on('submit', '#formCadastraEvento', function(event)
		{
			event.preventDefault();
			var Form = $(this);
			clear_form_erros();

			$.ajax(
			{
				url: Form.attr('action'),
				type: Form.attr('method'),
				data: Form.serialize(),
				dataType: 'json',
				success: function(data)
				{
					if(data.status == 1)
					{
						event_status = 'Agendado';

						if( data.acao == 'update' )
						{
							// var event_id = $('#event_id').val();
							// $('#calendar').fullCalendar('removeEvents', event_id);
							// $('#calendar').fullCalendar('refresh');

							$('#calendar').fullCalendar('destroy');
							$.ajax(
							{
								url: base_url_controller+'events',
								type: 'POST',
								dataType: 'json',
								success: function(data)
								{
									FullCalendarOptions['events'] = data;
									$('#calendar').fullCalendar(FullCalendarOptions);
								}
							});
						}
						else
						{
							DadosEvento =
							{
								id: data.id,
								paciente_id: $('#paciente_id').val(),
								title: $('#txtTitle').val(),
								start: $('#txtStart').val(),
								end: $('#txtEnd').val(),
								status: event_status,
								className: 'event-'+$('#txtTipo').val(),
							};
							$('#calendar').fullCalendar('renderEvent', DadosEvento, true);
						 	$('#calendar').fullCalendar('unselect');
						}
						//#################################################################################
						//#################################################################################
						//$('.event_status').html( '<span style="'+list_status_events[data.status].style+'"><i class="'+list_status_events[data.status].icon+'"></i> '+data.status+'</span>' );
						//#################################################################################
						//#################################################################################
						$('#CadastraEvento').modal('hide');
					}
					else
					{
						var msg = '';
						$.each(data.erros, function(campo, valor)
						{
							var Input = $('[name='+campo+']');
							//Input.nextAll('.msg-erro').eq(0).html(valor);
							Input.parents('.form-group').eq(0).addClass('has-error');
							msg += '<div><small>'+valor+'</small></div>';
						});
						$('.modal-msg')
						.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>')
						.show();
					}
				}
			});
		});
	});
	function edit_event()
	{
		$('#modal_event').modal('hide');
		$('#CadastraEvento').modal('show');

		$.ajax(
		{
			url: base_url_controller+'getvaluesinputs',
			type: 'POST',
			data: 'id='+$('#event_id').val(),
			dataType: 'json',
			success: function(data)
			{
				$.each(data.inputs, function(campo, valor) // Preenche Inputs
				{
					console.log( campo );
					$element = $('[data-field-db='+campo+']');
					if( $element.prop('type') == 'text' ) // Element text
					{
						$element.val(valor);
					}
					else if( $element.prop('type') == 'checkbox' )
					{
						if(valor=='on')
						{						
							$element.prop('checked', true);
							$element.prop('value', 'on');
						}
						else
						{
							$element.prop('checked', false);
							$element.prop('value', 'off');
						}
					}
					else if( $element.prop('type') == 'select-one' )
					{
						$element.selectpicker('val', valor);
					}
					else if( $element.prop('type') == 'textarea' )
					{
						$element.val( valor );
					}
					else
					{
						$element.val(valor);
					}
				});
			}
		});
	}
	function show_event()
	{
		if(!hide_controls_events)
		{
			$('.editar_status').show();
			$('.event_controls').find('button').prop('disabled', false);
		}

		var event_inicio_fim = moment($('#txtStart').val()).format("HH:mm")+' - '+moment($('#txtEnd').val()).format("HH:mm");
		$('.event_data').html( moment($('#txtStart').val()).format("dddd, D [de] MMMM")+' - <span class="blue"><strong style="color:#4997D1;">'+event_inicio_fim+'</strong></span>' );

		$('#modal_event').modal('show');
		$.ajax(
		{
			url: base_url_controller+'get',
			type: 'POST',
			data: 'id='+$('#event_id').val(),
			dataType: 'json',
			success: function(data)
			{
				$.ajax(
				{
					url: base_url+'pacientes/get',
					type: 'POST',
					data: 'id='+data.event.paciente_id,
					dataType: 'json',
					success: function(data)
					{
						dados_paciente = data.dados;
						$('.paciente_foto').textAvatar(
						{
							width: 120,
							name: dados_paciente.nome,
						});


						$('#atendimento_paciente_id').val( dados_paciente.id );
						$('.paciente_nome').html( dados_paciente.nome );
						$('.paciente_telefone').html( dados_paciente.telefone+' | '+dados_paciente.celular );
						// foto = ( dados_paciente.sexo == 'M' ) ? 'assets/img/icone_usuario_m.png' : 'assets/img/icone_usuario_f.png';
						// $('.paciente_foto').css({'background-image':'url('+base_url+foto+')','width':'100px','height':'100px','background-position':'center center'});
					}
				});
				
				if( data.event.status=='Paciente atendido' )
				{
					$('.editar_status').hide();
					$('.event_controls').find('button').prop('disabled', true);
				}

				$('.event_status').html('<span style="'+list_status_events[data.event.status].style+'"><i class="'+list_status_events[data.event.status].icon+'"></i> '+data.event.status+'</span>');
				$('.event_tipo').html( primaira_letra_maiuscula(data.event.tipo) );
				$('.event_obs').html(data.event.obs);

			}
		});
	}
	//###############################################################################
	//###############################################################################
	//###############################################################################
</script>
<div class="msg"></div>
<div id='calendar'></div>
<!-- ######################################################################################################### -->
<!-- ########################################	  MODALS (Início)	   ####################################### -->
<!-- ######################################################################################################### -->
<!-- ########################################           INPUTS           ##################################### -->
<!-- ######################################################################################################### -->
<!-- ######################################################################################################### -->
<div class="modal fade" id="modal_event">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-calendar"></i> Dados do agendamento</h4>
			</div>
			<div class="modal-body">
				<table>
					<tbody>
						<tr>
							<td width="140" height="140">
								<!-- <div class="img-circle paciente_foto"></div> -->
								<div class="paciente_foto textavatar"></div>
							</td>
							<td>
								<input type="hidden" name="atendimento_paciente_id" id="atendimento_paciente_id">
								<div class="paciente_nome font-18 font-bold"></div>
								<div class="paciente_telefone font-12 font-blue-ciano"></div>
							</td>
						</tr>
					</tbody>
				</table>
				<br>
				<div class="well">
					<div class="event_data font-center"></div>
				</div>
				<table class="table table-striped">
					<tbody>
						<tr>
							<td><div class="font-bold">Status:</div></td>
							<td>
								<span class="event_status font-bold"></span>
								<a href="javascript:void(0);" class="popoverelement editar_status" data-trigger="focus" data-title="Editar Status" data-element=".popover_status"><i class="fa fa-pencil"></i></a>
								<!-- <button type="button" class="btn btn-xs btn-default popoverelement" data-trigger="focus" data-title="Editar Status" data-element=".popover_status"><i class="fa fa-edit"></i></button> -->
								<div class="popover_status hide">
									<button type="button" class="btn btn-sm status_event_option status_event_agendado btn-block btn-default"><i class="fa fa-calendar"></i> Agendado</button>
									<button type="button" class="btn btn-sm status_event_option status_event_confirmado btn-block btn-success"><i class="fa fa-check-circle"></i> Confirmado</button>
									<button type="button" class="btn btn-sm status_event_option status_event_aguardando_atendimento btn-block btn-warning"><i class="fa fa-clock-o"></i> Aguardando atendimento</button>
									<button type="button" class="btn btn-sm status_event_option status_event_nao_compareceu btn-block btn-danger"><i class="fa fa-ban"></i> Não compareceu</button>
									<!-- <button type="button" class="btn btn-sm status_event_option status_event_paciente_atendido btn-block btn-success"><i class="fa fa-check"></i> Paciente atendido</button> -->
								</div>
								<script type="text/javascript">
									$(function()
									{
										$('body').on('click', '.status_event_option', function(event)
										{
											event.preventDefault();
											var status = $.trim($(this).text());
											$.ajax(
											{
												url: base_url_controller+'changestatus',
												type: 'POST',
												data: 'id='+$('#event_id').val()+'&status='+status,
												dataType: 'json',
												success: function(data)
												{
													if(data.status==1)
													{
														$('#calendar').fullCalendar('destroy');
														$.ajax(
														{
															url: base_url_controller+'events',
															type: 'POST',
															dataType: 'json',
															success: function(data)
															{
																FullCalendarOptions['events'] = data;
																$('#calendar').fullCalendar(FullCalendarOptions);
															}
														});
														$('.event_status').html( '<span style="'+list_status_events[status].style+'"><i class="'+list_status_events[status].icon+'"></i> '+status+'</span>' );
													}
												}
											});
										});
									});
								</script>
								<!-- <span><i class="fa fa-edit" onclick="$('.event_status').hide();$('.select_event_status').show();"></i></span>
								<select class="form-control input-xs select_event_status" style="display:none;">
									<option value="Aguardando atendimento" data-css-status="aguardando_atendimento">Aguardando atendimento</option>
									<option value="Atendimento" data-css-status="atendimento">Atendimento</option>
									<option value="Faltou" data-css-status="faltou">Faltou</option>
									<option value="Cancelou" data-css-status="cancelou">Cancelou</option>
								</select>
								<style type="text/css">
									.aguardando_atendimento{color: #08721C;}
									.atendimento{color:#0B65AA;}
									.faltou{color: #EBBF0E;}
									.cancelou{color:#c00;}
								</style>
								<script type="text/javascript">
									$(function()
									{
										$('.select_event_status').change(function(event)
										{
											var status = $(this).val();
											var css_status = $('.select_event_status option:selected').data('css-status');
											console.log(css_status);

											$.ajax(
											{
												url: base_url_controller+'changestatus',
												type: 'POST',
												data: 'id='+$('#event_id').val()+'&status='+status,
												dataType: 'json',
												success: function(data)
												{
													if(data.status==1)
													{
														$('.event_status').html( '<span class="'+css_status+'">'+status+'</span>' );
														$('.event_status').show();
														$('.select_event_status').hide();
													}
												}
											});
										});
									});
								</script> -->
							</td>
						</tr>
						<tr>
							<td width="120"><strong>Procedimento:</strong></td>
							<td><div class="event_tipo"></div></td>
						</tr>
						<tr>
							<td><strong>Observação:</strong></td>
							<td><div class="event_obs nl2br"></div></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<div class="event_controls">
					<div class="pull-left">
						<button type="button" onclick="excluir()" class="btnExcluirAgendamento btn btn-default btn-sm"><i class="fa fa-trash"></i></button>
						<button type="button" onclick="edit_event()" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></button>
						<!--<span class="cursor-pointer" onclick="excluir()"><i class="fa fa-trash"></i> Excluir</span>
						&nbsp;&nbsp;&nbsp;
						<span class="cursor-pointer" onclick="edit_event()"><i class="fa fa-pencil"></i> Editar</span> -->
					</div>
					<button type="button" class="btn btn-success iniciar_atendimento"><i class="fa fa-play"></i> INICIAR ATENDIMENTO</button>
				</div>
				<script type="text/javascript">
					$(function()
					{
						$('.iniciar_atendimento').click(function(event)
						{
							//window.location.href=base_url+'prontuarios/atendimento/'+$('#atendimento_paciente_id').val()+'/cadastrar/'+$('#event_id').val();
							window.location.href=base_url+'prontuarios/atendimento/'+$('#event_id').val();
						});
					});
				</script>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="CadastraEvento">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="formCadastraEvento" action="<?=$this->base_url_controller?>salvar" method="POST" class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-calendar"></i> Agendamento</h4>
				</div>
				<div class="modal-body">
					<div class="modal-msg"></div>
					<!-- ########################################################################################## -->

					<input type="hidden" name="event_id" id="event_id">
					<input type="hidden" name="txtStart" id="txtStart">
					<input type="hidden" name="txtEnd" id="txtEnd">

					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
									<label for="paciente_id" class="control-label">Paciente</label>
									<select class="selectpicker form-control show-tick" id="paciente_id" name="paciente_id" data-field-db="<?=sha1('paciente_id')?>" data-live-search="true" data-style="btn-default btn-sm" data-size="5"></select>
									<input type="hidden" name="txtTitle" id="txtTitle">
									<script type="text/javascript">
										$(function()
										{
											var html = '<option value=""></option>';
											$.ajax(
											{
												url: base_url+'pacientes/pacientes',
												type: 'POST',
												dataType: 'json',
												success: function(data)
												{
													$.each(data.pacientes, function(index, paciente)
													{
														html += '<option value="'+paciente.id+'">'+paciente.nome+'</option>';
													});
													$("#paciente_id").html(html).selectpicker('refresh');
												}
											});
											$('#paciente_id').on('change', function()
											{
												$('#txtTitle').val( nome_abreviado($(this).find('option:selected').text()) );
											});
										});
										setTimeout(function()
										{
											$('.bs-searchbox').find('.form-control').addClass('input-sm');
										}, 500);
									</script>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5 pull-left">
								<div class="form-group form-group-sm">
									<label for="txtTipo" class="control-label">Tipo</label>
									<select class="selectpicker form-control" id="txtTipo" name="txtTipo" data-field-db="<?=sha1('tipo')?>" data-style="btn-default btn-sm">
										<option data-icon="glyphicon-ok" value="consulta">Consulta</option>
										<option data-icon="glyphicon-repeat" value="retorno">Retorno</option>
									</select>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-5 pull-right">
								<div class="form-group form-group-sm">
									<label for="txtConvenio" class="control-label">Convenio</label>
									<select class="selectpicker form-control" id="txtConvenio" name="txtConvenio" data-field-db="<?=sha1('convenio')?>" data-style="btn-default btn-sm">
										<option value="particular">Particular</option>
									</select>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
								    <label for="txtObs" class="control-label">Observação</label>
								    <textarea class="form-control" id="txtObs" rows="5" name="txtObs" data-field-db="<?=sha1('obs')?>" placeholder="Escreva aqui alguma observação..."><?=set_value('txtObs')?></textarea>
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
					<button type="submit" class="btn btn-primary btn-sm">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade modal-default" id="CalendarioAgenda">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Calendário</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div style="overflow:hidden;">
							<div class="form-group">
								<div class="row">
									<div class="col-md-8">
										<div id="datetimepickerCalendarioAgenda"></div>
									</div>
								</div>
							</div>
							<script type="text/javascript">
								$(function()
								{
									$('#datetimepickerCalendarioAgenda').datetimepicker(
									{
										inline: true,
										sideBySide: true,
										format: 'DD/MM/YYYY',
										locale: 'pt-br',
									}).on('dp.change', function(e)
									{
										var data_selecionada = e.date.format('YYYY-MM-DD');
										$('#calendar').fullCalendar('gotoDate', data_selecionada);

										var segunda = moment(data_selecionada).day(0);
										var sabado = moment(data_selecionada).day(6);

										//console.log(moment(segunda).format('DD'));
										//console.log(moment(sabado).format('DD'));

										var textobtnCalendario = moment(segunda).format('DD')+'/'+moment(segunda).format('MM')+' à '+moment(sabado).format('DD')+'/'+moment(sabado).format('MM');
										$('.fc-btnCalendario-button').html('<img src="'+base_url+'assets/img/calendar.png" class="imgCalendarioAgenda">'+textobtnCalendario );

										$('#CalendarioAgenda').modal('hide');
									});
								});
							</script>
							<style type="text/css">
							#datetimepickerCalendarioAgenda
							{
								padding-left: 10px;
							}
							</style>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ######################################################################################################### -->
<!-- ##########################################	  MODALS (Fim)	   ###################################### -->
<!-- ######################################################################################################### -->
<script type="text/javascript">
	$(function()
	{
		//$('.fc-slats table tr:odd td').css({'border-top':'transparent', 'border-top':'1px dashed #ccc'});
		//$(".fc-slats > table tbody tr:even").find("td:eq(1)").css({'border-top':'1px dashed #ccc'});
	});
	if( Cookies.get('prontuario') )
	{
		if(controller != 'prontuarios')
		{
			hide_controls_events = true;
			$('.editar_status').hide();
			$('.event_controls').find('button').prop('disabled', true);
		}
	}
</script>