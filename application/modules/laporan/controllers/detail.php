<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detail extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
		$this->page->use_directory();
		$this->load->model('pengaturan/pengaturan_pegawai_model','pengaturan');
		$this->load->model('pegawai_model','pegawai');
	}

	public function index($q = 'na')
	{
		$qd = base64_decode(urldecode($q));
		if (mb_detect_encoding($qd) != 'ASCII') $qd = '';
		
		$qd = explode('#', $qd);
		
		$this->page->view('laporan_detail_pegawai_index', array (
			'q'			=> $q,
			'awal'      => ($qd[0] != '') ? $qd[0] : '',
			'akhir'     => (isset($qd[1])) ? $qd[1] : '',
			'id'		=> (isset($qd[2])) ? $qd[2] : '',
			'header'	=> $this->pengaturan->get_head($q),
			'grid'		=> $this->pegawai->get_detail($q)
		));
	}
	
	public function search()
	{
		$start	= $this->input->post('start_hide');
		$end	= $this->input->post('end_hide');
		$id		= $this->input->post('id_pegawai');
		
		$a = $start.'#'.$end.'#'.$id;
		// print_r($a);die();
		
		$q = urlencode(base64_encode($a));
		redirect($this->page->base_url("index/{$q}"));
	}
		
}
/* End of file Pegawai.php */
/* Location: ./application/modules/laporan/controllers/Detail.php */