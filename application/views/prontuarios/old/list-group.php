<script type="text/javascript">
	$('.titulo').html('<i class="fa fa-files-o"></i> Prontuários');
	var paciente_id = <?=$dados_paciente->id?>;
</script>
<?=form_open_multipart('prontuarios/salvar', array('id'=>'formProntuarios', 'role'=>'form'))?>
<div class="msg"></div>
<div class="row">
<!-- 		<div class="well" style="font-size: 40px;color: #cccccc;text-align: center;">
			<i class="fa fa-clock-o"></i> <span class="cronometro">00:00:00</span>
		</div>
		<a href="#" class="btn btn-block btn-success btn-cronometro font-bold"><i class="fa fa-play"></i> INICIAR ATENDIMENTO</a> -->
	<script type="text/javascript">
		var contador_salvamento_automatico = 0;
		var tempo_salvamento_automatico = 60; // em segundos
		function registra_cronometro()
		{
			setTimeout(function()
			{
				contador_salvamento_automatico = contador_salvamento_automatico + 1;
				if(contador_salvamento_automatico == tempo_salvamento_automatico)
				{
					$('#formProntuarios :submit').trigger('click');
					contador_salvamento_automatico=0;
				}

				Cookies.set('cronometro', $('.cronometro').data('seconds'));
				registra_cronometro();
			}, 1000);
		}
		$(function()
		{
			$('#formProntuarios input:text, textarea, select').on('blur', function(event)
			{
				setTimeout(function()
				{
					$(this).submit();
				}, 5000);
			});
			$('.ckeditor-basic').each(function()
			{
				var textarea_id = $(this).attr('id');
				CKEDITOR.instances[textarea_id].on('blur',function()
				{
					$('#formProntuarios :submit').trigger('click');
				});
			});
			$('.btn-cronometro').on('click', function(event)
			{
				event.preventDefault();
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
						}
					});
					//############################################################################
					$('#collapse_queixaprincipal').collapse('show');

					$('.cronometro').css({'color':'#2980B9'});
					$(this).removeClass('btn-success').addClass('btn-danger').html('<i class="fa fa-stop"></i> FINALIZAR ATENDIMENTO');
				}
				else
				{
					$('#modal-finalizaratendimento').modal('show');
				}
			});
			$('.btn-encerrar_atendimento').on('click', function(event)
			{
				event.preventDefault();

				$('#acao').val('encerrar');
				$('#tempoatendimento').val( Cookies.get('cronometro') );

					console.log( 'AAAAAAAAAAAA: '+$('.msg').text() );
				
				setTimeout(function()
				{
					$('#formProntuarios :submit').trigger('click');

					console.log( 'AAAAAAAAAAAA: '+$('.msg').text() );

					// if( $('.msg').html() )
					// {
					// 	alertify.alert('<strong><i class="fa fa-info-circle"></i>&nbsp;Atenção</strong>', '<strong>Para finalizar o prontuário, é necessário corrigir os erros.</strong>');
					// 	$('#modal-finalizaratendimento').modal('hide');
					// }
					// else
					// {
					// 	Cookies.remove('cronometro');
					// 	Cookies.remove('prontuario');

					// 	$('#modal-finalizaratendimento').modal('hide');

					// 	window.location.href=base_url;
					// }
				}, 500);
				
			});
		});
	</script>
	<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-body">
			<input type="hidden" id="paciente_id" name="paciente_id" value="<?=$dados_paciente->id?>">
			<input type="hidden" id="event_id" name="event_id" value="<?=$event_id?>">
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

<style type="text/css">
	.control-sidebar-bg,
	.control-sidebar
	{
		/*width: 300px !important;*/
	}
