<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_Model extends CI_Model {

	public $id          = '';
	public $no_pegawai  = '';
	public $nama        = '';
	public $password    = '';

	public function by_id($id)
	{
		$src = $this->db->get_where('tmpegawai', array('id' => $id));

		return ($src->num_rows() == 0) ? $this : $src->row();
	}

	public function login_check($no, $password)
	{
		$src = $this->db->get_where('tmpegawai', array(
					'no_pegawai'   	=> $no,
					'password' 		=> password($password)
				));

		return ($src->num_rows() == 0) ? 0 : $src->row('id');
	}
}
/* End of file Pegawai_Model.php */
/* Location: ./application/models/Pegawai_Model.php */