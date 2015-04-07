<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barang_model extends CI_Model {
	
	public $id				= '';
	public $nama			= '';
	public $id_jnsbarang	= '';
	public $qty				= '';
	public $harga			= '';
	
	public function by_id($id)
	{
		$src = $this->db->get_where('tmbarang', array('id' => $id));
		
		return ($src->num_rows() == 0) ? $this : $src->row();
	}
	
	public function get($params, $keyword)
	{
		$query = "
			SELECT b.*, j.nama AS jenis
			FROM tmbarang b
			JOIN tmjnsbarang j ON j.id = b.id_jnsbarang
			WHERE b.nama LIKE '%{$keyword}%'
			ORDER BY {$params['item']} {$params['order']}
			LIMIT {$params['offset']}, {$params['limit']}
		";
		
		return $this->db->query($query);
	}
	
	public function num_rows($keyword)
	{
		$query = "
			SELECT COUNT(b.id) AS num_rows
			FROM tmbarang b
			JOIN tmjnsbarang j ON j.id = b.id_jnsbarang
			WHERE b.nama LIKE '%{$keyword}%'
		";
		
		return $this->db->query($query)->row()->num_rows;
	}
	
	public function multi_delete($id_list)
	{
		$query = "
			DELETE
			FROM tmbarang
			WHERE id IN ({$id_list})
		";
		
		$this->db->query($query);
	}
	
	public function autocomplete($q)
	{
		$query = "
			SELECT *
			FROM tmbarang
			WHERE nama LIKE '%{$q}%'
			ORDER BY nama
			LIMIT 20
		";
		
		return $this->db->query($query);
	}
	
	public function get_header_barang($keyword)
	{
		if ($keyword == 'na') {
			$where = '';
		} else {
			$q  = base64_decode(urldecode($keyword));
			$where = "WHERE tb.id = '{$q}'";
		}
			
		$src = "
			SELECT tb.*, tj.nama AS nama_jenis
			FROM tmbarang tb
			JOIN tmjnsbarang tj ON tj.id = tb.id_jnsbarang
			{$where}
		";
		
		return $this->db->query($src)->row();
	}
}
/* End of file Barang_model.php */
/* Location: ./application/modules/pengaturan/models/Barang_model.php */