</style>
<!-- <button class="btn btn-default btn-mostrasidebar" data-toggle="control-sidebar">Toggle Right Sidebar</button> -->
<script type="text/javascript">
	$(function()
	{
		$('body').on('click', '.list-group a', function(event)
		{
			event.preventDefault();
			$(this).parents('.list-group').find('a').removeClass('active');
			$(this).addClass('active');

			$('[id^="form-"]').hide();
			$('.titulo-conteudo-form').html( $(this).html() );
			$('#'+$(this).data('href')).show();
		});
		// setTimeout(function()
		// {
		// 	html = [
		// 	'<div class="padding-10">',
		// 		'<div class="list-group">',
		// 			'<a href="#" class="list-group-item active" data-href="form-timeline"><i class="fa fa-history fa-fw"></i> Resumo</a>',
		// 			'<a href="#" class="list-group-item" data-href="form-queixaprincipal"><i class="fa fa-server fa-fw"></i> Queixa Principal</a>',
		// 			'<a href="#" class="list-group-item" data-href="form-anamnese"><i class="fa fa-ambulance fa-fw"></i> Anamnese</a>',
		// 			'<a href="#" class="list-group-item" data-href="form-examefisico"><i class="fa fa-child fa-fw"></i> Exame físico</a>',
		// 			'<a href="#" class="list-group-item" data-href="form-hipotesediagnostica"><i class="fa fa-quote-left fa-fw"></i> Hipótese Diagnótica</a>',
		// 			'<a href="#" class="list-group-item" data-href="form-evolucao"><i class="fa fa-male fa-fw"></i> Evolução</a>',
		// 			'<a href="#" class="list-group-item" data-href="form-prescricao"><i class="fa fa-file-text-o fa-fw"></i> Prescrição</a>',
		// 			'<a href="#" class="list-group-item" data-href="form-cartasatestados"><i class="fa fa-clipboard fa-fw"></i> Cartas e Atestados</a>',
		// 			'<a href="#" class="list-group-item" data-href="form-examesanexos"><i class="fa fa-upload fa-fw"></i> Exames e Anexos</a>',
		// 		'</div>',
		// 	'</div>',
		// 	].join('');

		// 	$.AdminLTE.controlSidebar.open();
		// 	$('.control-sidebar').html('').html(html);
		// }, 500);
	});
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><!--  style="background-color: #222D32;"> -->
				<h3 class="panel-title titulo-conteudo-form">Resumo</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div id="form-timeline">
							<div class="container-fluid">
								<div class="row">
									<div class="timelinedotted-centered timelinedotted-body">
										<script type="text/javascript">
											// $.ajax(
											// {
											// 	url: base_url+'pacientes/get',
											// 	type: 'POST',
											// 	data: 'id='+paciente_id,
											// 	dataType: 'json',
											// 	success: function(data)
											// 	{
											// 		//console.log(data.paciente);
											// 	}
											// });
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
																	html = html+'<div class="pull-left anexos_dropzone" style="margin-left: 50px;" data-toggle="tooltip" data-placement="bottom" title="'+val.descricao+'"><a data-fancybox="group'+prontuario_id+'" data-fancybox title="'+val.descricao+'" href="'+base_url+'uploads/'+val.arquivo+'"><img data-id="'+val.id+'" width="120" class="img-thumbnail" src="'+base_url+'uploads/'+val.arquivo+'"></a></div>';
																}
																else
																{
																	html = html+'<div class="pull-left anexos_dropzone" style="margin-left: 50px;" data-toggle="tooltip" data-placement="bottom" title="'+val.descricao+'"><a data-fancybox="group'+prontuario_id+'" data-fancybox title="'+val.descricao+'" data-src="'+base_url+'uploads/'+val.arquivo+'" href="javascript:;"><img data-id="'+val.id+'" width="120" class="img-thumbnail" src="'+base_url+'assets/img/iconepdfmaior.png"></a></div>';
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
													$.each(data.prontuarios, function(index, val)
													{
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
																			'<h2>Atendido por: <a href="#"><?=$this->session->dados_usuario->nome?></a> <span class="pull-right"><i class="fa fa-clock-o"></i> '+moment(val.data).format('HH:mm')+' (Duração: '+moment.utc( val.tempoatendimento * 1000 ).format('HH:mm:ss')+')</span></h2>',
																			'<p>',
																				'<div>',
																					'<div class="titulo-item-timeline"><i class="fa fa-server"></i> Queixa Principal</div>',
																					'<div class="conteudo-item-timeline">',
																						'<div class="font-bold">Queixa principal:</div>',
																						'<div class="text-indent-20">'+val.queixaprincipal+'</div>',
																						].join('');

																						if(val.historia)
																						{
																							html_timeline += [
																								'<div class="font-bold">História:</div>',
																								'<div class="text-indent-20">'+val.historia+'</div>',
																							].join('');
																						}

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
																						''+$(val.anamnese).text()+'',
																					'</div>',
																				'</div>',
																				].join('');
																	}
																	if( val.altura || val.peso || val.frequenciacardiaca || val.pressaoarterialsistolica || val.pressaoarterialdiastolica )
																	{
																		html_timeline += [
																					'<div>',
																						'<div class="titulo-item-timeline"><i class="fa fa-child"></i> Exame físico</div>',
																						'<div class="conteudo-item-timeline">',
																							'<div class="font-11"><strong>Altura:</strong> '+val.altura+'</div>',
																							'<div class="font-11"><strong>Peso:</strong> '+val.peso+'</div>',
																							'<div class="font-11"><strong>Frequencia cadiáca:</strong> '+val.frequenciacardiaca+'</div>',
																							'<div class="font-11"><strong>Pressão Arterial Sistólica:</strong> '+val.pressaoarterialsistolica+'</div>',
																							'<div class="font-11"><strong>Pressão Arterial Diastólica:</strong> '+val.pressaoarterialdiastolica+'</div>',
																						'</div>',
																					'</div>',
																		].join('');
																	}
																	if(val.hipotesediagnostica)
																	{
																		html_timeline += [
																				'<div>',
																					'<div class="titulo-item-timeline"><i class="fa fa-quote-left"></i> Hipótese Diagnótica</div>',
																					'<div class="conteudo-item-timeline">',
																						''+val.hipotesediagnostica+'',
																					'</div>',
																				'</div>',
																				].join('');
																	}
																	if(val.evolucao)
																	{
																		html_timeline += [
																				'<div>',
																					'<div class="titulo-item-timeline"><i class="fa fa-male"></i> Evolução</div>',
																					'<div class="conteudo-item-timeline">',
																						''+val.evolucao+'',
																					'</div>',
																				'</div>',
																				].join('');
																	}
																	if(val.prescricao)
																	{
																		html_timeline += [
																				'<div>',
																					'<div class="titulo-item-timeline"><i class="fa fa-file-text-o"></i> Prescrição</div>',
																					'<div class="conteudo-item-timeline">',
																						''+val.prescricao+'',
																					'</div>',
																				'</div>',
																				].join('');
																	}
																	html_timeline += [
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

														// html_timeline = [


														// '<li class="time-label">',
														// 	'<span class="bg-blue font-center" style="padding: 5px 15px 5px 15px;">',
														// 		'<div style="font-size: 30px;line-height: 35px;">'+moment(val.data).format('DD')+'</div>',
														// 		'<div style="font-size: 16px;">'+moment(val.data).format('MMM').toUpperCase()+'</div>',
														// 		'<hr style="line-height: 5px;margin: 1px;">',
														// 		'<div style="font-size: 14px;">'+moment(val.data).format('YYYY')+'</div>',
														// 	'</span>',
														// '</li>',
														// '<li>',
														// 	'<i class="fa fa-circle text-blue"></i>',
														// 	'<div class="timeline-item">',
														// 		'<span class="time"><i class="fa fa-clock-o"></i> '+moment(val.data).format('HH:mm')+' (Duração: '+moment.utc( val.tempoatendimento * 1000 ).format('HH:mm:ss')+')</span>',

														// 		'<h3 class="timeline-header">Atendido por: <a href="#"><?=$this->session->dados_usuario->nome?></a></h3>',
														// 		'<br>',
														// 		'<div class="timeline-body padding-0">',
														// 		'</div>',
														// 	'</div>',
														// '</li>',
														// ].join('');
														$('.timelinedotted-body').prepend(html_timeline);
														html_timeline = '';
													});
												}
											});
										</script>
									</div>
								</div>
							</div>
						</div>
						<div id="form-queixaprincipal" class="display-none">
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
						<div id="form-anamnese" class="display-none">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtModeloAnamnese" class="control-label">Modelo Anamnese</label>
										<select class="selectpicker form-control" id="txtModeloAnamnese" name="txtModeloAnamnese" data-live-search="true" data-style="btn-default btn-sm">
											<option></option>
										</select>
										<script type="text/javascript">
											$(function()
											{
												$.ajax(
												{
													url: base_url+'anamneses/anamneses',
													type: 'POST',
													//data: 'txtCampo='+$('txtCampo').val(),
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
												}).on('.blur', function(event)
												{
													$('#formProntuarios :submit').trigger('click');
												});;
											});
										</script>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<label for="txtAnamnese" class="control-label">Anamnese (detalhada)</label>
										<textarea class="ckeditor-basic" data-field-db="<?=sha1('prontuarios.anamnese')?>" id="txtAnamnese" name="txtAnamnese"></textarea>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
						</div>
						<div id="form-examefisico" class="display-none">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group form-group-sm">
										<label for="txtAltura" class="control-label">Altura</label>
										<input type="text" class="form-control" id="txtAltura" name="txtAltura" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.altura')?>" placeholder="Altura">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group form-group-sm">
										<label for="txtPeso" class="control-label">Peso</label>
										<input type="text" class="form-control" id="txtPeso" name="txtPeso" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.peso')?>" placeholder="Peso">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group form-group-sm">
										<label for="txtFrequenciaCardiaca" class="control-label">Frequencia cadiáca</label>
										<input type="text" class="form-control" id="txtFrequenciaCardiaca" name="txtFrequenciaCardiaca" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.frequenciacardiaca')?>" placeholder="Frequencia cadiáca">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtPressaoArterialSistolica" class="control-label">Pressão Arterial Sistólica</label>
										<input type="text" class="form-control" id="txtPressaoArterialSistolica" name="txtPressaoArterialSistolica" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.pressaoarterialsistolica')?>" placeholder="Pressão Arterial">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group form-group-sm">
										<label for="txtPressaoArterialDiastolica" class="control-label">Pressão Arterial Diastólica</label>
										<input type="text" class="form-control" id="txtPressaoArterialDiastolica" name="txtPressaoArterialDiastolica" autocomplete="off" spellcheck="false" dir="auto" data-field-db="<?=sha1('prontuarios.pressaoarterialdiastolica')?>" placeholder="Pressão Arterial Diastólica">
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
						</div>
						<div id="form-hipotesediagnostica" class="display-none">
							<h4><i class="fa fa-quote-left"></i> Hipótese Diagnótica</h4>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<textarea class="ckeditor-basic" id="txtHipoteseDiagnostica" rows="5" name="txtHipoteseDiagnostica" data-field-db="<?=sha1('prontuarios.hipotesediagnostica')?>" placeholder="Hipótese Diagnóstica"></textarea>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
						</div>
						<div id="form-evolucao" class="display-none">
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
						<div id="form-prescricao" class="display-none">
							<h4><i class="fa fa-file-text-o"></i> Prescrição</h4>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<textarea class="ckeditor-basic form-control" id="txtPrescricao" rows="5" name="txtPrescricao" data-field-db="<?=sha1('prontuarios.prescricao')?>" placeholder="Prescrição"></textarea>
										<small class="msg-erro text-danger"></small>
									</div>
								</div>
							</div>
						</div>
						<div id="form-cartasatestados" class="display-none">
							<div class="msg-cartasatestados"></div>
							<h4><i class="fa fa-clipboard"></i> Cartas e Atestados</h4>
							<div class="row">
								<div class="col-cartasatestados col-md-12 margin-bottom-20">
									<div class="panel panel-default">
										<!-- <div class="panel-heading">Cartas/Atestados (registrados)</div> -->
										<div class="panel-body">
											<div class="registros-cartasatestados"><i class="fa fa-refresh fa-spin"></i> Verificando registros...</div>
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
										<select class="selectpicker form-control" id="txtModelosCartasAtestados" name="txtModelosCartasAtestados" data-live-search="true" data-style="btn-default btn-sm">
											<option></option>
										</select>
										<script type="text/javascript">
											$(function()
											{
												$.ajax(
												{
													url: base_url+'cartasatestados/cartasatestados',
													type: 'POST',
													//data: 'txtCampo='+$('txtCampo').val(),
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
							<a class="btn btn-success btn-salvarcartaatestado">Salvar Carta/Atestado</a>
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
												$('.col-cartasatestados').show();

												html = '';
												$.each(data.cartasatestados, function(index, val)
												{
													html = html+'<tr><td><div class="padding-10"><small><strong>Data: '+date_to_br(val.data)+'</strong></small><small>'+val.texto+'</small><a class="btn btn-danger btn-xs btn-remove-cartaatestado" data-id="'+val.id+'">Remover</a></div></td></tr>';
												});
												$('.registros-cartasatestados').html('<table class="table table-striped table-hover"><tbody>'+html+'</tbody></table>');
											}
											else
											{										
												$('.col-cartasatestados').hide();
											}
										}
									});
								}
								setTimeout(function()
								{
									get_cartasatestados();
								}, 500);
							</script>
						</div>
						<div id="form-examesanexos" class="display-none">
							<div class="row">
								<div class="col-registros-examesanexos col-md-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="registros-examesanexos"><i class="fa fa-refresh fa-spin"></i> Verificando registros...</div>
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
															alertify.warning('<i class="fa fa-ban"></i> Seu atendimento ainda não foi iniciado para anexar arquivos');
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
										setTimeout(function()
										{
											if( $('#prontuario_id').val() )
											{
												get_examesanexos();
											}
										}, 500);
										function get_examesanexos()
										{
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
														$('.col-registros-examesanexos').show();

														html = '';
														$.each(data.examesanexos, function(index, val)
														{
															var imagens = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
															if ( $.inArray(val.arquivo.split('.').pop().toLowerCase(), imagens) > -1 )
															{
																html = html+'<div class="pull-left anexos_dropzone" style="margin-left: 50px;" data-toggle="tooltip" data-placement="bottom" title="'+val.descricao+'"><a title="'+val.descricao+'" data-fancybox="group" data-fancybox href="'+base_url+'uploads/'+val.arquivo+'"><img data-id="'+val.id+'" width="120" class="img-thumbnail" src="'+base_url+'uploads/'+val.arquivo+'"></a><span class="close excluir-examesanexos">&times;</span></div>';
															}
															else
															{
																html = html+'<div class="pull-left anexos_dropzone" style="margin-left: 50px;" data-toggle="tooltip" data-placement="bottom" title="'+val.descricao+'"><a title="'+val.descricao+'" data-fancybox="group" data-fancybox data-src="'+base_url+'uploads/'+val.arquivo+'" href="javascript:;"><img data-id="'+val.id+'" width="120" class="img-thumbnail" src="'+base_url+'assets/img/iconepdfmaior.png"></a><span class="close excluir-examesanexos">&times;</span></div>';
															}
														});
														$('.registros-examesanexos').html(html);
													}
													else
													{
														$('.col-registros-examesanexos').hide();
													}
												}
											});
										}
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
										<br><br>
										<a href="javascript:void(0);" class="btn btn-success btn-salvarexamesanexos">Enviar</a>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="pull-right">
									<!-- <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fa fa-times-circle"></i> Fechar</button> -->
									<button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;Salvar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<aside class="control-sidebar control-sidebar-dark">
	<div class="padding-10">
		<div class="well" style="font-size: 30px;color: #cccccc;text-align: center;">
			<i class="fa fa-clock-o"></i> <span class="cronometro">00:00:00</span>
		</div>
		<a href="#" class="btn btn-block btn-success btn-cronometro font-bold"><i class="fa fa-play"></i> INICIAR ATENDIMENTO</a>
		<br>
		<div class="list-group">
			<a href="#" class="list-group-item active" data-href="form-timeline"><i class="fa fa-history fa-fw"></i> Resumo</a>
			<a href="#" class="list-group-item" data-href="form-queixaprincipal"><i class="fa fa-server fa-fw"></i> Queixa Principal</a>
			<a href="#" class="list-group-item" data-href="form-anamnese"><i class="fa fa-ambulance fa-fw"></i> Anamnese</a>
			<a href="#" class="list-group-item" data-href="form-examefisico"><i class="fa fa-child fa-fw"></i> Exame físico</a>
			<a href="#" class="list-group-item" data-href="form-hipotesediagnostica"><i class="fa fa-quote-left fa-fw"></i> Hipótese Diagnótica</a>
			<a href="#" class="list-group-item" data-href="form-evolucao"><i class="fa fa-male fa-fw"></i> Evolução</a>
			<a href="#" class="list-group-item" data-href="form-prescricao"><i class="fa fa-file-text-o fa-fw"></i> Prescrição</a>
			<a href="#" class="list-group-item" data-href="form-cartasatestados"><i class="fa fa-clipboard fa-fw"></i> Cartas e Atestados</a>
			<a href="#" class="list-group-item" data-href="form-examesanexos"><i class="fa fa-upload fa-fw"></i> Exames e Anexos</a>
		</div>
	</div>
