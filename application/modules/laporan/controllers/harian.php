<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Harian extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
		$this->page->use_directory();
		$this->load->model('transaksi/penjualan_model','penjualan');
	}

	public function index($q = 'na')
	{
		$qd = base64_decode(urldecode($q));
		if (mb_detect_encoding($qd) != 'ASCII') $qd = '';
		
		$qd = explode('#', $qd);
		
		$this->grid->init(array (
			'base_url'		=> $this->page->base_url('/index/'.$q),
			'act_url'		=> $this->page->base_url(),
			'uri_segment'	=> 5,
			'num_rows'		=> $this->penjualan->num_rows_harian($q),
			'items'			=> array (
				'tgl' 			=> array('text' => 'Tanggal', 'func' => 'text_date'),
				'no_nota'		=> array('text' => 'No. Nota'),
				'total_qty'		=> array('text' => 'Qty', 'func' => 'angka', 'align' => 'center'),
				'total'			=> array('text' => 'Total', 'func' => 'angka', 'align' => 'right'),
				'nama_pegawai'	=> array('text' => 'Pegawai')
			),
			'item'			=> 'id',
			'warning'		=> 'nama_pegawai',
			'checkbox'		=> false
		));

		$p = $this->grid->params();
		$this->grid->source($this->penjualan->get_harian($p, $q));
		
		$this->grid->action_show(array('hapus' => FALSE, 'ubah' => FALSE));
		
		$actions['detail'] = array (
			'show'	=> TRUE,
			'title'	=> 'Lihat Detail Penjualan',
			'icon'	=> 'fa fa-book'
		);
		
		$this->grid->add_actions($actions);
		
		$this->page->view('laporan_penjualan_harian_index', array (
			'q'			=> $qd,
			'grid'		=> $this->penjualan->get_lap_harian(),
			'page_link'	=> $this->grid->page_link(),
			'awal'      => ($qd[0] != '') ? $qd[0] : '',
			'akhir'     => (isset($qd[1])) ? $qd[1] : '',
		));
	}
	
	public function search()
	{
		$start	= $this->input->post('start_hide');
		$end	= $this->input->post('end_hide');
		
		$a = $start.'#'.$end;
		
		$q = urlencode(base64_encode($a));
		redirect($this->page->base_url("index/{$q}"));
	}

	public function detail($id)
	{
		$data = array (
			'back'		=> $this->agent->referrer(),
			'id'		=> $id,
			'header'	=> $this->penjualan->header_detail($id),
			'detail'	=> $this->penjualan->detail($id)
		);
		
		$this->page->view('laporan_penjualan_detail', $data);
	}
}
/* End of file Harian.php */
/* Location: ./application/modules/laporan/controllers/Harian.php */