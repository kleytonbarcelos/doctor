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
		setTimeout(function()
		{
			html = [
			'<div class="padding-10">',
				'<div class="list-group">',
					'<a href="#" class="list-group-item active" data-href="form-timeline"><i class="fa fa-history fa-fw"></i> Resumo</a>',
					'<a href="#" class="list-group-item" data-href="form-queixaprincipal"><i class="fa fa-server fa-fw"></i> Queixa Principal</a>',
					'<a href="#" class="list-group-item" data-href="form-anamnese"><i class="fa fa-ambulance fa-fw"></i> Anamnese</a>',
					'<a href="#" class="list-group-item" data-href="form-examefisico"><i class="fa fa-child fa-fw"></i> Exame físico</a>',
					'<a href="#" class="list-group-item" data-href="form-hipotesediagnostica"><i class="fa fa-quote-left fa-fw"></i> Hipótese Diagnótica</a>',
					'<a href="#" class="list-group-item" data-href="form-evolucao"><i class="fa fa-male fa-fw"></i> Evolução</a>',
					'<a href="#" class="list-group-item" data-href="form-prescricao"><i class="fa fa-file-text-o fa-fw"></i> Prescrição</a>',
					'<a href="#" class="list-group-item" data-href="form-cartasatestados"><i class="fa fa-clipboard fa-fw"></i> Cartas e Atestados</a>',
					'<a href="#" class="list-group-item" data-href="form-examesanexos"><i class="fa fa-upload fa-fw"></i> Exames e Anexos</a>',
				'</div>',
			'</div>',
			].join('');

			$.AdminLTE.controlSidebar.open();
			$('.control-sidebar').html('').html(html);
		}, 500);
	});
</script>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<div class="panel bg-navy">
		<div class="panel-heading" role="tab" id="heading_timeline">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_timeline" aria-expanded="true" aria-controls="collapse_timeline">
					<i class="fa fa-history fa-fw"></i> Hitórico de Prontuários
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse_timeline" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_timeline">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<ul class="timeline">
							<script type="text/javascript">
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
											'<li class="time-label">',
												'<span class="bg-blue font-center" style="padding: 5px 15px 5px 15px;">',
													'<div style="font-size: 30px;line-height: 35px;">'+moment(val.data).format('DD')+'</div>',
													'<div style="font-size: 16px;">'+moment(val.data).format('MMM').toUpperCase()+'</div>',
													'<hr style="line-height: 5px;margin: 1px;">',
													'<div style="font-size: 14px;">'+moment(val.data).format('YYYY')+'</div>',
												'</span>',
											'</li>',
											'<li>',
												'<i class="fa fa-circle text-blue"></i>',
												'<div class="timeline-item">',
													'<span class="time"><i class="fa fa-clock-o"></i> '+moment(val.data).format('HH:mm')+' (Duração: '+moment.utc( val.tempoatendimento * 1000 ).format('HH:mm:ss')+')</span>',

													'<h3 class="timeline-header">Atendido por: <a href="#"><?=$this->session->dados_usuario->nome?></a></h3>',
													'<br>',
													'<div class="timeline-body padding-0">',
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
													'</div>',
												'</div>',
											'</li>',
											].join('');
											$('.timeline').prepend(html_timeline);
											html_timeline = '';
										});
									}
								});
							</script>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading_queixaprincipal">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_queixaprincipal" aria-expanded="false" aria-controls="collapse_queixaprincipal">
					<i class="fa fa-server fa-fw"></i> Queixa Principal
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse_queixaprincipal" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_queixaprincipal">
			<div class="panel-body">
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
	</div>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading_anamnese">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_anamnese" aria-expanded="false" aria-controls="collapse_anamnese">
					<i class="fa fa-ambulance fa-fw"></i> Anamnese
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse_anamnese" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_anamnese">
			<div class="panel-body">
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
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading_examefisico">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_examefisico" aria-expanded="false" aria-controls="collapse_examefisico">
					<i class="fa fa-child fa-fw"></i> Exame físico
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse_examefisico" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_examefisico">
			<div class="panel-body">
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
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading_hipotesediagnostica">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_hipotesediagnostica" aria-expanded="false" aria-controls="collapse_hipotesediagnostica">
					<i class="fa fa-quote-left fa-fw"></i> Hipótese Diagnótica
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse_hipotesediagnostica" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_hipotesediagnostica">
			<div class="panel-body">
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
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading_evolucao">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_evolucao" aria-expanded="false" aria-controls="collapse_evolucao">
					<i class="fa fa-male fa-fw"></i> Evolução
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse_evolucao" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_evolucao">
			<div class="panel-body">
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
	</div>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading_prescricao">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_prescricao" aria-expanded="false" aria-controls="collapse_prescricao">
					<i class="fa fa-file-text-o fa-fw"></i> Prescrição
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse_prescricao" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_prescricao">
			<div class="panel-body">
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
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading_cartasatestados">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_cartasatestados" aria-expanded="false" aria-controls="collapse_cartasatestados">
					<i class="fa fa-clipboard fa-fw"></i> Cartas e Atestados
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse_cartasatestados" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_cartasatestados">
			<div class="panel-body">
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
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="heading_examesanexos">
			<h4 class="panel-title">
				<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_examesanexos" aria-expanded="false" aria-controls="collapse_examesanexos">
					<i class="fa fa-upload fa-fw"></i> Exames e Anexos
					<span class="pull-right"><i class="fa fa-chevron-right"></i></span>
				</a>
			</h4>
		</div>
		<div id="collapse_examesanexos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_examesanexos">
			<div class="panel-body">
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
		</div>
	</div>
</div>