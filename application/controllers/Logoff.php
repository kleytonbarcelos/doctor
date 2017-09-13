<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Logoff extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function index()
		{
			unset($_SESSION['dados_usuario']);
			redirect('home','refresh');
		}
	}