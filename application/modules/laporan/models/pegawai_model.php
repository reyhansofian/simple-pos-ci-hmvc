<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_model extends CI_Model {
	
	public function get($keyword)
	{
		if ($keyword == 'na') {
			$where = '';
		} else {
			$q  = base64_decode(urldecode($keyword));
			$qd = explode('#', $q);
			
			$awal		= $qd[0];
			$akhir		= $qd[1];
			$id_pegawai	= $qd[2];
			
			$where = "
				WHERE 
					DATE(tanggal) BETWEEN '{$awal}' AND '{$akhir}'
					AND id_pegawai = '{$id_pegawai}'
				";
		}
		
		$query = "
			SELECT *, DATE(tanggal) AS tgl, TIME(tanggal) AS jam
			FROM tthjual
			{$where}
		";
		
		return $this->db->query($query);
	}
	
	public function get_detail($keyword)
	{
		if ($keyword == 'na') {
			$where = '';
		} else {
			$q  = base64_decode(urldecode($keyword));
			$qd = explode('#', $q);
			
			$awal		= $qd[0];
			$akhir		= $qd[1];
			$id_pegawai	= $qd[2];
			
			$where = "
				WHERE 
					DATE(th.tanggal) BETWEEN '{$awal}' AND '{$akhir}'
					AND th.id_pegawai = '{$id_pegawai}'
				";
		}
		
		$query = "
			SELECT DATE(th.tanggal) AS tgl, td.*, tb.nama AS nama_barang, tj.nama AS nama_jenis
			FROM tthjual th
			JOIN ttdjual td ON th.id = td.id_tthtransaksi
			JOIN tmbarang tb ON tb.id = td.id_barang
			JOIN tmjnsbarang tj ON tj.id = tb.id_jnsbarang
			{$where}
		";
		
		return $this->db->query($query);
	}
}
/* End of file Pegawai_model_model.php */
/* Location: ./application/modules/laporan/models/Pegawai_model_model.php */