<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
		$this->page->use_directory();
		$this->load->model('pengaturan/barang_model', 'barang');
		$this->load->model('penjualan_model','penjualan');
	}

	public function index()
	{
		$this->page->view('penjualan_index', array(
			'nomor'	=> 'P'.date('ym').str_pad($this->penjualan->get_no() + 1, 3, '0', STR_PAD_LEFT)
		));
	}
	
	public function autocomplete()
	{
		$q = strtolower($_GET["q"]);
		
		if ( ! $q)
		{
			return FALSE;
		}
		
		$source = $this->barang->autocomplete($q);
		
		$items	= array();
		
		if ($source->num_rows() > 0){
			foreach ($source->result() as $s){
				echo "$s->nama|$s->id|$s->harga\n";
			}
		}
	}
	
	public function simpan()
	{
		$data		= $this->input->post('data');
		$totalQty 	= (int)$this->input->post('qty');
		$total		= strip_harga($this->input->post('total'));
		$no_nota	= $this->input->post('no');
		
		// Simpan header transaksi
		$header = array (
			'no_nota'		=> $no_nota,
			'total_qty'		=> $totalQty,
			'total'			=> $total,
			'id_pegawai'	=> $this->session->userdata('id_pengguna')
		);
		
		$this->db->insert('tthjual', $header);
		$id_penjualan = $this->db->insert_id();
		
		foreach ($data as $key => $value) {
			$id[]		= $value[6];
			$harga[]	= $value[2];
			$qty[]		= $value[3];
			$subtotal[]	= strip_harga($value[4]);
		}
		
		foreach ($id as $key => $val) {
			// Simpan detail transaksi
			$detail[] = array(
				'id_tthtransaksi'	=> $id_penjualan,
				'id_barang'			=> $val,
				'qty'				=> $qty[$key],
				'subtotal'			=> $subtotal[$key]
			);
			
			// Simpan kartu stok
			$kartu[] = array(
				'id_barang'		=> $val,
				'qty_masuk'		=> 0,
				'qty_keluar'	=> $qty[$key],
				'id_pegawai'	=> $this->session->userdata('id_pengguna')
			);
			
			// Mengurangi stok barang
			$stok = $this->db->get_where('tmbarang', array('id' => $val))->row();
			
			$barang = array (
				'qty'	=> $stok->qty - $qty[$key]
			);
			
			$this->db->update('tmbarang', $barang, array('id' => $val));
		}
		
		$this->db->insert_batch('ttdjual', $detail);
		$this->db->insert_batch('kartu_stok', $kartu);
		
		$redir = array (
			'pdf'	=> site_url("cetak/pdf/index/{$id_penjualan}/penjualan"),
			'trans'	=> $this->page->base_url()
		);
		
		echo json_encode($redir);
	}
}
/* End of file Penjualan.php */
/* Location: ./application/modules/transaksi/controllers/Penjualan.php */