<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengaturan_pegawai_model extends CI_Model {
	
	public $id			= '';
	public $no_pegawai	= '';
	public $nama		= '';
	public $password	= '';
	
	public function by_id($id)
	{
		$src = $this->db->get_where('tmpegawai', array('id' => $id));
		
		return ($src->num_rows() == 0) ? $this : $src->row();
	}
	
	public function get($params, $keyword)
	{
		$query = "
			SELECT *
			FROM tmpegawai
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
			FROM tmpegawai
			WHERE nama LIKE '%{$keyword}%'
		";
		
		return $this->db->query($query)->row()->num_rows;
	}
	
	public function multi_delete($id_list)
	{
		$query = "
			DELETE
			FROM tmpegawai
			WHERE id IN ({$id_list})
		";
		
		$this->db->query($query);
	}
	
	public function get_no()
	{
		$query = "
			SELECT SUBSTRING(no_pegawai, -3) AS no
			FROM tmpegawai
			ORDER BY no_pegawai ASC
		";
		
		return $this->db->query($query)->row('no');
	}
	
	public function get_head($keyword)
	{
		if ($keyword == 'na') {
			$where = '';
		} else {
			$q  = base64_decode(urldecode($keyword));
			$id = explode('#', $q)[2];
			$where = "WHERE id = '{$id}'";
		}
		
		$src = "
			SELECT *
			FROM tmpegawai
			{$where}
		";
		
		return $this->db->query($src)->row();
	}
}
/* End of file Pegawai_model.php */
/* Location: ./application/modules/pengaturan/models/Pengaturan_pegawai_model.php */