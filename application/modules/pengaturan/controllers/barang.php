<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
		$this->page->use_directory();
		$this->load->model('barang_model','barang');
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
		));

		$p = $this->grid->params();
		$this->grid->source($this->barang->get($p, $qd));
		
		$this->page->view('barang_index', array (
			'add'		=> $this->page->base_url('tambah'),
			'delete'	=> $this->page->base_url('/multi_delete'),
			'q'			=> $qd,
			'grid'		=> $this->grid->draw(),
			'page_link'	=> $this->grid->page_link(),
		));
	}
	
	private function form($action = 'insert', $id = '')
	{
		if ($this->agent->referrer() == '') redirect($this->page->base_url());
		
		$data = array (
			'back'		=> $this->agent->referrer(),
			'action' 	=> $this->page->base_url("/{$action}/{$id}"),
			'barang'	=> $this->barang->by_id($id),
		);
		
		$this->page->view('barang_form', $data);
	}
	
	public function search()
	{
		$q = $this->input->post('q');
		$q = urlencode(base64_encode($q));
		redirect($this->page->base_url('/index/'.$q));
	}
	
	public function tambah()
	{
		$this->form();
	}
	
	private function form_data()
	{
		$names = array('nama', 'id_jnsbarang', 'qty', 'harga');
		return form_data($names);
	}
	
	public function insert()
	{
		if ( ! $this->input->post()) show_404();
		
		$data = $this->form_data();
		
		$data['harga'] = str_replace('.', '', $data['harga']);
		
		$this->db->insert('tmbarang', $data);
		
		$id_barang = $this->db->insert_id();
		
		// Insert kartu stok
		$stok = array (
			'id_barang'		=> $id_barang,
			'qty_masuk'		=> $data['qty'],
			'qty_keluar'	=> 0,
			'id_pegawai'	=> $this->session->userdata('id_pengguna')
		);
		
		$this->db->insert('kartu_stok',$stok);
		
		redirect($this->page->base_url());
	}

	public function ubah($id)
	{
		$this->form('update', $id);
	}
	
	public function update($id)
	{
		if ( ! $this->input->post()) show_404();
		
		$data = $this->form_data();
		
		$this->db->update('tmbarang',$data, array('id' => $id));
		redirect($this->page->base_url());
	}
	
	public function hapus($id)
	{
		if ($this->agent->referrer() == '') show_404();
		$this->db->delete('tmbarang', array('id' => $id));
		redirect($this->agent->referrer());
	}
	
	public function multi_delete()
	{
		$row_id = $this->input->post('row_id');
		$id_list = "'".implode("','", $row_id)."'";
		$this->barang->multi_delete($id_list);
		redirect($this->agent->referrer());
	}

	public function options($id)
	{
		$barang = $this->db->order_by('id')->get('tmbarang');
		return options($barang, 'id', $id, 'nama');
	}
}
/* End of file Barang.php */
/* Location: ./application/modules/pengaturan/controllers/Barang.php */