<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
		$this->page->use_directory();
		$this->load->model('pengaturan/jenis_model', 'jenis');
		$this->load->model('stok_model', 'stok');
	}

	public function index($q = 'na')
	{
		$qd = base64_decode(urldecode($q));
		if (mb_detect_encoding($qd) != 'ASCII') $qd = '';
		
		$qd = explode('#', $qd);
		
		$this->page->view('laporan_barang_index', array (
			'q'			=> $q,
			'awal'      => ($qd[0] != '') ? $qd[0] : '',
			'akhir'     => (isset($qd[1])) ? $qd[1] : '',
			'id'		=> (isset($qd[2])) ? $qd[2] : '',
			'header'	=> $this->jenis->get_header_jenis($q),
			'grid'		=> $this->stok->get_barang($q)
		));
	}
	
	public function search()
	{
		$start	= $this->input->post('start_hide');
		$end	= $this->input->post('end_hide');
		$id		= $this->input->post('id_jenis');
		
		$a = $start.'#'.$end.'#'.$id;
		
		$q = urlencode(base64_encode($a));
		redirect($this->page->base_url("index/{$q}"));
	}
		
}
/* End of file Pegawai.php */
/* Location: ./application/modules/laporan/controllers/Barang.php */