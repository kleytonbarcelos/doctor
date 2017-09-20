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
				$tmp[] = rand(1,60);
			}
			sort($tmp);
			foreach ($tmp as $key => $value)
			{
				$str = ($key==0) ? $value : '&nbsp;&nbsp;-&nbsp;&nbsp;'.$value;
				
				echo $str;
			}
		}
		public function ans()
		{
			$this->template->load('AdminLTE/index', 'home/ans');
		}
	}