<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
		login_check();
		$this->load->dbutil();
	}

	public function index()
	{
		$db = $this->db->database;
		
		if ($db == '') {
			redirect(base_url('install'));
		} else {
			$this->load->module('pegawai');
			echo modules::run('pegawai/login_form');
		}
	}
}
/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */