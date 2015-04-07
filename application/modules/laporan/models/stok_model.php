<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stok_model extends CI_Model {
	
	public function get_stok($keyword)
	{
		if ($keyword == 'na') {
			$where = '';
		} else {
			$q  = base64_decode(urldecode($keyword));
			$qd = explode('#', $q);
			
			$id_barang 	= $qd[0];
			$year		= $qd[1];
			$month		= $qd[2];
			
			if ($month != '0') {
				$where_month = "AND YEAR(ks.tanggal) = '{$year}' AND MONTH(ks.tanggal) = '{$month}'";
			} else {
				$where_month = "AND YEAR(ks.tanggal) = '{$year}'";
			}
			
			$where = "
				WHERE 
					ks.id_barang = '{$id_barang}'
					{$where_month}
				";
		}
		
		$query = "
			SELECT *, DATE(ks.tanggal) AS tgl, TIME(ks.tanggal) AS jam
			FROM kartu_stok ks
			JOIN tmbarang tb ON tb.id = ks.id_barang
			JOIN tmjnsbarang tj ON tj.id = tb.id_jnsbarang
			{$where}
			ORDER BY ks.tanggal
		";
		
		return $this->db->query($query);
	}
	
	public function get_barang($keyword)
	{
		if ($keyword == 'na') {
			$where = '';
		} else {
			$q  = base64_decode(urldecode($keyword));
			$qd = explode('#', $q);
			
			$awal 		= $qd[0];
			$akhir		= $qd[1];
			$id_jenis	= $qd[2];
			
			$where = "
				WHERE 
					DATE(th.tanggal) BETWEEN '{$awal}' AND '{$akhir}'
					AND tj.id = '{$id_jenis}'
			";
		}
		
		$query = "
			SELECT tb.nama, SUM(td.qty) AS qty, SUM(td.subtotal) AS total, DATE(th.tanggal) AS tgl
			FROM ttdjual td
			JOIN tthjual th ON th.id = td.id_tthtransaksi
			JOIN tmbarang tb ON tb.id = td.id_barang
			JOIN tmjnsbarang tj ON tj.id = tb.id_jnsbarang
			{$where}
			GROUP BY tb.id
		";
		
		return $this->db->query($query);
	}
}
/* End of file Stok_model_model.php */
/* Location: ./application/modules/laporan/models/Stok_model_model.php */