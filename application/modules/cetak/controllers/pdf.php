<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pdf extends MX_Controller {
  
	function __construct()
	{
		parent::__construct();
	}

	public function index($id, $view)
	{
		$this->load->model('transaksi/'.$view.'_model', $view);
		$this->load->library('nota');
		
		$title = "NOTA PENJUALAN PER ".strtoupper(text_date(date('Y-m-d')));

		$data = array (
			'data'  => $this->$view->get_pdf($id),
			'total' => $this->$view->get_total($id),
			'title' => $title,
		);
		
		$content = $this->load->view('cetak/'.$view.'_pdf', $data, true);
		$this->nota->create_pdf($content, $title);
	}
}
/* End of file Pdf.php */
/* Location: ./application/modules/cetak/controllers/Pdf.php */