</aside>
<script type="text/javascript">
	setTimeout(function()
	{
		$.AdminLTE.controlSidebar.open();
	}, 1000);
</script>
<script type="text/javascript">
	function clear_inputs_modal()
	{
		$('#formProntuarios').find(':text, :password, :file, textarea').val('');
		$('#formProntuarios').find(':radio, :checkbox').attr("checked",false);
		$('#formProntuarios').find('select').val('');
		clear_form_erros();
	}
	function clear_form_erros()
	{
		$('.msg').html('');
		$('.msg-erro').html('');
		$('.has-error').removeClass('has-error');
		$('.modal-msg').html('');
		$('.nav-tabs').find('.cont').html(''); // Limpa contadores de erros (NAVTABS)
		$('.nav-tabs a:first').tab('show');
	}
	//###############################################################################################
	$(document).on("hide.bs.collapse show.bs.collapse", ".collapse", function (event)
	{
		$(this).prev().find(".fa").toggleClass("fa-chevron-right fa-chevron-down");
		event.stopPropagation();
	});
	//###############################################################################################
	$(function()
	{
		$('#formProntuarios').on('submit', function(event)
		{
			event.preventDefault();

			clear_form_erros();

			var $form = $(this);
			var $button_submit = $form.find('button:submit');
			$button_submit.data('loading-text', '<i class="fa fa-circle-o-notch fa-spin"></i> Carregando...');
			$button_submit.button('loading');
			//################################################################################################
			// FIX ATUALIZAÇÃO DE CONTEÚDO E EMVIO AJAX DO CKEDITOR
			$('[class^="ckeditor"]').each(function(index, el)
			{
				var name = $(el).attr('name');
				CKEDITOR.instances[name].updateElement();
			});
			//################################################################################################
			// FIX ENVIAR FORM NORMAL OU UPLOAD
			var $data;
			var contentType = "application/x-www-form-urlencoded";
			var processData = true;
			//################################################################################################
			if( $form.attr('enctype') == 'multipart/form-data' )
			{
				var $data = new FormData( $form.get(0) );
				var contentType = false;
				var processData = false;
				//################################################################################################
				// FIX para correção de erros de enviar input:checbox VAZIOS juntos com os outros campos via ajax.
				$form.find('input:checkbox').each(function(index, el)
				{
					if( $(el).prop('checked') == false )
					{
						value = ($(el).data('value')) ? $(el).data('value') : 'off';
						$(el).prop('value', value);
						$(el).prop('checked', false);
						$data.append( $(el).prop('name'), '' );
					}
					else
					{
						value = ($(el).data('value')) ? $(el).data('value') : 'on';
						$(el).prop('value', value);
						$(el).prop('checked', true);
						$data.append( $(el).prop('name'), $(el).prop('value') );
					}
				});
				//################################################################################################
				//$data.append('txtCAMPO', 'txtCAMPO_VALUE');
			}
			else // FIX para correção de erros de enviar input:checbox VAZIOS juntos com os outros campos via ajax.
			{
				var $data = $form.serialize()+'&'+$form.find('input:checkbox').map(function(i, e)
				{
					if( $(e).prop('checked') == false )
					{
						value = ($(e).data('value')) ? $(e).data('value') : 'off';
						$(e).prop('value', value);
						$(e).prop('checked', false);
						return $(e).prop('name')+'=';
					}
					else
					{
						value = ($(e).data('value')) ? $(e).data('value') : 'on';
						$(e).prop('value', value);
						$(e).prop('checked', true);
					}
				}).get().join('&');
				//################################################################################################
			}
			$.ajax(
			{
				url: $form.attr('action'),
				type: $form.attr('method'),
				data: $data,
				dataType: 'json',
				cache : false,
				contentType: contentType,
				processData: processData,
			})
			.done(function(data) //success
			{
				//console.log("success");
				$button_submit.button('reset');

				if(data.status == 1)
				{
					//alertify.success('<i class="fa fa-check-circle-o"></i> '+data.msg);
					if(data.acao=='cadastrar')
					{
						window.location.href=base_url;
					}
				}
				else
				{
					var LinkNavTabs = '';
					var cont = 0;
					var msg = '';
					$.each(data.erros, function(campo, valor)
					{
						var Input = $('[name='+campo+']');
						Input.parents('.form-group').eq(0).addClass('has-error');
						msg += '<div><small>'+valor+'</small></div>';

						LinkNavTabs = Input.parents('.tab-pane').eq(0).prop('id');
						if(LinkNavTabs)
						{
							var ElementCont = $('.nav-tabs a[aria-controls="'+LinkNavTabs+'"]').find('.cont');
							cont = parseInt( ElementCont.text() );
							if( isNaN(cont) )
							{
								cont=1;
							}
							else
							{
								cont = cont + 1;
							}
							ElementCont.html('<span class="badge">'+cont+'</span>'); //.html('<span class="label label-warning">'+cont+'</span>');
							cont = 0;
						}
					});
					$('.msg')
					.html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+msg+'</div>')
					.show();

					if(LinkNavTabs)
					{
						$element = null;
						$tab = null;
						$('.nav-tabs').find('.cont').each(function(index, el)
						{
							if( $(el).text().length > 0 )
							{
								$element = $(el);
								return false;
							}
						});
						//console.log('tab: '+$element.parents('a').attr('aria-controls'));
						$element.parents('a').tab('show');
					}
				}
			})
			.fail(function()
			{
				//console.log("error");
				$button_submit.button('reset');
			})
			.always(function()
			{
				//console.log("complete");
				$button_submit.button('reset');
			});
		});
	});
