<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Painel de Controle</title>
	<link rel="icon" href="<?=base_url()?>assets/img/favicon.ico">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery/jquery-1.11.3.min.js"></script>											<!-- JQUERY 1.11.3 -->
	<script src='<?=base_url()?>assets/libs/moment/min/moment-with-locales.min.js'></script>														<!-- MOMENT JS -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/script.js"></script>																<!-- JS LOCAL -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/functions.js"></script>																<!-- JS FUNÇÃO -->

	<link rel="stylesheet" href="<?=base_url()?>assets/libs/bootstrap/css/bootstrap.min.css">														<!-- BOOTSTRAP 3 (CSS) -->
	<!-- <link rel="stylesheet" href="<?=base_url()?>assets/libs/bootstrap/css/bootstrap-theme.min.css"> -->													<!-- BOOTSTRAP 3 (CSS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap/js/bootstrap.min.js"></script>											<!-- BOOTSTRAP 3 (JS) -->
	<link rel="stylesheet" href="<?=base_url()?>assets/libs/font-awesome/css/font-awesome.min.css">													<!-- FONTAWESOME -->
	<link rel="stylesheet" href="<?=base_url()?>assets/templates/AdminLTE/dist/css/AdminLTE.min.css">												<!-- TEMA ADMINLTE (CSS) -->
	<link rel="stylesheet" href="<?=base_url()?>assets/templates/AdminLTE/dist/css/skins/_all-skins.min.css">										<!-- TEMA ADMINLTE (CSS) -->

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/bootstrap-table/dist/bootstrap-table.min.css">							<!-- BOOTSTRA-TABLE (CSS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-table/dist/bootstrap-table.min.js"></script>							<!-- BOOTSTRA-TABLE (JS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-table/dist/locale/bootstrap-table-pt-BR.min.js"></script>				<!-- BOOTSTRA-TABLE (PT-BR) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js"></script>	<!-- BOOTSTRA-TABLE (PLUGIN - EXPORT) -->

	<!--<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/bootstrap-select/dist/css/bootstrap-select.min.css">-->					<!-- BOOTSTRAP-SELECT (CSS) -->
	<!--<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-select/dist/js/bootstrap-select.min.js"></script>-->						<!-- BOOTSTRAP-SELECT (JS) -->
	<!--<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-select/dist/js/i18n/defaults-pt_BR.min.js"></script>-->					<!-- BOOTSTRAP-SELECT (JS) -->

	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery.print/jQuery.print.js"></script>

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/bootstrap-ajax-typeahead/config.css">
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-ajax-typeahead/js/bootstrap-typeahead.min.js"></script>

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/jquery.spinner/dist/css/bootstrap-spinner.min.css">
	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery.spinner/dist/js/jquery.spinner.min.js"></script>

	<link rel="stylesheet" href="<?=base_url()?>assets/libs/bootstrap-select/dist/css/bootstrap-select.min.css">
	<script src="<?=base_url()?>assets/libs/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="<?=base_url()?>assets/libs/bootstrap-select/dist/js/i18n/defaults-pt_BR.min.js"></script>
	<script src="<?=base_url()?>assets/libs/bootstrap-select/config.js"></script>

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/jquery-toast-plugin/dist/jquery.toast.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/jquery-toast-plugin/config.css">
	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery-toast-plugin/dist/jquery.toast.min.js"></script>

	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery.md5/jquery.md5.js"></script>
	
	<script type="text/javascript" src="<?=base_url()?>assets/libs/ImageMapster/dist/jquery.imagemapster.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/ImageMapster/config.js"></script>

	

	<script src="<?=base_url()?>assets/libs/jslug/src/jslug.js"></script>

	<script src="<?=base_url()?>assets/libs/js-cookie/src/js.cookie.js"></script>
	
	<script src="<?=base_url()?>assets/libs/cep/cep.js"></script>

	<script src="<?=base_url()?>assets/libs/timer.jquery/dist/timer.jquery.min.js"></script>

	<script src="<?=base_url()?>assets/libs/jquery-textavatar/jquery.textavatar.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/jquery-textavatar/textavatar.css">

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/dropzone/dist/min/dropzone.min.css">
	<script src="<?=base_url()?>assets/libs/dropzone/dist/min/dropzone.min.js"></script>
	<script src="<?=base_url()?>assets/libs/dropzone/config.js"></script>

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/timelinedotted.css">

	<script src="<?=base_url()?>assets/libs/fancyBox-3.0/dist/jquery.fancybox.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/fancyBox-3.0/dist/jquery.fancybox.min.css">

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/select2/dist/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/select2/config.css">
	<script src="<?=base_url()?>assets/libs/select2/dist/js/select2.full.min.js"></script>
	<script src="<?=base_url()?>assets/libs/select2/config.js"></script>

	<script type="text/javascript" src='<?=base_url()?>assets/libs/jsPDF/dist/jspdf.min.js'></script>
	<script type="text/javascript" src='<?=base_url()?>assets/libs/jsPDF/config.js'></script>


	<!-- 	<script type="text/javascript" src='<?=base_url()?>assets/libs/jsPDF/libs/html2pdf.js'></script> -->

	<!-- <script type="text/javascript" src="http://rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js"></script> -->

	<!--<script src="<?=base_url()?>assets/libs/tableExport.jquery.plugin/tableExport.js"></script>-->												<!-- TABLEEXPORT (BOOTSTRAP-TABLE) -->
	<!--<script src="<?=base_url()?>assets/libs/tableExport.jquery.plugin/jquery.base64.js"></script>-->											<!-- TABLEEXPORT (BOOTSTRAP-TABLE) -->
	<!--<script type="text/javascript" src="<?=base_url()?>assets/libs/html2canvas/dist/html2canvas.min.js"></script>-->							<!-- TABLEEXPORT (BOOTSTRAP-TABLE) -->
	<!--<script type="text/javascript" src="<?=base_url()?>assets/libs/html2canvas/dist/html2canvas.svg.min.js"></script>-->						<!-- TABLEEXPORT (BOOTSTRAP-TABLE) -->
	<!--<script type="text/javascript" src="<?=base_url()?>assets/libs/tableExport.jquery.plugin/jspdf/libs/sprintf.js"></script>-->				<!-- TABLEEXPORT (BOOTSTRAP-TABLE) -->
	<!--<script type="text/javascript" src="<?=base_url()?>assets/libs/tableExport.jquery.plugin/jspdf/jspdf.js"></script>-->						<!-- TABLEEXPORT (BOOTSTRAP-TABLE) -->
	<!--<script type="text/javascript" src="<?=base_url()?>assets/libs/tableExport.jquery.plugin/jspdf/libs/base64.js"></script>-->					<!-- TABLEEXPORT (BOOTSTRAP-TABLE) -->

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">	<!-- BOOTSTRAP-DATETIMEPICKER (CSS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>		<!-- BOOTSTRAP-DATETIMEPICKER (JS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-datetimepicker/config.js"></script>		<!-- BOOTSTRAP-DATETIMEPICKER (JS - CONFIG) -->

	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>		<!-- JQUERY INPUTMASK (JS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery.inputmask/config.js"></script>		<!-- JQUERY INPUTMASK CONFIG (JS) -->

	<link href='<?=base_url()?>assets/libs/fullcalendar/2.9.1/fullcalendar.css' rel='stylesheet' />													<!-- FULL CALENDAR 2.9.1 (CSS) -->
	<link href='<?=base_url()?>assets/libs/fullcalendar/2.9.1/fullcalendar.print.css' rel='stylesheet' media='print' />								<!-- FULL CALENDAR 2.9.1 (CSS) -->
	<script src='<?=base_url()?>assets/libs/fullcalendar/2.9.1/fullcalendar.min.js'></script>															<!-- FULL CALENDAR 2.9.1 (JS) -->
	<script src='<?=base_url()?>assets/libs/fullcalendar/2.9.1/lang/pt-br.js'></script>																<!-- FULL CALENDAR 2.9.1 (PT-BR) -->

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/alertifyjs/css/alertify.min.css">										<!-- ALERTIFY (CSS) -->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/alertifyjs/css/themes/default.min.css">									<!-- ALERTIFY (CSS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/alertifyjs/alertify.min.js"></script>											<!-- ALERTIFY (JS) -->
	<script type="text/javascript" src="<?=base_url()?>assets/libs/alertifyjs/config.js"></script>													<!-- ALERTIFY (CONFIG) -->


<!-- 	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/bootstrap-fileinput/css/fileinput.min.css">
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-fileinput/js/plugins/sortable.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-fileinput/js/plugins/purify.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-fileinput/js/fileinput.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-fileinput/themes/fa/theme.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-fileinput/js/locales/pt-BR.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-fileinput/config.js"></script> -->
	

	<script type="text/javascript" src="<?=base_url()?>assets/libs/ckeditor/ckeditor.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/ckeditor/adapters/jquery.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/ckeditor/config.js"></script>

	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery-price-format/jquery.price_format.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery-price-format/config.js"></script>

	<script src="<?=base_url()?>assets/libs/jquery.base64/jquery.base64.js"></script>
	<script src="<?=base_url()?>assets/libs/jquery.base64/config.js"></script>


	<!-- <link href='https://fonts.googleapis.com/css?family=Indie+Flower|Oxygen|Cookie' rel='stylesheet' type='text/css'> -->

	<!-- <link rel="stylesheet" href="<?=base_url()?>assets/libs/ionicons/css/ionicons.min.css"> -->

	<!--<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/libs/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
	<script type="text/javascript" src="<?=base_url()?>assets/libs/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>-->

	<!--<link href='<?=base_url()?>assets/libs/fullcalendar/fullcalendar.css' rel='stylesheet' />
	<link href='<?=base_url()?>assets/libs/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
	<script src='<?=base_url()?>assets/libs/fullcalendar/fullcalendar.min.js'></script>
	<script src='<?=base_url()?>assets/libs/fullcalendar/lang/pt-br.js'></script>-->

	<!--<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery/jquery.print/jquery.print.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery/jquery.print/config.js"></script>

	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery/jquery-price-format/jquery.price_format.min.js"></script>
	<script type="text/javascript" src="<?=base_url()?>assets/libs/jquery/jquery-price-format/config.js"></script>-->

	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/css.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-print.css">



	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="<?=base_url()?>assets/libs/bootstrap/js/html5shiv.min.js"></script>
		<script src="<?=base_url()?>assets/libs/bootstrap/js/respond.min.js"></script>
	<![endif]-->
	<script type="text/javascript">
		var base_url = '<?=base_url()?>';
		var base_url_controller = '<?=base_url().$this->router->fetch_class()?>/';
		var controller = '<?=$this->router->fetch_class()?>';
	</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<!-- Logo -->
			<a href="<?=base_url()?>" class="logo">
				<span class="logo-mini"><i class="fa fa-heartbeat"></i></span>
				<span class="logo-lg"><strong><i class="fa fa-heartbeat"></i> DOCTOR</strong></span>
			</a>
			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown notifications-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-bell-o"></i>
								<span class="label label-warning">10</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">notificações</li>
								<li>
									<ul class="menu">
										<li>
											<a href="#">
												<i class="fa fa-users text-aqua"></i> 5 novos membros cadastrados
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-warning text-yellow"></i> Muito grande a descriçao do paciente X
											</a>
										</li>
										<li>
											<a href="#">
												<i class="fa fa-user text-red"></i> Sua alteração do Perfil
											</a>
										</li>
									</ul>
								</li>
								<li class="footer"><a href="#">ver todos</a></li>
							</ul>
						</li>
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-user"></i>
								<span class="hidden-xs"><?=$this->session->dados_usuario->nome?></span>
							</a>
							<ul class="dropdown-menu">
								<!-- User image -->
								<li class="user-header">
									<i class="fa fa-user fa-5x"></i>
									<p>
										<?=$this->session->dados_usuario->nome?>
										<small>Cadastrado desde Nov. 2016</small>
									</p>
								</li>
								<li class="user-footer">
									<div class="pull-left">
										<a href="#" class="btn btn-default btn-flat">Perfil</a>
									</div>
									<div class="pull-right">
										<a href="<?=base_url()?>logoff" class="btn btn-default btn-flat">Logoff</a>
									</div>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<?php $this->load->view('templates/AdminLTE/sidebar'); ?>
		<div class="content-wrapper">
			<section style="padding: 15px;">
				<div class="msg-prontuario display-none">
					<div class="callout callout-info cursor-pointer" onclick="window.location.href='<?=base_url()?>prontuarios/atendimento/'+Cookies.get('event_id')">
						<h4>Lembrete!</h4>
						<p>Você possui uma consulta em aberto. Clique aqui e continue o atendimento.</p>
					</div>
				</div>
			</section>
			<section class="content-header">
				<!-- <h1><i class="fa fa-home"></i> <?=ucfirst($this->router->fetch_class())?></h1> -->
				<h4 class="titulo"></h4>
				<?php
					echo breadcrumb($this->router->fetch_class(), $this->router->fetch_method());
				?>
			</section>
			<section class="content">
				<?=$conteudo?>
			</section>
		</div>
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Versão</b> 1.0
			</div>
			<strong>Copyright &copy; <?=date('Y')?> <a href="http://pixdata.com.br">PIXDATA</a>.</strong> Todos os Direitos Reservados.
		</footer>
<!-- 		<aside class="control-sidebar control-sidebar-dark">
			<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
				<li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane" id="control-sidebar-home-tab"></div>
				<div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
			</div>
		</aside> -->
		<div class="control-sidebar-bg"></div>
	</div>

	<!-- jQuery UI 1.11.4 -->
	<!--<script src="<?=base_url()?>assets/templates/adminlte/plugins/jQueryUI/jquery-ui.min.js"></script>-->
	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		//$.widget.bridge('uibutton', $.ui.button);
	</script>

	<!--
	Morris.js charts
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="<?=base_url()?>assets/templates/adminlte/plugins/morris/morris.min.js"></script>
	Sparkline
	<script src="<?=base_url()?>assets/templates/adminlte/plugins/sparkline/jquery.sparkline.min.js"></script>
	jvectormap
	<script src="<?=base_url()?>assets/templates/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="<?=base_url()?>assets/templates/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
	jQuery Knob Chart
	<script src="<?=base_url()?>assets/templates/adminlte/plugins/knob/jquery.knob.js"></script>


	daterangepicker
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
	<script src="<?=base_url()?>assets/templates/adminlte/plugins/daterangepicker/daterangepicker.js"></script>

	datepicker
	<script src="<?=base_url()?>assets/templates/adminlte/plugins/datepicker/bootstrap-datepicker.js"></script>

	Bootstrap WYSIHTML5
	<script src="<?=base_url()?>assets/templates/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

	Slimscroll
	<script src="<?=base_url()?>assets/templates/adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>

	FastClick
	<script src="<?=base_url()?>assets/templates/adminlte/plugins/fastclick/fastclick.min.js"></script> -->

	<!-- AdminLTE App -->
	<script src="<?=base_url()?>assets/templates/AdminLTE/dist/js/app.min.js"></script>
	<!-- AdminLTE dashboard demo (This is only for demo purposes)
	<script src="<?=base_url()?>assets/templates/AdminLTE/dist/js/pages/dashboard.js"></script> -->
	<!-- AdminLTE for demo purposes -->
	<script src="<?=base_url()?>assets/templates/AdminLTE/dist/js/demo.js"></script>

	<script type="text/javascript">
		// ##########################################################################
		// BOOTSTRAP-TABLE (Início)
		window.icons = {
			refresh: 'fa-refresh',
			toggle: 'fa-toggle-on',
			columns: 'fa-th-list',
			export: 'fa-download',
		};
		setTimeout(function()
		{
			$('.fixed-table-toolbar').find('.caret').remove();
		}, 500);
		// BOOTSTRAP-TABLE (fim)
		// ##########################################################################
		$(function()
		{
			$('#checkAll').click(function()
			{
				$('.bootstrap-table').bootstrapTable('togglePagination').bootstrapTable('checkAll').bootstrapTable('togglePagination');
			});
			$('#uncheckAll').click(function()
			{
				$('.bootstrap-table').bootstrapTable('togglePagination').bootstrapTable('uncheckAll').bootstrapTable('togglePagination');
			});
			//$('.data').inputmask('dd/mm/yyyy', { "placeholder": "dd/mm/aaaa" });
		});
	</script>
	<style type="text/css">
		.fixed-table-container
		{
			border: 0 !important;
			background-color: #fff !important;
		}
		.fixed-table-pagination
		{
			margin-bottom: 20px;
			border: 0 !important;
		}
		.fixed-table-container thead th .th-inner,
		.fixed-table-container tbody td .th-inner {
			padding: 8px !important;
			line-height: 24px !important;
			vertical-align: top;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}
		.fixed-table-container table
		{
			width: 100%;
			border: 0;
			margin: 0;
			padding: 0;
			border: 1px solid #ddd !important;
		}
		.fixed-table-container thead th
		{
			height: 0;
			padding: 0;
			margin: 0;
			border-left: 1px solid #ddd; /*#ddd*/
			border-bottom: 3px solid #ddd !important; /*#ddd*/
		}
		.fixed-table-container thead th:first-child
		{
			border-left: none;
			border-top-left-radius: 0px;/*4px;*/
			-webkit-border-top-left-radius: 0px;/*4px;*/
			-moz-border-radius-topleft: 0px;/*4px;*/
		}
		.fixed-table-container thead th .th-inner,
		.fixed-table-container tbody td .th-inner
		{
			padding: 8px;
			line-height: 24px;
			vertical-align: top;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}
		.fixed-table-container thead th .sortable
		{
			cursor: pointer;
			background-position: right;
			background-repeat: no-repeat;
			padding-right: 30px;
		}
		.fixed-table-container th.detail
		{
			width: 30px;
		}
		.fixed-table-container tbody td
		{
			border-left: 1px solid #ddd;/*#dddddd;*/
			border-bottom: 1px solid #ddd !important;/*#dddddd;*/
		}
		.fixed-table-container tbody tr:first-child td
		{
			border-top: none;
		}
		.fixed-table-container tbody td:first-child
		{
			border-left: none;
		}
		/* the same color with .active */
		.fixed-table-container tbody .selected td
		{
			background-color: #CED3E3;/*#0088cc;*//*#f5f5f5;*/
			color: #000;
		}
		.fixed-table-container .bs-checkbox
		{
			text-align: center;
		}
		.fixed-table-container .bs-checkbox .th-inner
		{
			padding: 8px 0;
		}
		.fixed-table-container input[type="radio"],
		.fixed-table-container input[type="checkbox"]
		{
			margin: 0 auto !important;
		}
		.fixed-table-container .no-records-found
		{
			text-align: center;
		}
		.fixed-table-container thead th .both
		{
			background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAAFVBMVEXY2Nj////Y2N/l2NjY5fLY2OXf2NiZLZVZAAAAN0lEQVR4AWNgxAHoKsHMil+CgQG7BAMQYNfBxoSpA0oNKgk2JkwJmM/QJOAyOIxiZEGVGNCoBQAzfQK8GH0BKwAAAABJRU5ErkJggg==);
			background-position: right 4px center;
		}
		.fixed-table-container thead th .asc
		{
			background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAAA3NCSVQICAjb4U/gAAAAWlBMVEWZmZn/68WfuN+42Pj///+ZmZ/rxazMxbifmZmsrKzY6/j/+Ni4xcyZmcW4mZnf0szMzMyZmbjF6/+sxev/69KsrL/y2LjMzNjY+P/r0rK/3/ilmZmZmaWszOvorDBfAAAACXBIWXMAAAsSAAALEgHS3X78AAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M26LyyjAAAABZ0RVh0Q3JlYXRpb24gVGltZQAwNy8wNS8xNhzcvagAAABmSURBVCiRY2DBARjoJ8HNJyjBwsLIwEuiBE6jWAQExHEYxQDXiCIhwskpSpodQKMYGIRIkcA0ip9dWoZHHORcIOBCkhDj4OBglYUYxcCMbJQkB4cw2LlAIIUswcLGhGoFPWMQEwAAscwMgEbx788AAAAASUVORK5CYII=');
			background-position: right 4px center;
		}
		.fixed-table-container thead th .desc
		{
			background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAAA3NCSVQICAjb4U/gAAAAWlBMVEWZmZn/68WfuN+42Pj///+ZmZ/rxazMxbifmZmZmbjF6///+NisrNK4xcy4mZnMzMzf0sysrKzY+P/MzNisxev/69Ly2Ljr0rKZmcXS6/+lmZmZmaXMzN+szOum/de1AAAACXBIWXMAAAsSAAALEgHS3X78AAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M26LyyjAAAABZ0RVh0Q3JlYXRpb24gVGltZQAwNy8wNS8xNhzcvagAAABgSURBVCiRY2DBARjoKMHNxynEwsLIAALMJEjgNIqFHwhw2sGFRUJUEAgksRmFx7kweSIlMI0SYJeS5hUGOlcGTUKMg4ODVRZolAS65eIcHCIg5/KgS7CwMaFYQdcYxAAAquELz3IlbwgAAAAASUVORK5CYII=');
			background-position: right 4px center;
		}
	</style>







	<script type="text/javascript">
		status_roda_cronometro = true;
		function roda_cronometro()
		{
			cronometro = Cookies.get('cronometro');
			if( status_roda_cronometro === true )
			{
				cont = cronometro;
				cont = parseInt(cont) + 1;
				Cookies.set('cronometro', cont);

				setTimeout(function()
				{
					roda_cronometro();
				}, 1000);
			}
			else
			{
				Cookies.remove('cronometro');
			}
		}
		if( Cookies.get('prontuario') )
		{
			roda_cronometro();
			if(controller != 'prontuarios')
			{
				$('.msg-prontuario').show();
			}
		}
	</script>
</body>
</html>
