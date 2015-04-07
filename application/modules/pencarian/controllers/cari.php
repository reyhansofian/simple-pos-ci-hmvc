<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cari extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
		$this->page->use_directory();
		$this->load->model('pengaturan/barang_model','barang');
	}

	public function index($q = 'na')
	{
		$qd = base64_decode(urldecode($q));
		if (mb_detect_encoding($qd) != 'ASCII') $qd = '';
		
		$this->grid->init(array (
			'base_url'		=> $this->page->base_url('/index/'.$q),
			'act_url'		=> $this->page->base_url(),
			'uri_segment'	=> 5,
			'num_rows'		=> $this->barang->num_rows($qd),
			'items'			=> array (
				'nama' 	=> array('text' => 'Nama'),
				'jenis'	=> array('text' => 'Jenis'),
				'qty'	=> array('text' => 'Qty', 'func' => 'angka'),
				'harga'	=> array('text' => 'Harga', 'func' => 'angka')
			),
			'item'			=> 'b.id',
			'warning'		=> 'nama',
			'checkbox'		=> false,
		));

		$p = $this->grid->params();
		$this->grid->source($this->barang->get($p, $qd));
		
		$this->grid->disable_all_acts();
		
		$this->page->view('cari_index', array (
			'add'		=> $this->page->base_url('tambah'),
			'delete'	=> $this->page->base_url('/multi_delete'),
			'q'			=> $qd,
			'status'	=> $q,
			'grid'		=> $this->grid->draw(),
			'page_link'	=> $this->grid->page_link(),
		));
	}
	
	public function search()
	{
		$this->load->module('pengaturan/barang');
		echo modules::run('pengaturan/barang/search');
	}
	
}
/* End of file Cari.php */
/* Location: ./application/modules/pencarian/controllers/Cari.php */