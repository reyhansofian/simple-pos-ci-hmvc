<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
		$this->page->use_directory();
		$this->load->model('jenis_model','jenis');
	}

	public function index($q = 'na')
	{
		$qd = base64_decode(urldecode($q));
		if (mb_detect_encoding($qd) != 'ASCII') $qd = '';
		
		$this->grid->init(array (
			'base_url'		=> $this->page->base_url('/index/'.$q),
			'act_url'		=> $this->page->base_url(),
			'uri_segment'	=> 5,
			'num_rows'		=> $this->jenis->num_rows($qd),
			'items'			=> array (
				'nama' => array('text' => 'Nama'),
			),
			'item'			=> 'id',
			'warning'		=> 'nama',
		));

		$p = $this->grid->params();
		$this->grid->source($this->jenis->get($p, $qd));
		
		$this->page->view('jenis_index', array (
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
			'jenis'		=> $this->jenis->by_id($id),
		);
		
		$this->page->view('jenis_form', $data);
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
		$names = array('nama');
		return form_data($names);
	}
	
	public function insert()
	{
		if ( ! $this->input->post()) show_404();
		
		$data = $this->form_data();
		
		$this->db->insert('tmjnsbarang', $data);
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
		
		$this->db->update('tmjnsbarang',$data, array('id' => $id));
		redirect($this->page->base_url());
	}
	
	public function hapus($id)
	{
		if ($this->agent->referrer() == '') show_404();
		$this->db->delete('tmjnsbarang', array('id' => $id));
		redirect($this->agent->referrer());
	}
	
	public function multi_delete()
	{
		$row_id = $this->input->post('row_id');
		$id_list = "'".implode("','", $row_id)."'";
		$this->jenis->multi_delete($id_list);
		redirect($this->agent->referrer());
	}
	
	public function options($id)
	{
		$jenis = $this->db->order_by('id')->get('tmjnsbarang');
		return options($jenis, 'id', $id, 'nama');
	}
}
/* End of file Jenis.php */
/* Location: ./application/modules/pengaturan/controllers/Jenis.php */