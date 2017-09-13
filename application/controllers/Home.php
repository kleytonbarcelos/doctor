<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Home extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();

			$this->load->model('medicamento_model');
		}
		public function index()
		{
			$this->template->load('AdminLTE/index', 'home/home');
		}
		public function ms()
		{
			for($i=0; $i<6; $i++)
			{
				sleep(1);
				$rand = rand(1,60);
				echo '&nbsp;&nbsp;-&nbsp;&nbsp;'.$rand;
			}
		}
		public function ans()
		{
			$this->template->load('AdminLTE/index', 'home/ans');
		}
		public function jspdf()
		{
			$this->template->load('AdminLTE/index', 'home/old/jspdf');
		}
	}