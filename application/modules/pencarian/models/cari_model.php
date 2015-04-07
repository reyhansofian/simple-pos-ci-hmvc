<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cari_model extends CI_Model {
	
	public function ajax_source($where = '', $length = 10, $iDisplayStart = 0)
	{
		// Get data
		$data = "
			SELECT tb.*, tj.nama AS nama_jenis
			FROM tmbarang tb
			JOIN tmjnsbarang tj ON tj.id = tb.id_jnsbarang
			WHERE tb.nama LIKE '%{$where}%'
			LIMIT {$iDisplayStart}, {$length}
		";
		
		$query = $this->db->query($data);
		
		// Get total data
		$total = "
			SELECT tb.*, tj.nama AS nama_jenis
			FROM tmbarang tb
			JOIN tmjnsbarang tj ON tj.id = tb.id_jnsbarang
			WHERE tb.nama LIKE '%{$where}%'
		";
		
		$iTotal = $this->db->query($total);
		
		// Untuk tampilan info
		$output = array (
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $query->num_rows(),
			"iTotalDisplayRecords" => $iTotal->num_rows(),
			"aaData" => array()
		);
		
		$row = array ();
		
		$x = 1 + $iDisplayStart;
		foreach ($query->result() as $query){
			$row[] = array (
				$x.'.',
				$query->nama,
				$query->nama_jenis,
				angka($query->qty),
				'Rp. '.angka($query->harga)
			);
			
			$x++;
		}
		
		$output['aaData'] = $row;
		return $output;
	}
}
/* End of file Cari_model_model.php */
/* Location: ./application/modules/pencarian/models/Cari_model_model.php */