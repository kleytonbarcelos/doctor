<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Log_model extends MY_Model
	{
		public $_table = 'logs';
		public $primary_key = 'id';
	}