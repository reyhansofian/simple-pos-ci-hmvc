<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_model extends CI_Model {
	
	public $id		= '';
	public $nama	= '';
	
	public function by_id($id)
	{
		$src = $this->db->get_where('tmjnsbarang', array('id' => $id));
		
		return ($src->num_rows() == 0) ? $this : $src->row();
	}
	
	public function get($params, $keyword)
	{
		$query = "
			SELECT *
			FROM tmjnsbarang
			WHERE nama LIKE '%{$keyword}%'
			ORDER BY {$params['item']} {$params['order']}
			LIMIT {$params['offset']}, {$params['limit']}
		";
		
		return $this->db->query($query);
	}
	
	public function num_rows($keyword)
	{
		$query = "
			SELECT COUNT(id) AS num_rows
			FROM tmjnsbarang
			WHERE nama LIKE '%{$keyword}%'
		";
		
		return $this->db->query($query)->row()->num_rows;
	}
	
	public function multi_delete($id_list)
	{
		$query = "
			DELETE
			FROM tmjnsbarang
			WHERE id IN ({$id_list})
		";
		
		$this->db->query($query);
	}
	
	public function get_header_jenis($keyword)
	{
		if ($keyword == 'na') {
			$where = '';
		} else {
			$q  = base64_decode(urldecode($keyword));
			$qd = explode('#', $q);
			
			$awal 		= $qd[0];
			$akhir		= $qd[1];
			$id_jenis	= $qd[2];
			
			$where = "WHERE id = '{$id_jenis}'";
		}
			
		$src = "
			SELECT *
			FROM tmjnsbarang 
			{$where}
		";
		
		return $this->db->query($src)->row();
	}
}
/* End of file Jenis_model_model.php */
/* Location: ./application/modules/pengaturan/models/Jenis_model_model.php */