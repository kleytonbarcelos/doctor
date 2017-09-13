<script type="text/javascript">
	$('.titulo').html('<i class="fa fa-files-o"></i> Prontuários');

	var url_redirect = '';
	var paciente_id = <?=$dados_paciente->id?>;

	var dados_paciente_id = '<?=$dados_paciente->id?>';
	var dados_paciente_nome = '<?=$dados_paciente->nome?>';
</script>
<script type="text/javascript">
	$(function()
	{
		$('#formOdontograma').bind('callback', function(event, data)
		{
			if(data.status == 1)
			{
				if(data.acao=='cadastrar')
				{
					window.location.href=base_url;
				}
			}
			else
			{
				//formajaxerros('#'+$(this).attr('id'), data.erros);
				alertify.error(data.erros);
			}
		});
	});
</script>
<?=form_open_multipart('prontuarios/salvar', array('id'=>'formProntuarios', 'class'=>'formajax', 'role'=>'form', 'data-callback'=>'true'))?>
<div class="msg"></div>
<div class="row">
	<div class="col-md-3">
		<div class="well font-center font-40 color-ccc">
			<i class="fa fa-clock-o"></i> <span class="cronometro">00:00:00</span>
		</div>
		<div class="margin-bottom-20">
			<a href="#" class="btn btn-block btn-success btn-cronometro font-bold"><i class="fa fa-play"></i> INICIAR ATENDIMENTO</a>
		</div>
	</div>
	<script type="text/javascript">
		var contador_salvamento_automatico = 0;
		var tempo_salvamento_automatico = 5; // em segundos
		var status_form_erros = 0;
		var auto_save = 0;

		function registra_cronometro()
		{
			setTimeout(function()
			{
				contador_salvamento_automatico = contador_salvamento_automatico + 1;
				if(contador_salvamento_automatico == tempo_salvamento_automatico)
				{
					if(auto_save)
					{
						auto_save = 0;
						salvaprontuario();
						console.log('AUTO SAVE');
					}
					contador_salvamento_automatico=0;
				}

				Cookies.remove('cronometro');
				Cookies.set('cronometro', $('.cronometro').data('seconds'));
				registra_cronometro();
			}, 1000);
		}
		function salvaprontuario(retornarerros=true)
		{
			return $.ajax(
			{
				url: base_url_controller+'salvar',
				type: 'POST',
				data: $('#formProntuarios').serialize(),
				dataType: 'json',
				success:function(data)
				{
					if(retornarerros)
					{
						if(data.status==1)
						{
							$('.msg').html('');
						}
						else
						{
							msg = '';
							$.each(data.erros, function(campo, valor)
							{
								msg += '<small>'+valor+'</small>';
							});
							$('.msg')
							.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>')
							.show();
						}
					}
				}
			});
		}
		$(function()
		{
			setTimeout(function()
			{
				$('#formProntuarios input, textarea, select').on('change', function(event)
				{
					//salvaprontuario();
					if(!auto_save)
					{
						auto_save = 1;
						console.log('DIGITOU ALGO, AUTO_SAVE> '+auto_save);
					}
				});
				$('.ckeditor-basic').each(function()
				{
					var textarea_id = $(this).attr('id');
					CKEDITOR.instances[textarea_id].on('change',function()
					{
						//salvaprontuario();
						//if(!auto_save){auto_save = 1;}
						if(!auto_save)
						{
							auto_save = 1;
							console.log('DIGITOU ALGO, AUTO_SAVE> '+auto_save);
						}
					});
				});
			}, 5000);
			$('.btn-cronometro').on('click', function(event)
			{
				event.preventDefault();
				if( $('#event_id').val() == 0 )
				{
					criaevento_info = $.ajax(
					{
						url: base_url_controller+'criaevento/info',
						type: 'POST',
						dataType: 'json',
					});
					$.when(criaevento_info).done(function(data)
					{
						var start = new Date();
						var end = new Date(start.getTime() + (data.duracaoconsulta * 60 * 1000));
						start = moment(start).format('YYYY-MM-DD[T]HH:mm:ss');
						end = moment(end).format('YYYY-MM-DD[T]HH:mm:ss');
						tipo = 'consulta';
						convenio = 'particular';
						obs = '';
						status = 'Agendado';

						$.ajax(
						{
							url: base_url_controller+'criaevento',
							type: 'POST',
							data: 'txtTitle='+nome_abreviado(dados_paciente_nome)+'&txtStart='+start+'&txtEnd='+end+'&txtTipo='+tipo+'&txtConvenio='+convenio+'&txtObs='+obs+'&paciente_id='+dados_paciente_id+'&txtStatus='+status,
							dataType: 'json',
							success: function(data)
							{
								url_redirect = 'atendimento';
								$('#event_id').val(data.id);
								console.log(data.id);
								setTimeout(function()
								{
									$('.btn-cronometro').trigger('click');
								}, 500);
							}
						});
					});
				}
				else
				{
					if( $(this).hasClass('btn-success') )
					{
						$('.cronometro').timer(
						{
							action: 'start',
							format: '%H:%M:%S'
						});
						registra_cronometro();
						//############################################################################ // Cria prontuario
						$.ajax(
						{
							url: base_url_controller+'criar_prontuario',
							type: 'POST',
							data: 'paciente_id='+$('#paciente_id').val()+'&event_id='+$('#event_id').val(),
							dataType: 'json',
							success: function(data)
							{
								//window.location.href=base_url+'prontuarios/cadastrar/'+data.dados_prontuario.id;
								$('#prontuario_id').val( data.dados_prontuario.id );
								Cookies.set('prontuario', data.dados_prontuario.id);
								Cookies.set('event_id', $('#event_id').val());
							}
						});
						//############################################################################
						$('.cronometro').css({'color':'#2980B9'});
						$(this).removeClass('btn-success').addClass('btn-danger').html('<i class="fa fa-stop"></i> FINALIZAR ATENDIMENTO');

						if( url_redirect == 'atendimento' )
						{
							setTimeout(function()
							{
								url = base_url_controller+'atendimento/'+$('#event_id').val();
								window.location.href = url;
							}, 500);
						}
					}
					else
					{
						$('#modal-finalizaratendimento').modal('show');
					}
				}
			});
			$('.btn-encerrar_atendimento').on('click', function(event)
			{
				event.preventDefault();

				$('#acao').val('encerrar');
				$('#tempoatendimento').val( Cookies.get('cronometro') );
				
				$.when(
					salvaprontuario()
				).done(function(data)
				{
					if(data.erros)
					{
						msg = '';
						$.each(data.erros, function(campo, valor)
						{
							msg += valor;
						});

						alertify.alert('<strong><i class="fa fa-info-circle"></i>&nbsp;Atenção</strong>', '<strong>Para finalizar, é necessário corrigir alguns erros.</strong>');
						$('#modal-finalizaratendimento').modal('hide');
					}
					else
					{
						Cookies.remove('cronometro');
						Cookies.remove('prontuario');

						$('#modal-finalizaratendimento').modal('hide');

						window.location.href=base_url;
					}
				});
			});
		});
	</script>
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-body">
				<input type="hidden" id="event_id" name="event_id" value="<?=$dados_event->id?>">
				<input type="hidden" id="paciente_id" name="paciente_id" value="<?=$dados_paciente->id?>">
				<input type="hidden" id="prontuario_id" name="prontuario_id">
				<input type="hidden" id="tempoatendimento" name="tempoatendimento">
				<input type="hidden" id="acao" name="acao">
				<input type="hidden" id="id" name="id">
				<table>
					<tbody>
						<tr>
							<td width="140" height="140">
								<div class="paciente_foto textavatar"></div>
								<script type="text/javascript">
									$('.paciente_foto').textAvatar(
									{
										width: 120,
										name: '<?=$dados_paciente->nome?>',
									});
								</script>
							</td>
							<td valign="top">
								<h3 class="font-blue-ciano2"><?=$dados_paciente->nome?></h3>
								<table width="400">
									<tbody>
										<tr>
											<td>Idade: <strong> 32 anos</strong></td>
											<td>Atendimentos: <strong></strong></td>
										</tr>
										<tr>
											<td>Primeira consulta em: <strong></strong></td>
											<td>Faltas: <strong></strong></td>
										</tr>
										<tr>
											<td>Convênio: <strong></strong></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-finalizaratendimento">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Encerrar atendimento</h4>
			</div>
			<div class="modal-body">
				Ao finalizar um atendimento, você não poderá alterá-lo novamente. Deseja prosseguir ?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
				<button type="button" class="btn btn-success btn-encerrar_atendimento">Sim</button>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div>
			<ul class="nav nav-tabs nav-justified" id="nav-tab-prontuario" role="tablist">
				<li role="presentation" class="active"><a href="#form-timeline" aria-controls="form-timeline"" role="tab" data-toggle="tab"><i class="fa fa-history fa-fw"></i> Resumo</a></li>
				<li role="presentation"><a href="#form-queixaprincipal" aria-controls="form-queixaprincipal" role="tab" data-toggle="tab"><i class="fa fa-server fa-fw"></i> Queixa Principal</a></li>
				<li role="presentation"><a href="#form-anamnese" aria-controls="form-anamnese"" role="tab" data-toggle="tab"><i class="fa fa-ambulance fa-fw"></i> Anamnese</a></li>
				<li role="presentation"><a href="#form-examefisico" aria-controls="form-examefisico" role="tab" data-toggle="tab"><i class="fa fa-child fa-fw"></i> Exame físico</a></li>
				<li role="presentation"><a href="#form-odontograma" aria-controls="form-odontograma" role="tab" data-toggle="tab"><i class="fa fa-address-book fa-fw"></i> Odontograma</a></li>
				<li role="presentation"><a href="#form-diagnostico" aria-controls="form-diagnostico" role="tab" data-toggle="tab"><i class="fa fa-quote-left fa-fw"></i> Hipótese Diagnóstica</a></li>
				<li role="presentation"><a href="#form-evolucao" aria-controls="form-evolucao"" role="tab" data-toggle="tab"><i class="fa fa-male fa-fw"></i> Evolução</a></li>
				<li role="presentation"><a href="#form-prescricao" aria-controls="form-prescricao" role="tab" data-toggle="tab"><i class="fa fa-file-text-o fa-fw"></i> Prescrição</a></li>
				<li role="presentation"><a href="#form-cartasatestados" aria-controls="form-cartasatestados" role="tab" data-toggle="tab"><i class="fa fa-clipboard fa-fw"></i> Cartas e Atestados</a></li>
				<li role="presentation"><a href="#form-examesanexos" aria-controls="form-examesanexos" role="tab" data-toggle="tab"><i class="fa fa-upload fa-fw"></i> Exames e Anexos</a></li>
			</ul>
			<div class="tab-content tab-content-default" id="tab-prontuario">
				<div role="tabpanel" class="tab-pane active" id="form-timeline">
					<div class="tab-prontuario-conteudo">
						<div class="timelinedotted-centered timelinedotted-body">
							<script type="text/javascript">
								function set_html_prescricoes(prontuario_id)
								{
									$.ajax(
									{
										url: base_url_controller+'prescricoes',
										type: 'POST',
										data: 'id='+prontuario_id,
										dataType: 'json',
										success: function(data)
										{
											if( sizeof(data.prescricoes) )
											{
												$('.html_prescricoes_'+prontuario_id).html('');

												var html = '';
												var contador_prescricoes = 1;
												$.each(data.prescricoes, function(index, val)
												{
													html = html+'<div class="row margin-top-10">';
														switch(val.quantidade)
														{
															case 'nenhum':
																html = html+'<div class="col-md-12 dotted-line">'+contador_prescricoes+'. '+val.medicamento+'</div>';
																//html = html+'<div class="col-md-2"></div>';
																break;
															case 'usocontinuo':
																html = html+'<div class="col-md-10 dotted-line">'+contador_prescricoes+'. '+val.medicamento+'</div>';
																html = html+'<div class="col-md-2">Uso contínuo</div>';
																break;
															default:
																html = html+'<div class="col-md-10 dotted-line">'+contador_prescricoes+'. '+val.medicamento+'</div>';
																html = html+'<div class="col-md-2">'+val.quantidade+' (un)</div>';
														}
													html = html+'</div>';
													html = html+'<div class="row"><div class="col-md-12 text-indent-20 font-bold">'+val.posologia+'</div></div>';
													contador_prescricoes++;
												});
												$('.html_prescricoes_'+prontuario_id).html(html);
											}
											else
											{
												$('.timeline-prescricoes_'+prontuario_id).hide();
											}
										}
									});
								}
								function set_html_cid10(prontuario_id)
								{
									$.ajax(
									{
										url: base_url_controller+'cid10',
										type: 'POST',
										data: 'id='+prontuario_id,
										dataType: 'json',
										success: function(data)
										{
											if( sizeof(data.cid10) )
											{
												$('.html_cid10_'+prontuario_id).html('');

												var html = '';
												$.each(data.cid10, function(index, dados)
												{
													html = html+'<div class="list-group-item active">'+dados.cid10+'</div>';
												});
												$('.html_cid10_'+prontuario_id).html('<div class="list-group list-group-cid10">'+html+'</div>');
											}
											else
											{
												$('.timeline-cid10_'+prontuario_id).hide();
											}
										}
									});
								}
								function set_html_cartasatestados(prontuario_id)
								{
									$.ajax(
									{
										url: base_url_controller+'cartasatestados',
										type: 'POST',
										data: 'id='+prontuario_id,
										dataType: 'json',
										success: function(data)
										{
											if( sizeof(data.cartasatestados) )
											{
												$('.html_cartasatestados_'+prontuario_id).html('');

												var html = '';
												$.each(data.cartasatestados, function(index, dados)
												{
													html = html+'<tr><td><div class="padding-10"><div><strong>Data: '+date_to_br(dados.data)+'</strong></div><div>'+dados.texto+'</div></div></td></tr>';
												});
												$('.html_cartasatestados_'+prontuario_id).html('<table class="table table-striped table-hover"><tbody>'+html+'</tbody></table>');
											}
											else
											{
												$('.timeline-cartasatestados_'+prontuario_id).hide();
												$('.html_cartasatestados_'+prontuario_id).html('');
											}
										}
									});
								}
								function set_html_examesanexos(prontuario_id)
								{
									$.ajax(
									{
										url: base_url_controller+'examesanexos',
										type: 'POST',
										data: 'id='+prontuario_id,
										dataType: 'json',
										success: function(data)
										{
											if( sizeof(data.examesanexos) )
											{
												$('.html_examesanexos_'+prontuario_id).html('');

												var html = '';
												$.each(data.examesanexos, function(index, val)
												{
													var imagens = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
													if ( $.inArray(val.arquivo.split('.').pop().toLowerCase(), imagens) > -1 )
													{
														html = html+'<div class="pull-left anexos_dropzone" style="margin: 20px;" data-toggle="tooltip" data-placement="bottom" title="'+val.descricao+'"><a data-fancybox="group'+prontuario_id+'" data-fancybox title="'+val.descricao+'" href="'+base_url+'uploads/'+val.arquivo+'"><img data-id="'+val.id+'" width="120" class="img-thumbnail" src="'+base_url+'uploads/'+val.arquivo+'"></a></div>';
													}
													else
													{
														html = html+'<div class="pull-left anexos_dropzone" style="margin: 20px;" data-toggle="tooltip" data-placement="bottom" title="'+val.descricao+'"><a data-fancybox="group'+prontuario_id+'" data-fancybox title="'+val.descricao+'" data-src="'+base_url+'uploads/'+val.arquivo+'" href="javascript:;"><img data-id="'+val.id+'" width="120" class="img-thumbnail" src="'+base_url+'assets/img/iconepdfmaior.png"></a></div>';
													}
												});
												$('.html_examesanexos_'+prontuario_id).html('<table class="table table-striped table-hover"><tbody>'+html+'</tbody></table>');
											}
											else
											{
												$('.timeline-examesanexos_'+prontuario_id).hide();
												$('.html_examesanexos_'+prontuario_id).html('');
											}
										}
									});
								}
								$.ajax(
								{
									url: base_url_controller+'prontuarios',
									type: 'POST',
									data: 'paciente_id='+paciente_id,
									dataType: 'json',
									success: function(data)
									{
										if( sizeof(data.prontuarios) <= 0 )
										{
											$('#form-timeline .tab-prontuario-conteudo').prepend(''+
											'<div class="well margin-top-20">'+
												'<div class="font-bold margin-bottom-10"><i class="fa fa-exclamation-triangle"></i> Atenção</div>'+
												'<div>Este paciente não possui nenhum registro anterior.</div>'+
												'<div>Para iniciar um atendimento, clique no botão <strong>Iniciar Atendimento</strong> no menu esquerdo.</div>'+
											'</div>');
										}

										$.each(data.prontuarios, function(index, val)
										{
											set_html_cid10(val.id);
											set_html_prescricoes(val.id);
											set_html_cartasatestados(val.id);
											set_html_examesanexos(val.id);

											html_timeline = [
													'<article class="timelinedotted-entry">',
														'<div class="timelinedotted-entry-inner">',
															'<div class="timelinedotted-icon bg-info">',
																'<i class="entypo-feather">',
																	'<div style="font-size: 34px;margin-top:2px;">'+moment(val.data).format('DD')+'</div>',
																	'<div style="font-size: 20px;margin-top:-12px;">'+moment(val.data).format('MMM').toUpperCase()+'</div>',
																	'<hr style="line-height: 5px;margin:-5px 12px 0 12px;">',
																	'<div style="font-size: 14px;margin-top:-8px;font-weight: bold;">'+moment(val.data).format('YYYY')+'</div>',
																'</i>',
															'</div>',
															'<div class="timelinedotted-label">',
																'<h2><span class="font-12">ATENDIDO POR: <a href="#"><?=$this->session->dados_usuario->nome?></a></span> <span class="font-12 pull-right"><i class="fa fa-clock-o"></i> '+moment(val.data).format('HH:mm')+' (Duração: '+moment.utc( val.tempoatendimento * 1000 ).format('HH:mm:ss')+')</span></h2>',
																'<p>',
																	'<div>',
																		'<div class="titulo-item-timeline"><i class="fa fa-server"></i> Queixa Principal</div>',
																		'<div class="conteudo-item-timeline">',
																			].join('');


																			html_timeline += [
																				'<table class="table table-striped"><tbody>',
																				'<tr><td><strong>Queixa:</strong></td><td>'+val.queixaprincipal+'</td></tr>',
																				].join('');
																			if(val.historia)
																			{
																				html_timeline += [
																					'<tr><td><strong>História:</strong></td><td>'+$(val.historia).html()+'</td></tr>',
																				].join('');
																			}
																			html_timeline += [
																				'</tbody></table>',
																			].join('');

														html_timeline += [
																		'</div>',
																	'</div>',
														].join('');
														if(val.anamnese)
														{
															html_timeline += [
																	'<div>',
																		'<div class="titulo-item-timeline"><i class="fa fa-ambulance"></i> Anamnese</div>',
																		'<div class="conteudo-item-timeline">',
																			''+$(val.anamnese).html()+'',
																		'</div>',
																	'</div>',
																	].join('');
														}
														if( val.altura || val.peso || val.frequenciacardiaca || val.pressaoarterialsistolica || val.pressaoarterialdiastolica || val.examefisico )
														{
															html_timeline += [
																		'<div>',

																			'<div class="titulo-item-timeline"><i class="fa fa-child"></i> Exame físico</div>',
																			'<div class="conteudo-item-timeline">',
															].join('');

																			html_timeline += [
																				'<table class="table table-striped"><tbody>',
																			].join('');
																			if( val.altura || val.peso || val.temperatura || val.frequenciacardiaca || val.pressaoarterialsistolica || val.pressaoarterialdiastolica )
																			{
																				html_timeline += [
																									'<tr><td><strong>Temperatura:</strong></td><td>'+val.temperatura+'</td></tr>',
																									'<tr><td><strong>Altura:</strong></td><td>'+val.altura+'</td></tr>',
																									'<tr><td><strong>Peso:</strong></td><td>'+val.peso+'</td></tr>',
																									'<tr><td><strong>Frequencia cadiáca:</strong></td><td>'+val.frequenciacardiaca+'</td></tr>',
																									'<tr><td><strong>Pressão Arterial Sistólica:</strong></td><td>'+val.pressaoarterialsistolica+'</td></tr>',
																									'<tr><td><strong>Pressão Arterial Diastólica:</strong></td><td>'+val.pressaoarterialdiastolica+'</td></tr>',
																								].join('');
																			}
																			if(val.examefisico)
																			{
																				html_timeline += [
																					'<tr><td><strong>Observações gerais:</strong></td><td>'+$(val.examefisico).html()+'</td></tr>',
																				].join('');
																			}
																			html_timeline += [
																				'</tbody></table>',
																			].join('');

															html_timeline += [
																			'</div>',
																		'</div>',
															].join('');
														}
															html_timeline += [
																	'<div class="timeline-cid10_'+val.id+'">',
																		'<div class="titulo-item-timeline"><i class="fa fa-quote-left"></i> Hipótese Diagnóstica</div>',
																		'<div class="conteudo-item-timeline">',
																			].join('');

																			html_timeline += [
																				'<table class="table table-striped"><tbody>',
																				'<tr><td colspan="2"><strong>CID10 - Código Internacional de Doenças::</strong></td></tr>',
																				'<tr><td colspan="2"><div class="html_cid10_'+val.id+'"><i class="fa fa-refresh fa-spin"></i> Carregando...</div></td></tr>',
																			].join('');
																			if(val.diagnostico)
																			{
																				html_timeline += [
																					'<tr><td><strong>Diagnóstico:</strong></td><td>'+$(val.diagnostico).html()+'</td></tr>',
																				].join('');
																			}
																			html_timeline += [
																				'</tbody></table>',
																			].join('');

														html_timeline += [
																		'</div>',
																	'</div>',
																	].join('');
														if(val.evolucao)
														{
															html_timeline += [
																	'<div>',
																		'<div class="titulo-item-timeline"><i class="fa fa-male"></i> Evolução</div>',
																		'<div class="conteudo-item-timeline">',
																			''+$(val.evolucao).html()+'',
																		'</div>',
																	'</div>',
																	].join('');
														}
														// if(val.prescricao)
														// {
														// 	html_timeline += [
														// 			'<div>',
														// 				'<div class="titulo-item-timeline"><i class="fa fa-file-text-o"></i> Prescrição</div>',
														// 				'<div class="conteudo-item-timeline">',
														// 					''+val.prescricao+'',
														// 				'</div>',
														// 			'</div>',
														// 			].join('');
														// }
															html_timeline += [
																	'<div class="timeline-prescricoes_'+val.id+'">',
																		'<div class="titulo-item-timeline"><i class="fa fa-file-text-o"></i> Prescrição</div>',
																		'<div class="conteudo-item-timeline">',
																			'<div class="html_prescricoes_'+val.id+'"><i class="fa fa-refresh fa-spin"></i> Carregando...</div>',
																		'</div>',
																	'</div>',
																	'<div class="timeline-cartasatestados_'+val.id+'">',
																		'<div class="titulo-item-timeline"><i class="fa fa-clipboard"></i> Cartas e Atestados</div>',
																		'<div class="conteudo-item-timeline">',
																			'<div class="html_cartasatestados_'+val.id+'"><i class="fa fa-refresh fa-spin"></i> Carregando...</div>',
																		'</div>',
																	'</div>',
																	'<div class="timeline-examesanexos_'+val.id+'">',
																		'<div class="titulo-item-timeline"><i class="fa fa-upload"></i> Exames e Anexos</div>',
																		'<div class="conteudo-item-timeline">',
																			'<div class="html_examesanexos_'+val.id+'"><i class="fa fa-refresh fa-spin"></i> Carregando...</div>',
																		'</div>',
																	'</div>',
																'</p>',
															'</div>',
														'</div>',
													'</article>',
											].join('');
											$('.timelinedotted-body').prepend(html_timeline);
											html_timeline = '';
										});
									}
								});
							</script>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="form-queixaprincipal">
					<div class="tab-prontuario-conteudo">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
									<label for="txtQueixaPrincipal" class="control-label">Queixa Principal</label>
									<input type="text" class="form-control" id="txtQueixaPrincipal" name="txtQueixaPrincipal" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.queixaprincipal')?>" placeholder="Queixa Principal">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
									<label for="txtHistoria" class="control-label">História</label>
									<textarea class="ckeditor-basic form-control" id="txtHistoria" name="txtHistoria" data-field-db="<?=sha1('prontuarios.historia')?>" placeholder="História"></textarea>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="form-anamnese">
					<div class="tab-prontuario-conteudo">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtModeloAnamnese" class="control-label">Modelo Anamnese</label>
									<select class="select2" id="txtModeloAnamnese" name="txtModeloAnamnese">
										<option>&nbsp;</option>
									</select>
									<script type="text/javascript">
										$(function()
										{
											$.ajax(
											{
												url: base_url+'anamneses/anamneses',
												type: 'POST',
												dataType: 'json',
												success: function(data)
												{
													$.each(data.anamneses, function(index, val)
													{
														$('#txtModeloAnamnese').append('<option value="'+val.id+'">'+val.nome+'</option>').selectpicker('refresh');
													});
												}
											});
											$('#txtModeloAnamnese').on('change', function(event)
											{
												event.preventDefault();
												var id = $(this).val();
												if(id)
												{
													$.ajax(
													{
														url: base_url+'anamneses/get',
														type: 'POST',
														data: 'id='+id,
														dataType: 'json',
														success: function(data)
														{
															$('#txtAnamnese').val( data.anamnese.texto );
														}
													});
												}
											});
										});
									</script>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
									<label for="txtAnamnese" class="control-label">Anamnese</label>
									<textarea class="ckeditor-basic" data-field-db="<?=sha1('prontuarios.anamnese')?>" id="txtAnamnese" name="txtAnamnese"></textarea>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="form-examefisico">
					<div class="tab-prontuario-conteudo">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtPeso" class="control-label"><i class="fa fa-thermometer-2"></i> Temperatura</label>
									<input type="text" class="form-control" id="txtTemperatura" name="txtTemperatura" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.temperatura')?>" placeholder="Temperatura">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtAltura" class="control-label"><i class="fa fa-long-arrow-up"></i> Altura</label>
									<input type="text" class="form-control" id="txtAltura" name="txtAltura" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.altura')?>" placeholder="Altura">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtPeso" class="control-label"><i class="fa fa-balance-scale"></i> Peso</label>
									<input type="text" class="form-control" id="txtPeso" name="txtPeso" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.peso')?>" placeholder="Peso">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtFrequenciaCardiaca" class="control-label"><i class="fa fa-heartbeat"></i> Frequencia cadiáca</label>
									<input type="text" class="form-control" id="txtFrequenciaCardiaca" name="txtFrequenciaCardiaca" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.frequenciacardiaca')?>" placeholder="Frequencia cadiáca">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtPressaoArterialSistolica" class="control-label"><i class="fa fa-stethoscope"></i> Pressão Arterial Sistólica</label>
									<input type="text" class="form-control" id="txtPressaoArterialSistolica" name="txtPressaoArterialSistolica" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.pressaoarterialsistolica')?>" placeholder="Pressão Arterial">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtPressaoArterialDiastolica" class="control-label"><i class="fa fa-stethoscope"></i> Pressão Arterial Diastólica</label>
									<input type="text" class="form-control" id="txtPressaoArterialDiastolica" name="txtPressaoArterialDiastolica" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.pressaoarterialdiastolica')?>" placeholder="Pressão Arterial Diastólica">
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
									<label for="txtExameFisico" class="control-label">Observações Gerais</label>
									<textarea class="ckeditor-basic form-control" id="txtExameFisico" rows="5" name="txtExameFisico" data-field-db="<?=sha1('prontuarios.examefisico')?>" placeholder="Exame físico"></textarea>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="form-odontograma">
					<div class="tab-prontuario-conteudo">
						<div class="row">
							<div class="col-md-6">
								<img src="<?=base_url()?>assets/img/odontograma.jpg" usemap="#odontograma">
								<map name="odontograma">
    								<area state="Outro procedimento" full="Outro procedimento" href="javascript:odontograma('Outro procedimento');" coords="317,16,428,37" shape="rect">
									<area state="11" full="11" href="javascript:odontograma('11');" coords="179,70,218,103" shape="rect">
									<area state="21" full="21" href="javascript:odontograma('21');" coords="258,103,221,68" shape="rect">
									<area state="12" full="12" href="javascript:odontograma('12');" coords="175,108,148,74" shape="rect">
									<area state="22" full="22" href="javascript:odontograma('22');" coords="261,76,291,110" shape="rect">
									<area state="13" full="13" href="javascript:odontograma('13');" coords="117,89,146,121" shape="rect">
									<area state="23" full="23" href="javascript:odontograma('23');" coords="293,91,324,121" shape="rect">
									<area state="14" full="14" href="javascript:odontograma('14');" coords="100,123,136,152" shape="rect">
									<area state="24" full="24" href="javascript:odontograma('24');" coords="306,122,338,149" shape="rect">
									<area state="15" full="15" href="javascript:odontograma('15');" coords="90,155,128,185" shape="rect">
									<area state="25" full="25" href="javascript:odontograma('25');" coords="312,154,351,183" shape="rect">
									<area state="16" full="16" href="javascript:odontograma('16');" coords="125,234,84,190" shape="rect">
									<area state="26" full="26" href="javascript:odontograma('26');" coords="317,190,363,230" shape="rect">
									<area state="17" full="17" href="javascript:odontograma('17');" coords="74,238,119,278" shape="rect">
									<area state="27" full="27" href="javascript:odontograma('27');" coords="329,236,373,278" shape="rect">
									<area state="18" full="18" href="javascript:odontograma('18');" coords="67,285,108,327" shape="rect">
									<area state="28" full="28" href="javascript:odontograma('28');" coords="336,284,382,323" shape="rect">
									<area state="48" full="48" href="javascript:odontograma('48');" coords="58,390,101,430" shape="rect">
									<area state="38" full="38" href="javascript:odontograma('38');" coords="329,385,367,426" shape="rect">
									<area state="47" full="47" href="javascript:odontograma('47');" coords="67,436,112,473" shape="rect">
									<area state="37" full="37" href="javascript:odontograma('37');" coords="320,430,362,472" shape="rect">
									<area state="46" full="46" href="javascript:odontograma('46');" coords="78,479,121,517" shape="rect">
									<area state="36" full="36" href="javascript:odontograma('36');" coords="314,477,350,516" shape="rect">
									<area state="45" full="45" href="javascript:odontograma('45');" coords="94,525,127,555" shape="rect">
									<area state="35" full="35" href="javascript:odontograma('35');" coords="304,522,337,553" shape="rect">
									<area state="44" full="44" href="javascript:odontograma('44');" coords="111,561,141,590" shape="rect">
									<area state="34" full="34" href="javascript:odontograma('34');" coords="294,555,327,587" shape="rect">
									<area state="43" full="43" href="javascript:odontograma('43');" coords="159,625,129,592" shape="rect">
									<area state="33" full="33" href="javascript:odontograma('33');" coords="273,590,306,623" shape="rect">
									<area state="42" full="42" href="javascript:odontograma('42');" coords="166,601,186,630" shape="rect">
									<area state="32" full="32" href="javascript:odontograma('32');" coords="248,599,271,629" shape="rect">
									<area state="41" full="41" href="javascript:odontograma('41');" coords="192,600,217,634" shape="rect">
									<area state="31" full="31" href="javascript:odontograma('31');" coords="222,602,244,635" shape="rect">
								</map>
								<script type="text/javascript">
									function odontograma(local)
									{
										$('#modalOdontograma').modal('show');
										$('#formOdontograma').find('[name="txtLocal"]').val(local);
										$('#formOdontograma').find('[name="prontuario_id"]').val( Cookies.get('prontuario') );
									}
								</script>
							</div>
							<div class="col-md-6 row-odontograma">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">Procedimentos</h3>
									</div>
									<div class="panel-body">
										<div class="registros-odontograma"></div>
									</div>
								</div>
								<script type="text/javascript">
									$(function()
									{
										$('body').on('click', '.btn_remove_odontograma', function(event)
										{
											event.preventDefault();

											var $odontograma = $(this);
											id = $odontograma.data('id');
											$.ajax(
											{
												url: base_url_controller+'excluir_odontograma',
												type: 'POST',
												data: 'id='+id,
												dataType: 'json',
												success: function(data)
												{
													if( data.status == 1 )
													{
														alertify.success('<i class="fa fa-check-square-o"></i> Procedimento excluído com sucesso!');
														get_odontograma();
													}
												}
											});
										});
									});
									function get_odontograma()
									{
										$('.row-odontograma').show();
										$('.registros-odontograma').html('<i class="fa fa-refresh fa-spin"></i> Verificando registros...');

										$.ajax(
										{
											url: base_url_controller+'odontograma',
											type: 'POST',
											data: 'id='+$('#prontuario_id').val(),
											dataType: 'json',
											success: function(data)
											{
												if( sizeof(data.odontograma) )
												{
													$('.row-odontograma').show();

													html = '';
													$.each(data.odontograma, function(index, val)
													{
														html = html+'<tr><td class="padding-10">Dente: '+val.local+' - '+val.procedimento+'</td><td><a href="javascript:void(0)" class="btn btn-danger btn-xs btn_remove_odontograma" data-id="'+val.id+'">Remover</a></td></tr>';
													});
													$('.registros-odontograma').html('<table class="table table-striped table-hover"><tbody>'+html+'</tbody></table>');
												}
												else
												{										
													$('.row-odontograma').hide();
												}
											}
										});
									}
									setTimeout(function()
									{
										if( $('#prontuario_id').val() )
										{
											get_odontograma();
										}
									}, 500);
								</script>
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="form-diagnostico">
					<div class="tab-prontuario-conteudo">
						<h4><i class="fa fa-quote-left"></i> Hipótese Diagnóstica</h4>
						<div class="row row-cid10 display-none margin-top-20">
							<div class="col-md-12 margin-bottom-10">
								<div class="registros-cid10"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<form action="<?=base_url()?>cid10/pesquisar" id="formPesquisar" role="form" method="post" accept-charset="utf-8">
									<div class="input-group stylish-input-group">
										<input type="text" class="form-control input-lg" name="search" id="search" data-timer="" placeholder="Pesquisar...">
										<span class="input-group-addon">
											<button type="button">
												<span class="glyphicon glyphicon-search"></span>
											</button>  
										</span>
									</div>
								</form>
								<br>
								<div class="list-group resultado_pesquisa"></div>
								<script type="text/javascript">
									var tempo = null;
									$(function()
									{
										function clear()
										{
											$('.resultado_pesquisa').html('');
										}
										$('#search').keyup(function()
										{
											clearTimeout(tempo);
											var search = $(this).val();

											if ( search.length == 0 )
											{
												clear();
												return false;
											}
											if (search.length >= 3)
											{
												clear();
												tempo = setTimeout(function()
												{
													$.ajax(
													{
														url: base_url+'cid10/pesquisar',
														type: 'POST',
														dataType: 'json',
														data: 'search='+search,
													})
													.done(function(data)
													{
														$('.resultado_pesquisa').html(data.html);
													})
													.fail(function()
													{

													});
												}, 500);
											}
										});
										$('body').on('click', '.resultado_pesquisa .list-group-item', function(event)
										{
											event.preventDefault();
											if( $('#prontuario_id').val() )
											{
												var $element = $(this);
												html = $element.find('.label').html()+' - '+$element.find('.descricao_cid10').html();

												$element.addClass('active');
											
												$.ajax(
												{
													url: base_url_controller+'salvarcid10',
													type: 'POST',
													data: 'cid10='+html+'&prontuario_id='+$('#prontuario_id').val(),
													dataType: 'json',
													success: function(data)
													{
														if( data.status == 1 )
														{
															get_cid10();
														}
													}
												});
											}
											else
											{
												alertify.warning('<i class="fa fa-ban"></i> Seu atendimento ainda não foi iniciado');
											}
										});
										$('body').on('click', '.btn-remove-cid10', function(event)
										{
											event.preventDefault();

											var $cid10 = $(this);
											id = $cid10.data('id');
											$.ajax(
											{
												url: base_url_controller+'excluir_cid10',
												type: 'POST',
												data: 'id='+id,
												dataType: 'json',
												success: function(data)
												{
													if( data.status == 1 )
													{
														get_cid10();
													}
												}
											});
										});
									});
									function get_cid10()
									{
										if( $('#prontuario_id').val() )
										{
											$('.row-cid10').show();
											$('.registros-cid10').html('<i class="fa fa-refresh fa-spin"></i> Verificando registros...');

											$.ajax(
											{
												url: base_url_controller+'cid10',
												type: 'POST',
												data: 'id='+$('#prontuario_id').val(),
												dataType: 'json',
												success: function(data)
												{
													if( sizeof(data.cid10) )
													{
														$('.row-cid10').show();

														html = '';
														$.each(data.cid10, function(index, val)
														{
															html = html+'<div class="list-group-item active">'+val.cid10+'<a href="javascript:void(0)" class="font-black btn-remove-cid10 pull-right" data-id="'+val.id+'"><i class="fa fa-trash"></i></a></div>';
														});
														$('.registros-cid10').html('<div class="list-group list-group-cid10">'+html+'</div>');
													}
													else
													{										
														$('.row-cid10').hide();
													}
												}
											});
										}
										else
										{
											$('.row-cid10').hide();
										}
									}
									setTimeout(function()
									{
										get_cid10();

									}, 500);
								</script>
							</div>
						</div>
						<div class="row margin-bottom-20">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
									<label for="txtDiagnostico" class="control-label">Diagnóstico</label>
									<textarea class="ckeditor-basic form-control" id="txtDiagnostico" rows="5" name="txtDiagnostico" data-field-db="<?=sha1('prontuarios.diagnostico')?>" placeholder="Hipótese Diagnóstica"></textarea>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="form-evolucao">
					<div class="tab-prontuario-conteudo">
						<h4><i class="fa fa-male"></i> Evolução</h4>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
									<textarea class="ckeditor-basic form-control" id="txtEvolucao" rows="5" name="txtEvolucao" data-field-db="<?=sha1('prontuarios.evolucao')?>" placeholder="Evolucao"></textarea>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="form-prescricao">
					<div class="tab-prontuario-conteudo">
						<div class="msg-prescricao"></div>
						<h4><i class="fa fa-file-text-o"></i> Prescrição</h4>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtDataPrescricao" class="control-label">Data</label>
									<div class="input-group date datetimepicker-data">
										<input type="text" class="form-control inputmask-data" id="txtDataPrescricao" name="txtDataPrescricao" data-field-db="<?=sha1('prontuarios.dataprescricao')?>" autocomplete="off" spellcheck="false" dir="auto" placeholder="Data">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtModelosPrescricoes" class="control-label">Modelos de Prescrições</label>
									<select class="select2" id="txtModelosPrescricoes" name="txtModelosPrescricoes">
									</select>
									<script type="text/javascript">
										function set_select_modelosprescricoes()
										{
											$.ajax(
											{
												url: base_url+'modelosprescricoes/modelosprescricoes',
												type: 'POST',
												dataType: 'json',
												success: function(data)
												{
													var html='';
													$.each(data.modelosprescricoes, function(index, val)
													{
														//$('#txtModelosPrescricoes').append('<option value="'+val.id+'">'+val.nome+'</option>').selectpicker('refresh');
														html += '<option value="'+val.id+'">'+val.nome+'</option>';
													});
													//$('#txtModelosPrescricoes').html('<option>&nbsp;</option>'+html).trigger('change');
													$('#txtModelosPrescricoes').html('<option>&nbsp;</option>'+html).trigger('change');
												}
											});
										}
										set_select_modelosprescricoes();
										$(function()
										{
											$('#txtModelosPrescricoes').on('change', function(event)
											{
												event.preventDefault();
												var id_prescricao = $(this).val();

												$('.msg-prescricoes').html('');
												$('.has-error').removeClass('has-error');

												if( !$('#prontuario_id').val() )
												{
													alertify.warning('<i class="fa fa-ban"></i> Seu atendimento ainda não foi iniciado');
													return false;
												}

												if(id_prescricao)
												{
													$.ajax(
													{
														url: base_url+'modelosprescricoes/modelosprescricoesregistros',
														type: 'POST',
														data: 'id='+id_prescricao,
														dataType: 'json',
														success: function(data)
														{
															$.each(data.modelosprescricoesregistros, function(index, val)
															{
																cont_send_ajax = 0;
																$.ajax(
																{
																	url: base_url_controller+'salvarprescricoes',
																	type: 'POST',
																	data: 'txtMedicamento='+val.medicamento+'&txtPosologia='+val.posologia+'&txtQuantidade='+val.quantidade+'&prontuario_id='+$('#prontuario_id').val(),
																	dataType: 'json',
																	beforeSend: function()
																	{
																		cont_send_ajax++;
																	},
																	success: function(data)
																	{
																		if (!--cont_send_ajax)
																		{
																			get_prescricoes();
																		}
																	}
																});
															});
														}
													});
												}
											});
										});
									</script>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="msg-prescricoes"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title">Medicamentos da prescrição</h3>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-md-5">
												<div class="form-group form-group-sm">
													<label for="txtMedicamento" class="control-label">Medicamento</label>
													<input type="text" class="form-control" id="txtMedicamento" name="txtMedicamento" placeholder="Medicamento">
													<small class="msg-erro text-danger"></small>
												</div>
											</div>
											<div class="col-md-3">
												<div class="form-group form-group-sm">
													<label for="txtPosologia" class="control-label">Posologia</label>
													<input type="text" class="form-control" id="txtPosologia" name="txtPosologia" placeholder="Posologia">
													<small class="msg-erro text-danger"></small>
												</div>
											</div>
											<div class="col-md-2">
												<div class="form-group form-group-sm">
												    <label for="txtQuantidade" class="control-label">Quantidade</label>
													<select class="form-control" id="txtQuantidade" name="txtQuantidade">
														<option value="nenhum">Nenhum</option>
														<option value="usocontinuo">Uso Contínuo</option>
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
														<option value="6">6</option>
														<option value="7">7</option>
														<option value="8">8</option>
														<option value="9">9</option>
														<option value="10">10</option>
													</select>
												    <small class="msg-erro text-danger"></small>
												</div>
											</div>
											<div class="col-md-2">
												<a class="btn btn-success btn-sm btn-salvarprescricao margin-top-25"><i class="fa fa-plus fa-fw"></i> ADICIONAR</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row row-prescricoes display-none">
							<div class="col-md-12 margin-top-20 margin-bottom-20">
								<div class="panel panel-primary well well-sm">
									<div class="panel-body">
										<div class="registros-prescricoes"></div>
									</div>
								</div>
							</div>
						</div>
						<br><br><br>
						<div class="pull-right">
							<a class="btn btn-default btn-sm btn-prescricao-imprimir"><i class="fa fa-print fa-fw"></i> IMPRIMIR</a>
							<a class="btn btn-default btn-sm btn-prescricao-enviar-por-email"><i class="fa fa-send-o fa-fw"></i> ENVIAR POR E-MAIL</a>
							<a class="btn btn-default btn-sm btn-prescricao-salvar-como-modelo"><i class="fa fa-save fa-fw"></i> SALVAR MODELO COMO</a>
						</div>
						<br><br>
						<div class="modal fade" id="modalCadastraModeloPrescricao">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title">Modelo de Prescrição</h4>
									</div>
									<div class="modal-body">
										<div class="msg-modalCadastraModeloPrescricao"></div>
										<div class="form-group form-group-sm">
											<label for="txtNomeModeloPrescricao" class="control-label">Nome</label>
											<input type="text" class="form-control" id="txtNomeModeloPrescricao" name="txtNomeModeloPrescricao" placeholder="Nome">
											<small class="msg-erro text-danger"></small>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
										<button type="button" class="btn btn-primary btn-salvar-modelo-prescricao">Salvar</button>
									</div>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$(function()
							{

								$('.btn-prescricao-salvar-como-modelo').on('click', function(event)
								{
									event.preventDefault();
									$('#modalCadastraModeloPrescricao').modal('show');
								});
								$('.btn-salvar-modelo-prescricao').on('click', function(event)
								{
									event.preventDefault();
									
									var medicamentos = '';
									var quantidades = '';
									var posologias = '';

									var prescricoes = $.ajax(
									{
										url: base_url_controller+'prescricoes',
										type: 'POST',
										data: 'id='+$('#prontuario_id').val(),
										dataType: 'json',
										success: function(data)
										{
											$.each(data.prescricoes, function(index, val)
											{
												medicamentos += '&txtMedicamento[]='+val.medicamento;
												posologias += '&txtPosologia[]='+val.posologia;
												quantidades += '&txtQuantidade[]='+val.quantidade;
											});
										}
									});
									$.when(prescricoes).done(function()
									{
										$.ajax(
										{
											url: base_url_controller+'salvarmodeloprescricao',
											type: 'POST',
											data: 'id='+$('#prontuario_id').val()+'&txtNomeModeloPrescricao='+$('#txtNomeModeloPrescricao').val()+medicamentos+posologias+quantidades,
											dataType: 'json',
											success: function(data)
											{
											if( data.status == 1 )
											{
												alertify.success('<i class="fa fa-check-square-o"></i> '+data.msg);
												$('#txtNomeModeloPrescricao').val('');
												$('#modalCadastraModeloPrescricao').modal('hide');

												set_select_modelosprescricoes();
											}
											else
											{
												var msg = '';
												$.each(data.erros, function(campo, valor)
												{
													var Input = $('[name='+campo+']');
													Input.parents('.form-group').eq(0).addClass('has-error');
													msg += '<div><small>'+valor+'</small></div>';
												});
												$('.msg-modalCadastraModeloPrescricao')
												.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>')
												.show();
											}
											}
										});
									});
								});
								$('.btn-salvarprescricao').on('click', function(event)
								{
									event.preventDefault();

									$('.msg-prescricoes').html('');
									$('.has-error').removeClass('has-error');

									if( !$('#prontuario_id').val() )
									{
										alertify.warning('<i class="fa fa-ban"></i> Seu atendimento ainda não foi iniciado');
										return false;
									}

									$.ajax(
									{
										url: base_url_controller+'salvarprescricoes',
										type: 'POST',
										data: $('#txtMedicamento, #txtQuantidade, #txtPosologia, #txtDataPrescricao, #prontuario_id').serialize(),
										dataType: 'json',
										success: function(data)
										{
											if( data.status == 1 )
											{
												alertify.success('<i class="fa fa-check-square-o"></i> '+data.msg);
												$('#txtMedicamento, #txtPosologia, #txtDataPrescricao').val('');
												$('#txtQuantidade').val('nenhum');
												get_prescricoes();
											}
											else
											{
												var msg = '';
												$.each(data.erros, function(campo, valor)
												{
													var Input = $('[name='+campo+']');
													Input.parents('.form-group').eq(0).addClass('has-error');
													msg += '<div><small>'+valor+'</small></div>';
												});
												$('.msg-prescricoes')
												.html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>')
												.show();
											}
										}
									});
								});
								$('body').on('click', '.btn-remove-prescricao', function(event)
								{
									event.preventDefault();

									var $prescricao = $(this);
									id = $prescricao.data('id');
									$.ajax(
									{
										url: base_url_controller+'excluir_prescricao',
										type: 'POST',
										data: 'id='+id,
										dataType: 'json',
										success: function(data)
										{
											if( data.status == 1 )
											{
												alertify.success('<i class="fa fa-check-square-o"></i> Prescrição excluída com sucesso!');
												get_prescricoes();
											}
										}
									});
								});
							});
							function get_prescricoes()
							{
								$('.row-prescricoes').show();
								$('.registros-prescricoes').html('<i class="fa fa-refresh fa-spin"></i> Verificando registros...');

								var contador_prescricoes = 1;
								$.ajax(
								{
									url: base_url_controller+'prescricoes',
									type: 'POST',
									data: 'id='+$('#prontuario_id').val(),
									dataType: 'json',
									success: function(data)
									{
										if( sizeof(data.prescricoes) )
										{
											$('.row-prescricoes').show();

											html = '';
											$.each(data.prescricoes, function(index, val)
											{
												html = html+'<div class="row margin-top-10">';
													html = html+'<div class="col-md-9 dotted-line">'+contador_prescricoes+'. '+val.medicamento+'</div>';
													switch(val.quantidade)
													{
														case 'nenhum':
															html = html+'<div class="col-md-2"></div>';
															break;
														case 'usocontinuo':
															html = html+'<div class="col-md-2">Uso contínuo</div>';
															break;
														default:
															html = html+'<div class="col-md-2">'+val.quantidade+' (un)</div>';
													}
													html = html+'<div class="col-md-1"><a href="javascript:void(0);" class="btn-remove-prescricao" data-id="'+val.id+'"><i class="fa fa-trash fa-fw font-red"></i></a></div>';
												html = html+'</div>';
												html = html+'<div class="row"><div class="col-md-12 text-indent-20 font-bold">'+val.posologia+'</div></div>';
												contador_prescricoes++;
											});
											$('.registros-prescricoes').html(html);
										}
										else
										{										
											$('.row-prescricoes').hide();
										}
									}
								});
							}
							setTimeout(function()
							{
								if( $('#prontuario_id').val() )
								{
									get_prescricoes();
								}
							}, 500);
						</script>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="form-cartasatestados">
					<div class="tab-prontuario-conteudo">
						<div class="msg-cartasatestados"></div>
						<h4><i class="fa fa-clipboard"></i> Cartas e Atestados</h4>
						<div class="row row-cartasatestados display-none">
							<div class="col-md-12 margin-bottom-20">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="registros-cartasatestados"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group form-group-sm">
									<label for="txtDataCartaAtestado" class="control-label">Data</label>
									<div class="input-group date datetimepicker-data">
										<input type="text" class="form-control inputmask-data" id="txtDataCartaAtestado" name="txtDataCartaAtestado" data-field-db="<?=sha1('prontuarios.datacartaatestado')?>" autocomplete="off" spellcheck="false" dir="auto" placeholder="Data">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group form-group-sm">
									<label for="txtModelosCartasAtestados" class="control-label">Modelos de Atestados</label>
									<select class="select2" id="txtModelosCartasAtestados" name="txtModelosCartasAtestados">
										<option>&nbsp;</option>
									</select>
									<script type="text/javascript">
										$(function()
										{
											$.ajax(
											{
												url: base_url+'cartasatestados/cartasatestados',
												type: 'POST',
												dataType: 'json',
												success: function(data)
												{
													$.each(data.cartasatestados, function(index, val)
													{
														$('#txtModelosCartasAtestados').append('<option value="'+val.id+'">'+val.nome+'</option>').selectpicker('refresh');
													});
												}
											});
											$('#txtModelosCartasAtestados').on('change', function(event)
											{
												event.preventDefault();
												var id = $(this).val();
												if(id)
												{
													$.ajax(
													{
														url: base_url+'cartasatestados/get',
														type: 'POST',
														data: 'id='+id,
														dataType: 'json',
														success: function(data)
														{
															$('#txtCartasAtestados').val( data.cartaatestado.texto );
														}
													});
												}
											});
										});
									</script>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-group-sm">
									<label for="txtCartasAtestados" class="control-label">Cartas e Atestados</label>
									<textarea class="ckeditor-basic form-control" id="txtCartasAtestados" name="txtCartasAtestados" data-field-db="<?=sha1('prontuarios.cartaatestado')?>" placeholder="Cartas e Atestados"></textarea>
									<small class="msg-erro text-danger"></small>
								</div>
							</div>
						</div>
						<a class="btn btn-primary btn-sm btn-salvarcartaatestado"><i class="fa fa-plus"></i> Salvar Carta/Atestado</a>
						<script type="text/javascript">
							$(function()
							{
								$('.btn-salvarcartaatestado').on('click', function(event)
								{
									event.preventDefault();

									$('.msg-cartasatestados').html('');
									$('.has-error').removeClass('has-error');

									$.ajax(
									{
										url: base_url_controller+'salvarcartasatestados',
										type: 'POST',
										data: $('#txtCartasAtestados, #txtDataCartaAtestado, #prontuario_id').serialize(),
										dataType: 'json',
										success: function(data)
										{
											if( data.status == 1 )
											{
												alertify.success('<i class="fa fa-check-square-o"></i> '+data.msg);
												get_cartasatestados();
											}
											else
											{
												var msg = '';
												$.each(data.erros, function(campo, valor)
												{
													var Input = $('[name='+campo+']');
													Input.parents('.form-group').eq(0).addClass('has-error');
													msg += '<div><small>'+valor+'</small></div>';
												});
												$('.msg-cartasatestados')
												.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>')
												.show();
											}
										}
									});
								});
								$('body').on('click', '.btn-remove-cartaatestado', function(event)
								{
									event.preventDefault();

									var $cartaatestado = $(this);
									id = $cartaatestado.data('id');
									$.ajax(
									{
										url: base_url_controller+'excluir_cartaatestado',
										type: 'POST',
										data: 'id='+id,
										dataType: 'json',
										success: function(data)
										{
											if( data.status == 1 )
											{
												alertify.success('<i class="fa fa-check-square-o"></i> Carta/Atestado excluído com sucesso!');
												get_cartasatestados();
											}
										}
									});
								});
							});
							function get_cartasatestados()
							{
								$('.row-cartasatestados').show();
								$('.registros-cartasatestados').html('<i class="fa fa-refresh fa-spin"></i> Verificando registros...');

								$.ajax(
								{
									url: base_url_controller+'cartasatestados',
									type: 'POST',
									data: 'id='+$('#prontuario_id').val(),
									dataType: 'json',
									success: function(data)
									{
										if( sizeof(data.cartasatestados) )
										{
											$('.row-cartasatestados').show();

											html = '';
											$.each(data.cartasatestados, function(index, val)
											{
												html = html+'<tr><td><div class="padding-10"><small><strong>Data: '+date_to_br(val.data)+'</strong></small><small>'+val.texto+'</small><a href="javascript:void(0)" class="btn btn-danger btn-xs btn-remove-cartaatestado" data-id="'+val.id+'">Remover</a></div></td></tr>';
											});
											$('.registros-cartasatestados').html('<table class="table table-striped table-hover"><tbody>'+html+'</tbody></table>');
										}
										else
										{										
											$('.row-cartasatestados').hide();
										}
									}
								});
							}
							setTimeout(function()
							{
								if( $('#prontuario_id').val() )
								{
									get_cartasatestados();
								}
							}, 500);
						</script>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="form-examesanexos">
					<div class="tab-prontuario-conteudo">
						<div class="row row-registros-examesanexos display-none">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="registros-examesanexos"></div>
									</div>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-dropzone col-md-12">
								<script type="text/javascript">
									$(function()
									{
										// ######################  Excluir Arquivos anexados  #############
										$('body').on('click', '.excluir-examesanexos', function(event)
										{
											event.preventDefault();

											var $anexos_dropzone = $(this).closest('.anexos_dropzone');
											id = $anexos_dropzone.find('img').data('id');
											$.ajax(
											{
												url: base_url_controller+'excluir_upload',
												type: 'POST',
												data: 'id='+id,
												dataType: 'json',
												success: function(data)
												{
													if( data.status == 1 )
													{
														get_examesanexos();
													}
												}
											});
										});
										// ##################################################################
										Dropzone.autoDiscover = false;
										$('#UploadExamosAnexos').dropzone(
										{
											addRemoveLinks: true,
											dictRemoveFile:"Remover",

											url: base_url_controller+'upload',
											paramName: 'file',
											autoProcessQueue: false,
											//parallelUploads: 1,
											//maxFiles: 1,
											//maxFilesize: 64, // Em MB
											acceptedFiles: 'image/*,application/pdf',
											//headers: {'teste':'aaaa'},
											init: function()
											{
												var dropzone = this;
												$('.btn-salvarexamesanexos').click(function(event)
												{
													event.preventDefault();
													if( $('#prontuario_id').val() )
													{
														dropzone.processQueue();
													}
													else
													{
														alertify.warning('<i class="fa fa-ban"></i> Seu atendimento ainda não foi iniciado');
													}
												});
												dropzone.on("addedfile", function(event)
												{
													$('.descricao_examesanexos').show().find('textarea').val('');
												});
												dropzone.on("sending", function(file, xhr, formData)
												{
													formData.append('prontuario_id', $('#prontuario_id').val());
													formData.append('txtDescricaoExamesAnexos', $('#txtDescricaoExamesAnexos').val());
												});
												dropzone.on("error", function(file, response)
												{
													//$('.dropzone-erros').html(response).addClass('alert alert-danger');
												});
											},
											success: function (file, data)
											{
												data = $.parseJSON(data);

												$('.descricao_examesanexos').find('textarea').text('');
												$('.descricao_examesanexos').hide();
												this.removeAllFiles();

												get_examesanexos();

												alertify.success('<i class="fa fa-check-square-o"></i> Arquivo adicionado com sucesso!');
											},
										});
									});
									function get_examesanexos()
									{
										$('.row-registros-examesanexos').show();
										$('.registros-examesanexos').html('<i class="fa fa-refresh fa-spin"></i> Verificando registros...');

										$.ajax(
										{
											url: base_url_controller+'examesanexos',
											type: 'POST',
											data: 'id='+$('#prontuario_id').val(),
											dataType: 'json',
											success: function(data)
											{
												if( sizeof(data.examesanexos) )
												{
													$('.row-registros-examesanexos').show();

													html = '';
													$.each(data.examesanexos, function(index, val)
													{
														var imagens = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
														if ( $.inArray(val.arquivo.split('.').pop().toLowerCase(), imagens) > -1 )
														{
															html = html+'<div class="pull-left anexos_dropzone" style="margin: 20px;" data-toggle="tooltip" data-placement="bottom" title="'+val.descricao+'"><a title="'+val.descricao+'" data-fancybox="group" data-fancybox href="'+base_url+'uploads/'+val.arquivo+'"><img data-id="'+val.id+'" width="120" class="img-thumbnail" src="'+base_url+'uploads/'+val.arquivo+'"></a><span class="close excluir-examesanexos">&times;</span></div>';
														}
														else
														{
															html = html+'<div class="pull-left anexos_dropzone" style="margin: 20px;" data-toggle="tooltip" data-placement="bottom" title="'+val.descricao+'"><a title="'+val.descricao+'" data-fancybox="group" data-fancybox data-src="'+base_url+'uploads/'+val.arquivo+'" href="javascript:;"><img data-id="'+val.id+'" width="120" class="img-thumbnail" src="'+base_url+'assets/img/iconepdfmaior.png"></a><span class="close excluir-examesanexos">&times;</span></div>';
														}
													});
													$('.registros-examesanexos').html(html);
												}
												else
												{
													$('.row-registros-examesanexos').hide();
												}
											}
										});
									}
									setTimeout(function()
									{
										if( $('#prontuario_id').val() )
										{
											get_examesanexos();
										}
									}, 500);
								</script>
								<div class="dropzone" id="UploadExamosAnexos">
									<div class="dz-message">
										<div class="padding-5 font-22">Arraste os arquivos para cá</div>
										<div class="padding-5">Ou, se preferir...</div>
										<div class="padding-5"><a href="javascript:void(0);" class="btn btn-primary btn-sm">Escolher arquivos para fazer upload</a></div>
										<div class="padding-5 font-10">O tamanho máximo do arquivo de upload: 64 MB.</div>
									</div>
								</div>
								<br>
								<div class="dropzone-erros"></div>
								<div class="form-group form-group-sm descricao_examesanexos display-none">
									<label for="txtDescricaoExamesAnexos" class="control-label">Descrição</label>
									<textarea class="form-control" id="txtDescricaoExamesAnexos" rows="5" name="txtDescricaoExamesAnexos" data-field-db="<?=sha1('prontuarios_examesanexos.descricao')?>" placeholder="Descrição"></textarea>
									<small class="msg-erro text-danger"></small>
									<br>
									<a href="javascript:void(0);" class="btn btn-primary btn-sm btn-salvarexamesanexos"><i class="fa fa-upload"></i> Enviar</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row row-btn-salvar display-none">
					<div class="col-md-12">
						<div class="pull-right">
							<a href="javascript:void(0);" class="btn btn-success" onclick="salvaprontuario()"><i class="fa fa-save"></i>&nbsp;Salvar</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script language="javascript">
	if( Cookies.get('tab-prontuario-active') )
	{
		tab = Cookies.get('tab-prontuario-active');
		$('#nav-tab-prontuario a[href="#'+tab+'"]').tab('show');
	}
	if( Cookies.get('prontuario') )
	{
		$('#prontuario_id').val( Cookies.get('prontuario') )
		//############################################################################
		$('.cronometro').css({'color':'#2980B9'});
		$('.btn-cronometro').removeClass('btn-success').addClass('btn-danger').html('<i class="fa fa-stop"></i> FINALIZAR ATENDIMENTO');

		$('.cronometro').timer(
		{
			action: 'start',
			format: '%H:%M:%S',
			seconds: Cookies.get('cronometro'),
		});
		registra_cronometro();
		getvaluesinputs('prontuarios', Cookies.get('prontuario'));
	}
	// ################################################## Ajusta altura NavTabs
	var highest = null;
	$(".nav-tabs a").each(function()
	{
		var h = $(this).height();
		if(h > highest)
		{
			highest = $(this).height();
		}
	});
	$(".nav-tabs a").height(highest);
	// ################################################### Grava a navtab ativa
	$('#nav-tab-prontuario a[data-toggle="tab"]').on('shown.bs.tab', function (e)
	{
		//e.target
		//e.relatedTarget
		tab = $(e.target).attr('aria-controls');
		Cookies.set('tab-prontuario-active', tab);
		// ################################################## Remove botão salvar de tabs desnecessárias
		array = ['form-timeline', 'form-examesanexos'];
		if ( $.inArray(tab, array) > -1 )
		{
			$('.row-btn-salvar').hide();
		}
		else
		{
			$('.row-btn-salvar').show();
		}
	});
	// ###################################################
	//window.onbeforeunload = function(){return 'Se você fechar o navegador, seus dados serão perdidos. Deseja realmente Sair?'};
