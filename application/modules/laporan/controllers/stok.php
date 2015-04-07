<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stok extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
		$this->page->use_directory();
		$this->load->model('stok_model','stok');
		$this->load->model('pengaturan/barang_model', 'barang');
	}

	public function index($q = 'na')
	{
		$qd = base64_decode(urldecode($q));
		if (mb_detect_encoding($qd) != 'ASCII') $qd = '';
		
		$qd = explode('#', $qd);
		
		$this->page->view('laporan_stok_index', array(
			'q'			=> $q,
			'id_barang' => ($qd[0] != '') ? $qd[0] : '',
			'year'      => (isset($qd[1])) ? $qd[1] : '',
			'month'      => (isset($qd[2])) ? $qd[2] : '',
			'grid'      => $this->stok->get_stok($q),
			'header'	=> $this->barang->get_header_barang($q)
		));
	}
	
	public function search()
	{
		$id_barang	= $this->input->post('id_barang');
		$period		= $this->input->post('radio');
		$waktu		= $this->input->post('periode_hide');
		
		if ($period === 'years') {
			$exp = explode('-', $waktu);
			$year  = $exp[0];
			$month = '0';
		} else {
			$exp = explode('-', $waktu);
			$year  = $exp[0];
			$month = $exp[1];
		}
		
		$a = $id_barang.'#'.$year.'#'.$month;
		
		$q = urlencode(base64_encode($a));
		redirect($this->page->base_url("index/{$q}"));
	}
	
}
/* End of file Stok.php */
/* Location: ./application/modules/laporan/controllers/Stok.php */