<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
	<!-- Sidebar user panel -->
	<div class="user-panel">
		<div class="pull-left image">
			<img src="<?=base_url()?>assets/templates/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle">
		</div>
		<div class="pull-left info">
			<?=$this->session->dados_usuario->nome?>
			<div style="margin-top:10px;"><small><i class="fa fa-circle text-success"></i> Online</small></div>
		</div>
	</div>
	<!-- search form -->
	<form action="#" method="get" class="sidebar-form">
		<div class="input-group">
			<input type="text" name="q" class="form-control" placeholder="Pesquisar...">
			<span class="input-group-btn">
				<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
			</span>
		</div>
	</form>
	<!-- /.search form -->
	<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu">
		<li class="header">NAVEGAÇÃO</li>
		<li><a href="<?=base_url()?>"><i class="fa fa-home"></i> <span>Home</span></a></li>
		<li><a href="<?=base_url()?>pacientes"><i class="fa fa-user"></i> <span>Pacientes</span></a></li>
		<li><a href="<?=base_url()?>agenda"><i class="fa fa-th"></i> <span>Agenda</span></a></li>
		<li><a href="<?=base_url()?>medicamentos"><i class="fa fa-eyedropper" aria-hidden="true"></i> <span>Medicamentos</span></a></li>
		<li><a href="<?=base_url()?>bulas"><i class="fa fa-eyedropper" aria-hidden="true"></i> <span>Bulas</span></a></li>
		<li><a href="<?=base_url()?>cid10"><i class="fa fa-book"></i> <span>CID 10</span></a></li>
		<li><a href="<?=base_url()?>tiss"><i class="fa fa-wpforms"></i> <span>Tiss</span></a></li>
		<li><a href="#"><i class="fa fa-question-circle"></i> <span>Ajuda</span></a></li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-cog"></i> <span>Configurações</span>
			</a>
			<ul class="treeview-menu menu-open" style="display: none;">
				<li><a href="<?=base_url()?>cartasatestados"><i class="fa fa-clipboard"></i> <span>Cartas e atestados</span></a></li>
				<li><a href="<?=base_url()?>anamneses"><i class="fa fa-ambulance"></i> <span>Anamneses</span></a></li>
				<li><a href="<?=base_url()?>expediente"><i class="fa fa-calendar"></i> <span>Expediente</span></a></li>
				<li><a href="<?=base_url()?>modelosprescricoes"><i class="fa fa-file-text-o"></i> Prescrições</a></li>
			</ul>
		</li>
	</ul>
</section>
<!-- /.sidebar -->
</aside>