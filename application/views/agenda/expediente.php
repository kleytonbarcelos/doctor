<style type="text/css">
	.event-expediente
	{
		color: #fff;
		vertical-align: middle !important;
		text-align: center;
		background-color: #3CB371;
		border-color: #ccc;
		color:#000;
	}
	#calendar
	{
		margin: 0 auto;
		background-color: #FFFFFF;
		border-radius: 6px;
	    box-shadow: 0 1px 2px #C3C3C3;
	}
	.fc th
	{
		padding: 10px;
	}
	.fc .fc-axis
	{
		padding: 2px 10px 2px 10px;
		font-family: arial;
		text-align: center;
		font-size: 12px;
		color: #000;
	}
	.fc-time-grid-event .fc-time
	{
		font-weight: bold;
		color: #000;
		font-size: 15px;
		text-align: center;
		font-family: arial;
	}
	.fc-time-grid-event .fc-title
	{
		padding-top: 15px;
		font-size: 9px;
		text-align: center;
		font-family: arial;
	}
	.fc
	{
		background-color: #c00;
	}
</style>
<script type="text/javascript">
	var duracaoconsulta = '<?=$Configuracoes->duracaoconsulta?>';
	var horarioexpedienteinicio = '<?=$Configuracoes->horarioexpedienteinicio?>:00';
	var horarioexpedientefim = '<?=$Configuracoes->horarioexpedientefim?>:00';

	var FullCalendarOptions =
	{
		eventColor: '#3CB371',
		eventBorderColor: '#A2B6BF',
		eventTextColor:'#000',

		header:false,

		height: 'auto',
		columnFormat: 'dddd',
		//dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
		defaultDate: moment().format('2016-01-01'),
		editable: true,
		selectable: true,
		selectHelper: true,
		defaultView: 'agendaWeek',
		slotLabelInterval: '00:'+duracaoconsulta+':00',
		slotLabelFormat: 'HH[:]mm',
		header: {
			left: '',
			center: '',
			right: '',
		},
		titleFormat: '',
		allDaySlot: false,
		minTime: horarioexpedienteinicio,
		maxTime: horarioexpedientefim,
		select: function(start, end) // Cadastra Evento
		{
			if( start.format('DD') != end.format('DD') )
			{
				alertify.alert('<strong><i class="fa fa-info-circle"></i>&nbsp;Alerta</strong>', '<strong>Selecione somente horários por dia da semana separadamente.</strong>');
			}
			else
			{
				var title = 'Horário de Expediente';
				$.ajax(
				{
					url: base_url_controller+'salvar',
					type: 'POST',
					data: 'txtTitle='+title+'&txtStart='+start.format('HH:mm')+'&txtEnd='+end.format('HH:mm')+'&txtDow='+start.day(),
					dataType: 'json',
					success: function(data)
					{
						DadosEvento =
						{
							id: data.id,
							title: 'Horário de Expediente',
							start: start.format('HH:mm'),
							end: end.format('HH:mm'),
							className: 'event-expediente',
							dow: [start.day()]
						};
						$('.fullCalendar').fullCalendar('renderEvent', DadosEvento, true);
					 	$('.fullCalendar').fullCalendar('unselect');
					}
				});
			}
		},
		eventClick: function(event, jsEvent, view) //Visualiza Evento
		{
			$('.btnExcluir').show();
			$('#CadastraEvento').modal('show');

			$('#id').val(event.id);
			$('.divNome').text(event.title);
			$('.divInicio').text(event.start.format('HH:mm'));
			$('.divFim').text(event.end.format('HH:mm'));
		},
		dragOpacity:
		{
			agenda: .2
		},
		eventDrop: function(event)
		{
			$.ajax(
			{
				url: base_url_controller+'salvar',
				type: 'POST',
				data: 'txtTitle='+event.title+'&txtStart='+event.start.format('HH:mm')+'&txtEnd='+event.end.format('HH:mm')+'&txtDow='+event.start.day()+'&id='+event.id,
				dataType: 'json',
				success: function(data){}
			});
		},
		eventResize: function(event, delta, revertFunc)
		{
			if( event.start.format('DD') != event.end.format('DD') )
			{
				alertify.alert('<strong><i class="fa fa-info-circle"></i>&nbsp;Alerta</strong>', '<strong>Selecione somente horários por dia da semana separadamente.</strong>');
			}
			else
			{
				$.ajax(
				{
					url: base_url_controller+'salvar',
					type: 'POST',
					data: 'txtTitle='+event.title+'&txtStart='+event.start.format('HH:mm')+'&txtEnd='+event.end.format('HH:mm')+'&txtDow='+event.start.day()+'&id='+event.id,
					dataType: 'json',
					success: function(data){}
				});
			}
		},
		events: base_url_controller+'events',
		// events:
		// [
		// 	<?php
		// 		foreach ($Dados as $key => $value)
		// 		{
		// 			echo "{\n";
		// 				echo "id: ".$value["id"].",\n";
		// 				echo "title: \"".$value["title"]."\",\n";
		// 				echo "start: \"".date_format(date_create($value["start"]), 'H:i')."\",\n";
		// 				echo "end: \"".date_format(date_create($value["end"]), 'H:i')."\",\n";
		// 				echo "className: 'event-expediente',\n";
		// 				echo "dow: [".$value["dow"]."],\n";
		// 			echo "},\n";
		// 		}
		// 	?>
		// ],
		eventAfterAllRender: function() // Executado após carregamento da Agenda
		{
			ajustes_agenda();
		},
	}
	function clear_form()
	{
		$('#formCadastraEvento input').val('');
		$('.msg-erro').html('');
		$('.has-error').removeClass('has-error');
	}
	$(function()
	{
		$('#CadastraEvento').on('hide.bs.modal', function(e)
		{
			clear_form();
		});
		$('.fullCalendar').fullCalendar(FullCalendarOptions);
	});
	function excluir()
	{
		id = $('#id').val();
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
						alertify.success('<i class="fa fa-check"></i> '+data.msg);

						$('#CadastraEvento').modal('hide');

						$('.fullCalendar').fullCalendar('removeEvents', id);
						$('.fullCalendar').fullCalendar('refresh');
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
	function ajustes_agenda()
	{
		$('.fc-toolbar').remove();

		// $('.fc-event').each(function(index, el)
		// {
		// 	margin = ( $(el).height()/2 )-20;
		// 	$(el).find('.fc-content').css({'margin-top':margin+'px'});
		// });
	}
</script>
<div class="row">
	<div class="col-md-8">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><span class="glyphicon glyphicon-time"></span> Horário de Expediente</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="conteudo_agenda">
					<div class="calendario">
						<div class="fullCalendar" id="calendar"></div>
					</div>
				</div>
				<div class="modal fade" id="CadastraEvento">
					<div class="modal-dialog">
						<div class="modal-content">
							<form id="formCadastraEvento" action="<?=base_url()?>agenda/salvar" method="POST" class="form-horizontal">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title"><div class="divNome"></div></h4>
									<input type="hidden" id="id">
								</div>
								<div class="modal-body">
									<div class="form-group">
										<label for="divInicio" class="col-sm-3 control-label">Inicío</label>
										<div class="col-sm-9">
											<div class="divInicio"></div>
										</div>
									</div>
									<div class="form-group">
										<label for="divFim" class="col-sm-3 control-label">Fim</label>
										<div class="col-sm-9">
											<div class="divFim"></div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<div class="pull-left">
										<button type="button" onclick="excluir()" class="btnExcluir btn btn-danger btn-sm"><i class="fa fa-trash"></i> Excluir</button>
									</div>
									<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Fechar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fa fa-gear"></i> Configurações</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="msg-form-configuracoes"></div>
				<form action="" class="form-horizontal" role="form">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<!-- <div class="form-group form-group-sm">
									<label for="txtDuracaoDaConsulta" class="control-label">Duração da Consulta</label>
									<div class="input-group date" id="datetimepickerIntervalo">
										<input type="text" class="form-control" name="txtDuracaoDaConsulta" id="txtDuracaoDaConsulta" value="<?=$Configuracoes->duracaoconsulta?>" readonly />
										<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
									</div>
									<br><br><br>
								</div> -->
								<div class="form-group form-group-sm">
									<label for="txtDuracaoDaConsulta" class="control-label">Duração da Consulta</label>
									<select class="selectpicker form-control" id="txtDuracaoDaConsulta" name="txtDuracaoDaConsulta" data-field-db="<?=sha1('duracaoconsulta')?>" data-style="btn-default btn-sm">
										<option value="10">10 minutos</option>
										<option value="20">20 minutos</option>
										<option value="30">30 minutos</option>
										<option value="40">40 minutos</option>
										<option value="50">50 minutos</option>
										<option value="60">60 minutos</option>
									</select>
								    <small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<div class="input-group date" id="datetimepickerInicio">
										<input type="text" class="form-control" name="txtExpedienteInicio" id="txtExpedienteInicio" value="<?=$Configuracoes->horarioexpedienteinicio?>" readonly />
										<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
									</div>
								</div>
							</div>
							<div class="col-md-2 text-center">
								<strong>até</strong>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<div class="input-group date" id="datetimepickerFim">
										<input type="text" class="form-control" name="txtExpedienteFim" id="txtExpedienteFim" value="<?=$Configuracoes->horarioexpedientefim?>" readonly />
										<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var intervalo = <?=$Configuracoes->duracaoconsulta?>;
	setTimeout(function()
	{
		$('#txtDuracaoDaConsulta').selectpicker('val', intervalo);
	}, 500);
	$(function()
	{
		$('#txtDuracaoDaConsulta').on('hidden.bs.select', function(e)
		{
			intervalo = $('#txtDuracaoDaConsulta').selectpicker('val');
			salva_dados_db();
			console.log( intervalo );

			FullCalendarOptions['slotDuration'] = '00:'+intervalo+':00';
			$('.fullCalendar').fullCalendar(FullCalendarOptions);
		});
		//#########################################################################################
		//#########################################################################################
		//#########################################################################################
		$('#datetimepickerInicio').datetimepicker(
		{
			format: 'HH:mm',
			locale: 'pt-br',
			stepping: intervalo,
			ignoreReadonly: true
		}).on('dp.show', function(e)
		{
			$(this).data('DateTimePicker').stepping(intervalo);
		}).on('dp.change', function(e)
		{
			salva_dados_db();
			console.log( intervalo );

			FullCalendarOptions['slotDuration'] = '00:'+intervalo+':00';
			$('.fullCalendar').fullCalendar(FullCalendarOptions);
		});
		//#########################################################################################
		$('#datetimepickerFim').datetimepicker(
		{
			format: 'HH:mm',
			locale: 'pt-br',
			stepping: intervalo,
			ignoreReadonly: true
		}).on('dp.show', function(e)
		{
			$(this).data('DateTimePicker').stepping(intervalo);
		}).on('dp.change', function(e)
		{
			salva_dados_db();
			console.log( intervalo );

			FullCalendarOptions['slotDuration'] = '00:'+intervalo+':00';
			$('.fullCalendar').fullCalendar(FullCalendarOptions);
		});
		//#########################################################################################
		//#########################################################################################
		//#########################################################################################
	});
	function salva_dados_db(data)
	{
		//console.log(data);
		$.ajax(
		{
			url: base_url_controller+'salvarexpediente',
			type: 'POST',
			data: 'txtExpedienteInicio='+$('[name="txtExpedienteInicio"]').val()+'&txtExpedienteFim='+$('[name="txtExpedienteFim"]').val()+'&txtDuracaoDaConsulta='+$('[name="txtDuracaoDaConsulta"]').selectpicker('val'),
			dataType: 'json',
			success: function(data)
			{
				if(data.status == 1)
				{
					var Eventos = $.parseJSON( data.events );

					$('.fullCalendar').fullCalendar('destroy');
					FullCalendarOptions['slotDuration'] = '00:'+$('[name="txtDuracaoDaConsulta"]').val()+':00';
					FullCalendarOptions['minTime'] = $('[name="txtExpedienteInicio"]').val()+':00';
					FullCalendarOptions['maxTime'] = $('[name="txtExpedienteFim"]').val()+':00';
					FullCalendarOptions['events'] = [];
					FullCalendarOptions['events'] = Eventos;
					
					$('.fullCalendar').fullCalendar(FullCalendarOptions);
					ajustes_agenda();

					//alert_success('.msg-form-configuracoes', data.msg);
					alertify.success('<i class="fa fa-check"></i> '+data.msg);
					$('.msg-erro').html('');
					$('.has-error').removeClass('has-error');
				}
				else
				{
					$.each(data.erros, function(campo, valor)
					{
						$('[name='+campo+']').nextAll('.msg-erro').eq(0).html(valor);
						$('[name='+campo+']').parents('.form-group').eq(0).addClass('has-error');
					});
				}
			}
		});
	}
</script>