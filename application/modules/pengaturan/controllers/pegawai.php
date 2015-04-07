<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
		$this->page->use_directory();
		$this->load->model('pengaturan_pegawai_model','pegawai');
	}

	public function index($q = 'na')
	{
		$qd = base64_decode(urldecode($q));
		if (mb_detect_encoding($qd) != 'ASCII') $qd = '';
		
		$this->grid->init(array (
			'base_url'		=> $this->page->base_url('/index/'.$q),
			'act_url'		=> $this->page->base_url(),
			'uri_segment'	=> 5,
			'num_rows'		=> $this->pegawai->num_rows($qd),
			'items'			=> array (
				'no_pegawai'	=> array('text' => 'No. Pegawai'),
				'nama' 			=> array('text' => 'Nama', 'func' => 'uc_first'),
				// 'role'			=> array('text' => 'Hak Akses')
			),
			'item'			=> 'id',
			'warning'		=> 'nama',
		));

		$p = $this->grid->params();
		$this->grid->source($this->pegawai->get($p, $qd));
		
		$this->page->view('pegawai_index', array (
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
		
		if ( ! is_numeric($this->pegawai->get_no())) {
			$no = date('yn').str_pad('1', 3, '0', STR_PAD_LEFT);
		} else {
			$no = date('yn').str_pad((int)$this->pegawai->get_no() + 1, 3, '0', STR_PAD_LEFT);
		}
		
		$data = array (
			'back'		=> $this->agent->referrer(),
			'action' 	=> $this->page->base_url("/{$action}/{$id}"),
			'pegawai'	=> $this->pegawai->by_id($id),
			'nomor'		=> $no,
			'aksi'		=> $action
		);
		
		$this->page->view('pegawai_form', $data);
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
		$names = array('nama', 'no_pegawai', 'password');
		return form_data($names);
	}
	
	public function insert()
	{
		if ( ! $this->input->post()) show_404();
		
		$data = $this->form_data();
		
		$data['password'] = password($data['password']);
		$data['role'] = 'pegawai';
		
		$this->db->insert('tmpegawai', $data);
		
		$this->session->set_flashdata('status', 'success');
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
		unset($data['password']);
		
		$this->db->update('tmpegawai', $data, array('id' => $id));
		redirect($this->page->base_url());
	}
	
	public function hapus($id)
	{
		if ($this->agent->referrer() == '') show_404();
		
		if ($id == 1) {
			$this->session->set_flashdata('status', 'forbidden');
		} else {
			$this->db->delete('tmpegawai', array('id' => $id));
		}
		
		redirect($this->agent->referrer());
	}
	
	public function multi_delete()
	{
		$row_id = $this->input->post('row_id');
		$id_list = "'".implode("','", $row_id)."'";
		$this->pegawai->multi_delete($id_list);
		redirect($this->agent->referrer());
	}

	public function options($id)
	{
		$src = $this->db->order_by('id')->get('tmpegawai');
		return options($src, 'id', $id, 'nama');
	}
}
/* End of file Pegawai.php */
/* Location: ./application/modules/pengaturan/controllers/Pegawai.php */