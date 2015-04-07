<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends MX_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->page->use_directory();
		$this->load->model('pegawai_model', 'pegawai');
	}

	public function login_form()
	{
		$this->load->module('pegawai');

		$data = array (
			'action' => site_url('pegawai/login'),
		);

		$this->page->template('login_tpl');
		$this->page->view(NULL, $data);
	}

	public function login()
	{
		$no 	  = $this->input->post('no_pegawai');
		$password = $this->input->post('password');

		$id_user = $this->pegawai->login_check($no, $password);

		if ($id_user == 0) {
			$this->session->set_flashdata('login_status', 'failed');

			redirect($this->agent->referrer());
		} else {
			$data = $this->pegawai->by_id($id_user);

			$sess_data = array (
				'id_pengguna'	=> $id_user,
				'nama'      	=> $data->nama,
				'no_pegawai'  	=> $data->no_pegawai
			);

			$this->session->set_userdata($sess_data);

			redirect(base_url('dasbor'));
		}
	}

	public function logout()
	{
		$this->session->destroy();

		redirect(base_url());
	}
}

/* End of file Pegawai.php */
/* Location: ./application/modules/pengguna/controllers/Pegawai.php */