</script>
<script language="javascript">
	if( Cookies.get('prontuario') )
	{
		$('#prontuario_id').val( Cookies.get('prontuario') )
		//############################################################################
		$('#collapse_queixaprincipal').collapse('show');

		$('.cronometro').css({'color':'#2980B9'});
		$('.btn-cronometro').removeClass('btn-success').addClass('btn-danger').html('<i class="fa fa-stop"></i> FINALIZAR ATENDIMENTO');

		$('.cronometro').timer(
		{
			action: 'start',
			format: '%H:%M:%S',
			seconds: Cookies.get('cronometro'),
		});
		registra_cronometro();

		$.ajax(
		{
			url: base_url_controller+'getvaluesinputs',
			type: 'POST',
			data: 'id='+Cookies.get('prontuario'),
			dataType: 'json',
			success: function(data)
			{
				$.each(data.inputs, function(campo, valor)
				{
					$element = $('[data-field-db='+campo+']');

					if( $element.prop('type') == 'text' )
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
						$element.selectpicker('val',valor);
					}
					else
					{
						$element.val(valor);
					}
				});
			}
		});
	}
	//$('#collapse_examesanexos').collapse('show');
	//window.onbeforeunload = function(){return 'Se você fechar o navegador, seus dados serão perdidos. Deseja realmente Sair?'};
</script>
<?=form_close()?>