<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Jspdf extends MY_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function index()
		{
			$this->template->load('AdminLTE/index', 'home/old/jspdf');
		}
	}