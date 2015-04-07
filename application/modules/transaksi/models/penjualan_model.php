<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan_model extends CI_Model {
	
	public function get_no()
	{
		$query = "
			SELECT CONVERT(SUBSTRING(no_nota,-3),UNSIGNED INTEGER) AS akhir, SUBSTRING(no_nota, 2, 4) AS bln
			FROM tthjual 
			ORDER BY id DESC
		";
		
		$src = $this->db->query($query);
		
		if ($src->num_rows() != 0) {
			$kode = ($src->row()->bln != date('ym')) ? '0' : $src->row()->akhir;
		} else {
			$kode = '0';
		}
		
		return $kode;
	}
	
	public function get_pdf($id)
	{
		$query = "
			SELECT th.*, tb.nama AS nama_barang, tb.harga, td.*
			FROM tthjual th
			JOIN ttdjual td ON th.id = td.id_tthtransaksi
			JOIN tmbarang tb ON tb.id = td.id_barang
			WHERE th.id = '{$id}'
		";
		
		return $this->db->query($query);
	}
	
	public function get_total($id)
	{
		$query = $this->db->get_where('tthjual', array('id' => $id))->row();
		
		return $query;
	}
	
	public function get($params, $keyword)
	{
		$q = base64_decode(urldecode($keyword));
		$qd = explode('#', $q);

		if ($keyword == 'na' OR ($qd[0] == '' AND $qd[1] == '')) {
			$where = "";
		} else {
			$where = "WHERE DATE(th.tanggal) BETWEEN '{$qd[0]}' AND '{$qd[1]}'";
		}
		
		$query = "
			SELECT th.*, DATE(th.tanggal) AS tgl, tp.nama AS nama_pegawai
			FROM tthjual th
			JOIN tmpegawai tp ON tp.id = th.id_pegawai
			{$where}
			ORDER BY {$params['item']} {$params['order']}
			LIMIT {$params['offset']}, {$params['limit']}
		";
		
		return $this->db->query($query);
	}
	
	public function get_lap_harian()
	{
		
		$query = "
			SELECT th.*, DATE(th.tanggal) AS tgl, tp.nama AS nama_pegawai
			FROM tthjual th
			JOIN tmpegawai tp ON tp.id = th.id_pegawai
			WHERE DATE(th.tanggal) = DATE(NOW())
		";
		
		return $this->db->query($query);
	}
	
	public function num_rows($keyword)
	{
		$q = base64_decode(urldecode($keyword));
		$qd = explode('#', $q);

		if ($keyword == 'na' OR ($qd[0] == '' AND $qd[1] == '')) {
			$where = "";
		} else {
			$where = "WHERE DATE(th.tanggal) BETWEEN '{$qd[0]}' AND '{$qd[1]}'";
		}
		
		$query = "
			SELECT COUNT(th.id) AS num_rows
			FROM tthjual th
			JOIN tmpegawai tp ON tp.id = th.id_pegawai
			{$where}
		";
		
		return $this->db->query($query)->row()->num_rows;
	}
	
	public function header_detail($id)
	{
		$query = $this->db
							->select('th.*, tp.nama AS nama_pegawai, DATE(th.tanggal) AS tgl, TIME(th.tanggal) AS jam')
							->join('tmpegawai tp','th.id_pegawai = tp.id')
			 				->get_where('tthjual th', array('th.id' => $id))->row();
							
		return $query;
	}
	
	public function detail($id)
	{
		$query = "
			SELECT tb.nama AS nama_barang, tb.harga, td.* 
			FROM tthjual th
			JOIN ttdjual td ON th.id = td.id_tthtransaksi
			JOIN tmbarang tb ON tb.id = td.id_barang
			WHERE th.id = '{$id}'
		";
		
		return $this->db->query($query);
	}
	
	public function get_harian($params, $keyword)
	{		
		$query = "
			SELECT th.*, DATE(th.tanggal) AS tgl, tp.nama AS nama_pegawai
			FROM tthjual th
			JOIN tmpegawai tp ON tp.id = th.id_pegawai
			WHERE DATE(th.tanggal) = DATE(NOW())
			ORDER BY {$params['item']} {$params['order']}
			LIMIT {$params['offset']}, {$params['limit']}
		";
		
		return $this->db->query($query);
	}
	
	public function num_rows_harian($keyword)
	{
		$query = "
			SELECT COUNT(th.id) AS num_rows
			FROM tthjual th
			JOIN tmpegawai tp ON tp.id = th.id_pegawai
			WHERE DATE(th.tanggal) = DATE(NOW())
		";
		
		return $this->db->query($query)->row()->num_rows;
	}
}
/* End of file Penjualan_model_model.php */
/* Location: ./application/modules/transaksi/models/Penjualan_model_model.php */