</script>
<?=form_close()?>
<div class="modal fade" id="modalOdontograma">
	<div class="modal-dialog">
		<script type="text/javascript">
			$(function()
			{
				$('#formOdontograma').bind('callback', function(event, data)
				{
					if(data.status == 1)
					{
						$('#modalOdontograma').modal('hide');
						$('#formOdontograma').find('[name="txtProcedimento"]').val('');
						get_odontograma();
					}
					else
					{
						formajaxerros('#'+$(this).attr('id'), data.erros);
					}
				});
			});
		</script>
		<?=form_open_multipart('prontuarios/salvarodontograma', array('id'=>'formOdontograma', 'class'=>'formajax', 'role'=>'form', 'data-callback'=>'true'))?>
		<input type="hidden" name="prontuario_id">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Procedimento</h4>
			</div>
			<div class="modal-body">
				<div class="msg"></div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group form-group-sm">
							<label for="txtLocal" class="control-label">Local</label>
							<input type="text" class="form-control" id="txtLocal" name="txtLocal" placeholder="Dente" readonly>
							<small class="msg-erro text-danger"></small>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">				
						<div class="form-group form-group-sm">
							<label for="txtProcedimento">Procedimento*</label>
							<div class="input-group">
								<input type="hidden" id="codigoprocedimento_id" name="codigoprocedimento_id" data-callback="true" data-field-db="<?=sha1('tiss.codigoprocedimento_id')?>">
								<input type="text" id="txtProcedimento" name="txtProcedimento" class="search-query form-control" aria-describedby="basic-addon2" autocomplete="off" spellcheck="false" dir="auto">
								<span class="input-group-addon" id="basic-addon2">
									<i class="fa fa-search"></i>
								</span>
							</div>
							<script type="text/javascript">
								$(function()
								{
									var icone_carregando_typeahead = null;
									$('#txtProcedimento').on('keydown', function(event)
									{
										$element = $(this);
										if( $element.val().length <= 1 ){$('#codigoprocedimento_id').val('')}

										if(!icone_carregando_typeahead)
										{
											$element.parent('.input-group').find('.input-group-addon').html('<i class="fa fa-spinner fa-pulse"></i>');
											icone_carregando_typeahead = setTimeout(function()
											{
												$element.parent('.input-group').find('.input-group-addon').html('<i class="fa fa-search"></i>');
												icone_carregando_typeahead=null;
											}, 1000);
										}
									});
									$('#txtProcedimento').typeahead(
									{
										scrollBar:true,
										ajax:
										{
											url: base_url+'tiss/typeahead_codigoprocedimentos',
											triggerLength: 1,
											//items: 20,
											method:'POST',
											displayField: 'text',
											preProcess: function (data)
											{
												if (data.status == 1)
												{
													var list = [];
													$.each(data.dados, function(index, val)
													{
														list[index] = {'id':val.id, 'text':val.codigo+' - '+val.nome};
													});
													return list;
												}
												else
												{
													return false;
												}
											}
										},
										onSelect: function(data)
										{
											codigo = data.text.split(' - ');
											//$('#txtProcedimento').val(codigo[0]);
											$('#txtProcedimento').val(data.text);
											$('#codigoprocedimento_id').val(data.value);
										}
									});
									$('#codigoprocedimento_id').bind('callback', function()
									{
										$.ajax(
										{
											url: base_url+'tiss/typeahead_codigoprocedimentos/'+$('#codigoprocedimento_id').val(),
											type: 'POST',
											dataType: 'json',
											success: function(data)
											{
												$('#txtProcedimento').val( data.dados.codigo );
											}
										});
									});
								});
							</script>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
		</div>
		<?=form_close()?>
	</div>
</div>